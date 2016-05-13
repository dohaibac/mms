app.controller('PdListCtrl', function($scope, $http, $location, $modal, noty, $PdService) {
  
  $scope.noty = noty;
  $scope.pds = {};
  $scope.loading = false;
  $scope.myData = [];

  var url = generate_url('pd', 'get_list');

  $scope.init = function () {
    $scope.loading = true;
    $PdService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.pds = response.data.pds;

    });
  };
  
  $scope.delete = function(pd) {
     if (!confirm_del()) {
       return false;
     }
     
    $scope.processing = true;
    
    $PdService.delete(pd).then(function(response) {
      $scope.processing = false;
      $scope.noty.add({type:'info', title:'Thông báo', body:response.data.message});
      $scope.init();
      $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
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
              $http.get(url).success(function (largeLoad) {    
                  data = largeLoad.filter(function(item) {
                      return JSON.stringify(item).toLowerCase().indexOf(ft) != -1;
                  });
                  $scope.setPagingData(JSON.stringify(data.pds),page,pageSize);
              });            
          } else {
              $PdService.get_list(page, pageSize).then(function (largeLoad) {
                  $scope.setPagingData(largeLoad.data.pds,page,pageSize);
                  $scope.totalServerItems = largeLoad.data.total;
              });
          }
      }, 100);
  };

  $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);

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
      showFooter: true,
      totalServerItems: 'totalServerItems',
      pagingOptions: $scope.pagingOptions,
      filterOptions: $scope.filterOptions,
      columnDefs: [{ field: "id", displayName: 'ID', width: 50, pinned: true },
                   { field: "code", displayName: 'Mã', width: 120 },
                   { field: "sponsor", displayName: 'Nhà tài trợ', width: 200 },
                   { field: "amount", displayName: 'Số Tiền', width: 150 },
                   { field: "remain_amount", displayName: 'Còn Lại', width: 150 },
                   { field: "created_at", displayName: 'Ngày Đặt Lệnh', width: 200 },
                   { field: "status", displayName: 'Trạng thái', width: 150, cellTemplate:'<div class=ngCellText>{{ COL_FIELD == 1 ? "Pending" : (COL_FIELD == 2 ? "Pending Payment" : "Approved")}}</div>' },
                   { field: "", width: 150, cellTemplate:'<div class=ngCellText><a type="button" href="/pd#!/edit/{{ row.getProperty(\'id\') }}" data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" ng-click="delete(row.entity)" data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa" type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a></div>' }]
  };
});

app.controller('PdAddCtrl', function($scope, $http, $location, $modal, $PdService, $SponsorService, $SettingService, $BankService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.pd = {};
  
  $scope.pd.sponsor = {'username' : '', 'name': ''};
  
  $scope.optionStatus = [
    {'id': 1, 'name': 'Pending'},
    {'id': 2, 'name': 'Pending Payment'},
    {'id': 3, 'name': 'Approved'}
  ];
  
  $scope.amount_money_text = '';
  
  var d = new Date();
  
  $scope.pd.issued_at = d.toLocaleDateString("VN-vi") + ' ' + d.getHours() + ':'+ d.getMinutes() + ':' + d.getSeconds();
  
  $scope.init = function () {
     var default_sponsor = '';
     
     $SponsorService.get_sponsor_owner().then(function(resp) {
        default_sponsor = resp.data.sponsor_owner;
        
        $SponsorService.get_list().then(function(response) {
          $scope.sponsors = response.data.sponsors;
          
          for (var i=0; i < $scope.sponsors.length; i++) {
            if ($scope.sponsors[i].username == default_sponsor) {
              $scope.pd.sponsor = $scope.sponsors[i];
            }
          }
        });
     }); 
    
    $SettingService.view().then(function(response) {
      $scope.pd.num_days_pending = response.data.num_days_pd_pending;
      $scope.pd.num_hours_transfer = response.data.num_hours_pd_transfer;
    });
    
    $scope.get_bank_list();
    
    $scope.pd.status = {'id': 1, 'name': 'Pending'};
    $scope.pd.amount = '660';
    $scope.pd.remain_amount = '0';
  };
  
  $scope.get_bank_list = function() {
    $BankService.get_list().then(function(response){
      $scope.banks = response.data.banks;
    });
  };
  $scope.disabled = function() {
    if (!$scope.pd.code || !$scope.pd.sponsor || !$scope.pd.amount ||
       !$scope.pd.remain_amount || !$scope.pd.issued_at || !$scope.pd.num_days_pending ||
       !$scope.pd.num_hours_transfer || !$scope.pd.status || $scope.processing) {
      return true;
    }
    
    return $scope.pd.code.length > 0 && $scope.pd.sponsor.name.length > 0 && 
    $scope.pd.amount.length > 0 && $scope.pd.remain_amount.length > 0 && $scope.pd.issued_at.length > 0 && 
    $scope.pd.num_days_pending.length > 0 && $scope.pd.num_hours_transfer.length > 0 ? false : true;
    
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $PdService.add($scope.pd).then(function(response) {
      $scope.processing = false;
      
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
    });
  };
 
  $scope.show_bank_add = function() {
    var options = {
      'init': function(mscope) {
        mscope.bank = {};
      },
      'disabled': function(mscope) {
        var bank = mscope.bank;
        if (!bank || !bank.name || !bank.branch_name || !bank.account_hold_name || 
        !bank.account_number || !bank.linked_mobile_number || mscope.processing) {
          return true;
        }
        
        return mscope.bank.name.length > 0 && mscope.bank.branch_name.length > 0 
          && mscope.bank.account_hold_name.length > 0 && mscope.bank.account_number.length > 0 && mscope.bank.linked_mobile_number.length > 0 ? false : true;
      },
      'ok': function (mscope) {
        $BankService.add(mscope.bank).then(function(response) {
          var data = response.data;
          if (data && data.type == 1) {
            mscope.message = data.message;
          }
          else {
            mscope.close();
            $scope.get_bank_list();
          }
        });
      },
    };
    
    $BankService.show_add_modal(options);
  };
  
  $scope.convert_money = function () {
    $scope.amount_money_text = DocTienBangChu($scope.pd.amount);
  };
});

app.controller('PdEditCtrl',  function($scope, $routeParams, $PdService, $SponsorService, $BankService, $http) {
  $scope.processing = false;
  
  $scope.pd = {};
  
  $scope.optionStatus = [
    {'id': 1, 'name': 'Pending'},
    {'id': 2, 'name': 'Pending Payment'},
    {'id': 3, 'name': 'Approved'}
  ];
  
  $scope.amount_money_text = '';
  
  $scope.pd.id = $routeParams.id;

  $scope.init = function() {
    $PdService.view($scope.pd.id).then(function(response) {
      $scope.pd = response.data;
      
      var status = $scope.pd.status;
      
      if (status == 1) {
        $scope.pd.status = {'id': 1, 'name': 'Pending'};
      }
      if (status == 2) {
        $scope.pd.status = {'id': 2, 'name': 'Pending Payment'};
      }
      if (status == 3) {
        $scope.pd.status = {'id': 3, 'name': 'Approved'};
      }
    });
    
    $scope.get_bank_list();
    
    $SponsorService.get_list().then(function(response) {
      $scope.sponsors = response.data.sponsors;
      
      for (var i=0; i < $scope.sponsors.length; i++) {
        if ($scope.sponsors[i].username == $scope.pd.sponsor) {
          $scope.pd.sponsor = $scope.sponsors[i];
        }
      }
    });
  };
  
  $scope.get_bank_list = function() {
    $BankService.get_list().then(function(response){
      $scope.banks = response.data.banks;
        
      for (var i=0; i < $scope.banks.length; i++) {
        if ($scope.banks[i].id == $scope.pd.bank_id) {
          $scope.pd.bank = $scope.banks[i];
        }
      }    

    });
  };
  
  $scope.disabled = function() {
    if (!$scope.pd.code || !$scope.pd.sponsor || !$scope.pd.amount ||
       !$scope.pd.remain_amount || !$scope.pd.issued_at || !$scope.pd.num_days_pending ||
       !$scope.pd.num_hours_transfer || !$scope.pd.status || $scope.processing) {
      return true;
    }
    
    return $scope.pd.code.length > 0 && $scope.pd.sponsor.username && $scope.pd.sponsor.username.length > 0 && 
    $scope.pd.amount.length > 0 && $scope.pd.remain_amount.length > 0 && $scope.pd.issued_at.length > 0 && 
    $scope.pd.num_days_pending.length > 0 && $scope.pd.num_hours_transfer.length > 0 ? false : true;
    
  };
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $PdService.edit($scope.pd).then(function(response) {
      $scope.processing = false;
      $scope.message = response.data.message;
      $scope.message_type = response.data.message_type;
    });
  };
  
  $scope.show_bank_add = function() {
    var options = {
      'init': function(mscope) {
        mscope.bank = {};
      },
      'disabled': function(mscope) {
        var bank = mscope.bank;
        if (!bank || !bank.name || !bank.branch_name || !bank.account_hold_name || 
        !bank.account_number || !bank.linked_mobile_number || mscope.processing) {
          return true;
        }
        
        return mscope.bank.name.length > 0 && mscope.bank.branch_name.length > 0 
          && mscope.bank.account_hold_name.length > 0 && mscope.bank.account_number.length > 0 && mscope.bank.linked_mobile_number.length > 0 ? false : true;
      },
      'ok': function (mscope) {
        $BankService.add(mscope.bank).then(function(response) {
          var data = response.data;
          if (data && data.type == 1) {
            mscope.message = data.message;
          }
          else {
            mscope.close();
            $scope.get_bank_list();
          }
        });
      },
    };
    
    $BankService.show_add_modal(options);
  };
  
  $scope.convert_money = function () {
    $scope.amount_money_text = DocTienBangChu($scope.pd.amount);
  };
});
 
