app.controller('UserAddCtrl', function($scope, $http, $location, noty, $UserService, $GroupService, $SponsorService) {
  $scope.editing = false;
  
  $scope.user = {};
  $scope.sponsor_check = {};
  
  $scope.processing = false;
  
  $scope.init = function() {
    $GroupService.get_list().then(function(response) {
      $scope.groups = response.data.groups;
    });
  };
  
  $scope.disabled = function() {
    if (!$scope.user.user_name || !$scope.user.display_name || !$scope.user.email || !$scope.user.mobile || 
      !$scope.user.sponsor_owner || !$scope.user.group_id || $scope.processing) {
      return true;
    };
    
    return $scope.user.user_name.length > 0 && $scope.user.display_name.length > 0 && $scope.user.email.length > 0 && 
      $scope.user.mobile.length > 0 && $scope.user.sponsor_owner.length > 0 && $scope.user.group_id > 0 ? false : true;
    
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $UserService.add($scope.user).then(function(response) {
      var data = response.data;
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      $scope.processing = false;
    }); 
  };
  
});

app.controller('UserEditCtrl',  function($scope, $routeParams, $http, $UserService, $GroupService, $SponsorService) {
    $scope.processing = false;
    
    $scope.user = {};
    
    $scope.user.id = $routeParams.id;
    
    $scope.init = function() {
      $GroupService.get_list().then(function(response) {
        $scope.groups = response.data.groups;
      });
      
      $UserService.view($scope.user.id).then(function(response) {
        $scope.user = response.data.user;
        if ($scope.user && $scope.user.block) {
          $scope.user.block = $scope.user.block == 1? true: false;
        }
      });
    };
    
    $scope.disabled = function() {
      if (!$scope.user.display_name || !$scope.user.mobile || 
        !$scope.user.sponsor_owner || !$scope.user.group_id || $scope.processing) {
        return true;
      };
      
      return $scope.user.display_name.length > 0 && 
        $scope.user.mobile.length > 0 && $scope.user.sponsor_owner.length > 0 && $scope.user.group_id > 0  ? false : true;
      
    };
  
   $scope.submit = function() {
     $scope.message = '';
     $scope.message_type = 1;
     $scope.processing = true;
    
     $UserService.edit($scope.user).then(function(response) {
       $scope.processing = false;
       $scope.message_type = response.data.type;
       $scope.message = response.data.message;
     });
   };
   
   $scope.show_mobile = function(user) {
     var options = {
       'init': function (mscope) {
         mscope.loading = false;
         $UserService.get_list_mobile(user).then(function(response) {
            mscope.gcms = response.data.gcms;
            mscope.total = response.data.total;
         });
       },
       'ok': function (mscope) {
         
       }
     };
     
     $UserService.show_mobile_modal(user, options).then(function(response) {
       
     });
   };
});

app.controller('UserListCtrl', function($scope, $http, $location, noty, $UserService, $GroupService, $SponsorService) {
  $scope.editing = false;
  $scope.loading = false;
  $scope.noty = noty;
  $scope.user = {};
  $scope.myData = [];
  
  $scope.processing = false;
  
  $scope.init = function() {
    $scope.loading = true;
    $UserService.get_list().then(function(response) {
      $scope.users = response.data.users;
      $scope.loading = false;
    });
  };
  
  $scope.delete = function(user) {
     if (!confirm_del()) {
       return false;
     }
     
    $scope.processing = false;
    $scope.user = user;
    $scope.user_id = user.id;
    
    $UserService.delete(user).then(function(response) {
      if (response.data.type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Xóa thành viên thành công!'});
        $scope.init();
      }
      else {
        $scope.noty.add({type:'warning', title:'Thông báo', body: response.data.message});
      }
    });
  };
  
});

// for downline
app.controller('UserAddDownlineCtrl', function($scope, $http, $location, noty, $UserService, $GroupService, $SponsorService) {
  $scope.editing = false;
  
  $scope.user = {};
  
  $scope.processing = false;
  
  $scope.init = function() {
    $SponsorService.get_list().then(function(response) {
      $scope.sponsors = response.data.sponsors;
      
      for (var i=0; i < $scope.sponsors.length; i++) {
        if ($scope.sponsors[i].username == $scope.user.sponsor) {
          $scope.user.sponsor = $scope.sponsors[i];
        }
      }
    });
  };
  
  $scope.onSponsorSelected = function (selectedItem) {
     $scope.user.display_name = selectedItem.name;
     $scope.user.user_name = selectedItem.username;
     $scope.user.email = selectedItem.email;
     $scope.user.mobile = selectedItem.mobile;
     $scope.user.sponsor_owner = selectedItem.username;
  };
  
  $scope.disabled = function() {
    if (!$scope.user.sponsor_owner || !$scope.user.user_name || !$scope.user.display_name || 
      !$scope.user.email || !$scope.user.mobile || !$scope.user.password || !$scope.user.repassword ||
      $scope.processing) {
      return true;
    };
    
    return $scope.user.sponsor_owner.length > 0 && $scope.user.user_name.length > 0 && 
      $scope.user.display_name.length > 0 && $scope.user.email.length > 0 && 
      $scope.user.password.length > 0 && $scope.user.repassword.length > 0 && $scope.user.mobile.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $UserService.add_downline($scope.user).then(function(response) {
      var data = response.data;
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      $scope.processing = false;
    }); 
  };
  
});

app.controller('UserListDownlineCtrl', function($scope, $http, $location, noty, $UserService, $GroupService, $SponsorService) {
  $scope.editing = false;
  
  $scope.loading = false;
  
  $scope.noty = noty;
  
  $scope.user = {};
  
  $scope.processing = false;
  
  $scope.init = function() {
    $scope.loading = true;
    $UserService.get_list_downline("1","5").then(function(response) {
      $scope.users = response.data.users;
      $scope.loading = false;
    });
  };
  
  $scope.delete = function(user) {
     if (!confirm_del()) {
       return false;
     }
     
    $scope.processing = false;
    $scope.user = user;
    $scope.user_id = user.id;
    
    $UserService.delete(user).then(function(response) {
      if (response.data.type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Xóa thành viên thành công!'});
        $scope.init();
        $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
      }
      else {
        $scope.noty.add({type:'warning', title:'Thông báo', body: response.data.message});
      }
    });
  };
  
  // New code for grid-ui
  $scope.filterOptions = {
      filterText: "",
      useExternalFilter: true
  }; 
  
  $scope.totalServerItems = 0;
  $scope.pagingOptions = {
      pageSizes: [20, 50, 100],
      pageSize: 20,
      currentPage: 1
  };
  
  $scope.setPagingData = function(data, page, pageSize){
    $scope.myData = data;
    if (!$scope.$$phase) {
        $scope.$apply();
    }
  };
  
  $scope.getPagedDataAsync = function (pageSize, page, searchText) {
      setTimeout(function () {
          var data;
          if (searchText) {
              var ft = searchText.toLowerCase();
              $UserService.search_text_downline(page, pageSize, ft).then(function (largeLoad) {
                  $scope.loading = false;
                  console.log(largeLoad.data);
                  $scope.setPagingData(largeLoad.data.users,page,pageSize);
                  $scope.totalServerItems = largeLoad.data.total;
              });           
          } else {
              $UserService.get_list_downline(page, pageSize).then(function (largeLoad) {
                  $scope.loading = false;
                  console.log(largeLoad.data);
                  $scope.setPagingData(largeLoad.data.users,page,pageSize);
                  $scope.totalServerItems = largeLoad.data.total;
              });
          }
      }, 10);
  };

  $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
  
  $scope.refreshData = function(){
      $scope.getPagedDataAsync($scope.pagingOptions.pageSize, "1", $scope.searchText);
    };
  
  $scope.$watch('pagingOptions', function (newVal, oldVal) {
      if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {
        $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
      }
  }, true);
  
  $scope.$watch('filterOptions', function (newVal, oldVal) {
      if (newVal !== oldVal) {
        $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
      }
  }, true);

  $scope.gridOptions = {
      data: 'myData',
      enablePaging: true,
      enableRowSelection: false,
      enableCellSelection: true,
      showFooter: true,
      'enableColumnResize': true,
      'multiSelect': false,
      totalServerItems: 'totalServerItems',
      pagingOptions: $scope.pagingOptions,
      filterOptions: $scope.filterOptions,
      columnDefs: [
        { field: "id", displayName: 'ID', width: 50, pinned: true },
        { field: "display_name", displayName: 'Họ tên', width: 120 },
        { field: "user_name", displayName: 'Tên đăng nhập', width: 200 },
        { field: "email", displayName: 'Email', width: 180},
        { 
          field: "mobile", 
          displayName: 'Mobile', 
          width: 100
        },
        { field: "system_code", displayName: 'System Code', width: 100 },
        { field: "block", displayName: 'Trạng thái', width: 100, 
          cellTemplate:'<i class="fa fa-toggle-on {{ COL_FIELD == 1 ? "Pending" : (COL_FIELD == 2 ? "Pending Payment" : "Approved")}} "></i>' },
        { field: "", 
          cellTemplate:'<a type="button" href="/system#!/user/edit_downline/{{ row.getProperty(\'id\') }}/{{ row.getProperty(\'system_code \')}}" data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" ng-click="delete(row.entity)" data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa" type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a>' }]
  };
});


app.controller('UserEditDownlineCtrl',  function($scope, $routeParams, $http, $UserService, $GroupService, $SponsorService) {
    $scope.processing = false;
    
    $scope.user = {};
    
    $scope.user.id = $routeParams.id;
    $scope.user.system_code = $routeParams.sc;
    
    $scope.init = function() {
      $UserService.view_downline($scope.user.id, $scope.user.system_code).then(function(response) {
        $scope.user = response.data.user;
        if ($scope.user && $scope.user.block) {
          $scope.user.block = $scope.user.block == 1? true: false;
        }
      });
    };
    
    $scope.disabled = function() {
      if (!$scope.user.display_name || !$scope.user.mobile || 
        !$scope.user.group_id || $scope.processing) {
        return true;
      };
      
      return $scope.user.display_name.length > 0 && 
        $scope.user.mobile.length > 0 && $scope.user.group_id > 0  ? false : true;
      
    };
  
   $scope.submit = function() {
     $scope.message = '';
     $scope.message_type = 1;
     $scope.processing = true;
    
     $UserService.edit_downline($scope.user).then(function(response) {
       $scope.processing = false;
       $scope.message_type = response.data.type;
       $scope.message = response.data.message;
     });
   };
});
