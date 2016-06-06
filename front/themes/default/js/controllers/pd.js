app.controller('PdListCtrl', function($scope, $http, $location, $modal, noty, $PdService) {
  
  $scope.noty = noty;
  $scope.pds = {};
  $scope.loading = false;
  $scope.myData = [];

  $scope.init = function () {
    $scope.loading = true;
    /* *****
      $PdService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.pds = response.data.pds;

    });*/
  };
  
  $scope.delete = function(pd) {
     if (!confirm_del(pd.code)) {
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
              $PdService.search_text(page, pageSize, ft).then(function (largeLoad) {
                  $scope.loading = false;
                  $scope.setPagingData(largeLoad.data.pds,page,pageSize);
                  $scope.totalServerItems = largeLoad.data.total;
              });           
          } else {
              $PdService.get_list(page, pageSize).then(function (largeLoad) {
                  $scope.loading = false;
                  $scope.setPagingData(largeLoad.data.pds,page,pageSize);
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
        { field: "code", displayName: 'Mã', width: 120 },
        { field: "sponsor", displayName: 'Mã thành viên', width: 200 },
        { field: "amount", displayName: 'Số tiền', width: 200,
          cellTemplate: "<span class=ngCellText> {{ row.entity[col.field] * 10000  | currency:'VND ':2 }}</span>"},
        { 
          field: "issued_at_display", 
          displayName: 'Ngày đặt lệnh', 
          width: 150
        },
        { field: "status", displayName: 'Trạng thái', width: 130, 
          cellTemplate:'<div class=ngCellText>{{ COL_FIELD == 1 ? "Pending" : (COL_FIELD == 2 ? "Pending Payment" : "Approved")}}</div>' },
        { field: "", 
          cellTemplate:'<div class=ngCellText><a type="button" href="/pd#!/edit/{{ row.getProperty(\'id\') }}" data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" ng-click="delete(row.entity)" data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa" type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a></div>' }]
  };
});

app.controller('PdAddCtrl', function($scope, $http, $location, $modal, $PdService, $SponsorService, $SettingService, $SponsorInvestService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.pd = {};
  
  $scope.pd.sponsor = {'sponsor' : ''};
  
  $scope.optionStatus = [
    {'id': 1, 'name': 'Pending'},
    {'id': 2, 'name': 'Pending Payment'},
    {'id': 3, 'name': 'Approved'}
  ];
  
  $scope.amount_money_text = '';
  
  var d = new Date();
  
  $scope.pd.issued_at = d.toLocaleDateString("VN-vi");
  
  $scope.init = function () {
     var default_sponsor = '';
     
     $SponsorService.get_sponsor_owner().then(function(resp) {
        default_sponsor = resp.data.sponsor_owner;
        
        $SponsorInvestService.get_list().then(function(response) {
          $scope.sponsors = response.data.sponsors;
          
          for (var i=0; i < $scope.sponsors.length; i++) {
            if ($scope.sponsors[i].sponsor == default_sponsor) {
              $scope.pd.sponsor = $scope.sponsors[i];
            }
          }
        });
     }); 
    
    $scope.pd.status = {'id': 1, 'name': 'Pending'};
    $scope.pd.amount = '660';
    $scope.pd.remain_amount = '0';
    
    $scope.amount_money_text = DocTienBangChu($scope.pd.amount * 10000);
  };
   
  $scope.disabled = function() {
    if (!$scope.pd.sponsor || !$scope.pd.amount ||
       !$scope.pd.issued_at || !$scope.pd.status || $scope.processing) {
      return true;
    }
    
    return $scope.pd.sponsor.sponsor.length > 0 && 
    $scope.pd.amount.length > 0 && $scope.pd.issued_at.length > 0 ? false : true;
    
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $PdService.add($scope.pd).then(function(response) {
      $scope.processing = false;
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
    });
  };
  
  $scope.convert_money = function () {
    $scope.amount_money_text = DocTienBangChu($scope.pd.amount * 10000);
  };
});

app.controller('PdEditCtrl',  function($scope, $routeParams, $PdService, $SponsorService, $SponsorInvestService, $http) {
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
      
      $scope.amount_money_text = DocTienBangChu($scope.pd.amount * 10000);
      
    });
     
    $SponsorInvestService.get_list().then(function(response) {
      $scope.sponsors = response.data.sponsors;
      
      for (var i=0; i < $scope.sponsors.length; i++) {
        if ($scope.sponsors[i].sponsor == $scope.pd.sponsor) {
          $scope.pd.sponsor = $scope.sponsors[i];
        }
      }
    });
  };
  
  
  $scope.disabled = function() {
    if (!$scope.pd.code || !$scope.pd.sponsor || !$scope.pd.amount ||
       !$scope.pd.issued_at || 
       !$scope.pd.status || $scope.processing) {
      return true;
    }
    
    return $scope.pd.code.length > 0 && $scope.pd.sponsor.sponsor && $scope.pd.sponsor.sponsor.length > 0 && 
    $scope.pd.amount.length > 0 && $scope.pd.issued_at.length > 0 ? false : true;
    
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
  
  $scope.convert_money = function () {
    $scope.amount_money_text = DocTienBangChu($scope.pd.amount * 1000);
  };
});
 
