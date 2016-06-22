app.controller('CandidateListCtrl', function($scope, $routeParams, $http, $location, $modal, noty, $CandidateService) {
  
  $scope.noty = noty;
  
  $scope.province_id = 0;

  if ($routeParams.province_id && !isNaN($routeParams.province_id)){
    $scope.province_id = $routeParams.province_id;
  }
  
  $scope.loading = false;
  
  $scope.candidates = {};
  $scope.myData = [];
  
  $scope.init = function () {
    $scope.loading = true;
    /*
    $CandidateService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.candidates = response.data.candidates;
      
    });
    */
  };
  
  $scope.delete = function(candidate) {
     if (!confirm_del(candidate.display_name)) {
       return false;
     }
     
    $scope.processing = true;
    
    $CandidateService.delete(candidate).then(function(response) {
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
        var ft = '';
        if (searchText) {
          ft = searchText.toLowerCase();
        }
        
        $CandidateService.get_list(page, pageSize, ft, $scope.province_id).then(function (largeLoad) {
            $scope.loading = false;
            $scope.setPagingData(largeLoad.data.candidates,page,pageSize);
            $scope.totalServerItems = largeLoad.data.total;
        });  
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
        { field: "id", displayName: 'ID', width: 40, pinned: true },
        { field: "display_name", displayName: 'Họ tên', width: 150 },
        { field: "email", displayName: 'Email', width: 130 },
        { field: "mobile", displayName: 'Mobile', width: 100 },
        { field: "addr", displayName: 'Địa chỉ', width: 160 },
        { field: "created_at", displayName: 'Ngày tạo', width: 150 },
        { field: "province", displayName: 'Khu vuc', width: 100 },
        { field: "",
            cellTemplate:'<div class=ngCellText><a type="button" href="/other#!/candidate/edit/{{ row.getProperty(\'id\') }}" data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a> <a href="javascript:void(0)" ng-click="delete(row.entity)" data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa" type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a></div>'
        }
        ]
  };
  
});

app.controller('CandidateAddCtrl', function($scope, $http, $location, $modal, $CandidateService, $PlanService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.province_list = {};
  $PlanService.get_provinces().then(function (largeLoad) {
      $scope.provinces = largeLoad.data.provinces;

      for (var i in largeLoad.data.provinces) {
        $scope.province_list[largeLoad.data.provinces[i].id] = largeLoad.data.provinces[i].name;
      }

    });
  $scope.newProvinces = "";
  $scope.candidate = {};
  
  $scope.disabled = function() {
    if ($scope.processing) {
      return true;
    }
    return false;
  };
  
  $scope.submit = function() {
    if (typeof($scope.candidate["display_name"]) == "undefined" || $scope.candidate["display_name"] == ""){
        alert("Vui lòng nhập tên ứng viên");
        return false;
    }
    
    $scope.processing = true;
    $scope.candidate["province_id"] = $scope.newProvinces.id;
    
    $CandidateService.add($scope.candidate).then(function(response) {
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
      $scope.processing = false;
      
      if ($scope.message_type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Thêm ứng viên thành công!'});
      }
    });
  };
 
});

app.controller('CandidateEditCtrl', function($scope, $routeParams, $location, $modal, $CandidateService, $PlanService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.province_list = {};
  $PlanService.get_provinces().then(function (largeLoad) {
      $scope.provinces = largeLoad.data.provinces;

      for (var i in largeLoad.data.provinces) {
        $scope.province_list[largeLoad.data.provinces[i].id] = largeLoad.data.provinces[i].name;
      }

    });
  
  $scope.candidate = {};
  $scope.candidate.id = $routeParams.id;
  $scope.init = function() {
    $CandidateService.view($scope.candidate.id).then(function(response) {
      $scope.candidate = response.data;
      $scope.candidateProvinces = {"id":$scope.candidate["province_id"],"name":""};
    });
  };
  
  $scope.disabled = function() {
    if ($scope.processing) {
      return true;
    }
    
    return false;
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    $scope.candidate["province_id"] = $scope.candidateProvinces["id"];
    $CandidateService.edit($scope.candidate).then(function(response) {
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
      $scope.processing = false;
      
      if ($scope.message_type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Cập nhật ứng viên thành công!'});
      }
    });
  };
 
});
