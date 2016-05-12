app.controller('SponsorListCtrl', function($scope, $http, $location, $modal, noty, $SponsorService, $window) {
  
  $scope.noty = noty;
  
  $scope.loading = false;
  
  $scope.init = function () {
    
    $scope.loading = true;
    
    $SponsorService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      var sponsors = $scope.build_tree(response.data.sponsors);
      $scope.sponsor_owner = response.data.sponsor_owner;
      $scope.sponsors = sponsors[$scope.sponsor_owner];
      
      $scope.total = response.data.total;
      $scope.group_id = response.data.group_id;
    });
  };
  
  $scope.search = function () {
    var keyword = $("#keyword");
    keyword = $.trim(keyword.val());
    
    if (keyword == '') {
      $scope.init();
      return false;
    }
    
    $scope.loading = true;
    
    $SponsorService.search(keyword).then(function(response) {
      
      $scope.loading = false;
      
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      var sponsors = $scope.build_tree(response.data.sponsors);
      $scope.sponsor_owner = response.data.sponsor_owner;
      $scope.sponsors = sponsors[$scope.sponsor_owner];
      
      $scope.total = response.data.total;
      $scope.group_id = response.data.group_id;
    }); 
  };
  
  $scope.build_tree = function (data) {
    var source = [];
    var items = [];
    // build hierarchical source.
    for (i = 0; i < data.length; i++) {
        var item = data[i];
        var label = item["username"];
        var parentid = item["upline"];
        var id = item["username"];

        if (items[parentid]) {
            var item = { parentid: parentid, label: label, item: item };
            if (!items[parentid].items) {
                items[parentid].items = [];
            }
            items[parentid].items[items[parentid].items.length] = item;
            items[id] = item;
        }
        else {
            items[id] = { parentid: parentid, label: label, item: item };
            source[id] = items[id];
        }
    }
    return source;
  };
  
  $scope.delete = function(sponsor) {
     if (!confirm_del()) {
       return false;
     }
     
    $scope.processing = false;
    $scope.group = {};
    $scope.group.group_id = group.id;
    
    var url = generate_url ('group', 'delete');
    
    $http({
      method  : 'POST',
      url     : url,
      data    : $.param($scope.group), 
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
     .success(function(data) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Xóa nhóm thành công!'});
        $scope.get_list();
     });
  };
  
  $scope.show_detail = function(sponsor) {
    var options = {
      'init': function(mscope) {
        mscope.sponsor = sponsor;
        console.log(sponsor);
      }
    };
    $SponsorService.show_modal_detail(options).then(function(response){
      
    });
  };
});

app.controller('SponsorAddCtrl', function($scope, $http, $location, $modal, $SponsorService, $BankService, noty) {
  $scope.processing = false;
  
  $scope.banks = [];
  
  $scope.sponsor = {};
  $scope.sponsor_check = {};
   
  $scope.sponsor.bank = {};
  
  $scope.sponsor.force_downline_f1 = false;
  $scope.sponsor.force_downline_fork = false;
  
  $scope.init = function () {
    $BankService.get_list().then(function(response){
      $scope.banks = response.data.banks;
    });
  };
  
  $scope.check_sponsor = function() {
    var username = $('.upline').val();
    username = $.trim(username);
    
    if (username == '') {
      return false;
    };
    
    $SponsorService.view(username).then(function(response) {
      var data = response.data;
      $scope.sponsor_check.message_type = data.type;
      $scope.sponsor_check.message = data.message;
      
      $scope.sponsor_check.sponsor = data.data;
      
    });
  };
  
  $scope.disabled = function() {
    if (!$scope.sponsor.name || !$scope.sponsor.username || 
      !$scope.sponsor.email || !$scope.sponsor.mobile || !$scope.sponsor.bank || $scope.processing) {
      return true;
    }
    return $scope.sponsor.name.length > 0 && $scope.sponsor.username.length > 0 && 
    $scope.sponsor.email.length > 0 && $scope.sponsor.mobile.length > 0 ? false : true;
    
  };
  
  $scope.noty = noty;
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $SponsorService.add($scope.sponsor).then(function(response) {
      $scope.processing = false;
      var data = response.data;
      
      if (data.code =='sponsor-message-max_downline') {
        if (confirm(data.message)) {
          $scope.sponsor.force_downline_f1 = true;
          $scope.submit();
          return false;
        }
        else {
          return false;
        }
      } 
      if (data.code =='sponsor-message-max_fork') {
        if (confirm(data.message)) {
          $scope.sponsor.force_downline_fork = true;
          $scope.submit();
          return false;
        }
        else {
          return false;
        }
      }
      
      $scope.message = data.message;
      $scope.message_type = data.type;
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
            $scope.init();
          }
        });
      },
    };
    
    $BankService.show_add_modal(options);
  };
});

app.controller('SponsorEditCtrl',  function($scope, $routeParams, $http) {
    $scope.processing = false;
    
    $scope.groupId = $routeParams.groupId;
    $scope.group = {};
    
    $scope.group.group_id = $scope.groupId;
    
    var url = generate_url ('group', 'view');
    
    $http({
      method  : 'GET',
      url     : url + '&group_id=' + $scope.group.group_id,
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
     .success(function(data) {
        $scope.message = data.message;
        $scope.message_type = data.type;
        $scope.group = data;
        
        if ($scope.group && $scope.group.block) {
          $scope.group.block = $scope.group.block == 1? true: false;
        }
     });
     
    $scope.disabled = function() {
      if (!$scope.group.name ||$scope.processing) {
        return true;
    }
      
    return $scope.group.name.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    var url = generate_url ('group', 'edit');
   
   $http({
    method  : 'POST',
    url     : url,
    data    : $.param($scope.group), 
    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
   })
   .success(function(data) {
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      $scope.processing = false;
   });
  };
    
});
 
