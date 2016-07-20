app.controller('SponsorListTreeCtrl', function($scope, $http, $location, $modal, noty, $SponsorService, $window) {
  
  $scope.noty = noty;
  
  $scope.loading = false;
  
  $scope.sponsor_owner_object = {};
  
  $scope.sponsor_owner_object.item = {};
  
  $scope.init = function () {
    
    $scope.loading = true;
    
    $SponsorService.get_list_tree().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      var sponsors = $scope.build_tree(response.data.sponsors);
      
      $scope.sponsor_owner = response.data.sponsor_owner;
      $scope.lsponsor_owner = response.data.lsponsor_owner;
      
      angular.forEach(response.data.sponsors, function(sp, index) {
         if (sp.username == $scope.sponsor_owner) {
           $scope.sponsor_owner_object.item = sp;
         }
      });
      
      $scope.sponsors = sponsors[$scope.lsponsor_owner];
      
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
    
    $scope.message_type = 0;
    $scope.message = '';
    
    $SponsorService.search_tree(keyword).then(function(response) {
      
      $scope.loading = false;
      
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      var sponsors = $scope.build_tree(response.data.sponsors);
      $scope.sponsor_owner = response.data.sponsor_owner;
      $scope.lsponsor_owner = response.data.lsponsor_owner;
      
      angular.forEach(response.data.sponsors, function(sp, index) {
         if (sp.username == $scope.sponsor_owner) {
           $scope.sponsor_owner_object.item = sp;
         }
      });
      
      $scope.sponsors = sponsors[$scope.lsponsor_owner];
      
      $scope.total = response.data.total;
      $scope.group_id = response.data.group_id;
    }); 
  };
  
  $scope.build_tree = function (data) {
    var source = [];
    var items = [];
    
    for (i = 0; i < data.length; i++) {
        var item = data[i];
        var name = item["username"];
        
        var label = item["lusername"];
        var parentid = item["lupline"];
        var id = item["lusername"];
        
        if (items[parentid]) {
            var item = { parentid: parentid, label: label, item: item, 'name': name};
            if (!items[parentid].items) {
                items[parentid].items = [];
            }
            items[parentid].items[items[parentid].items.length] = item;
            items[id] = item;
        }
        else {
            items[id] = { parentid: parentid, label: label, item: item, 'name': name};
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
        mscope.editing = false;
        // lay thong tin sponsor invest
        $SponsorService.check_sponsor_invest(sponsor.item.username).then(function(response) {
          var data = response.data;
          if (data.id && data.id > 0) {
            mscope.sponsor.item.sponsor_invest = 'dt';
          }
          else {
            mscope.sponsor.item.sponsor_invest = 'ht';
          }
          mscope.$broadcast('send::data::edit', mscope.sponsor);
        });
      },
      'ok' : function(mscope) {
       
      }
    };
    $SponsorService.show_modal_detail(options).then(function(response){
      
    });
  };
});

app.controller('SponsorListCtrl', function($scope, $http, $location, $modal, noty, $SponsorService, $window, $compile) {
  
  $scope.noty = noty;
  
  $scope.loading = false;
  
  $scope.sponsor_owner_object = {};
  $scope.sponsors = [];
  $scope.sponsor_owner_object.item = {};
  
  $scope.menuOptions = [
    ['Add', function ($itemScope) {
       $scope.show_add_modal($itemScope.item);
    }],
    null, // Dividier
    ['Edit', function ($itemScope) {
        $scope.show_edit($itemScope.item);
    }],
    null, // Dividier
    ['Delete', function ($itemScope) {
        $scope.show_delete($itemScope.item);
    }],
    null, // Dividier
    ['Test sơ đồ 1/5/3', function ($itemScope) {
       $scope.show_test_153($itemScope.item);
    }],
    null, // Dividier
    ['Lợi nhuận', function ($itemScope) {
       $scope.show_profit($itemScope.item);
    }]
  ];
  
  $scope.init = function () {
    
    $scope.loading = true;
    
    $SponsorService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      var sponsors = response.data.sponsors;
      
      $scope.sponsor_owner = response.data.sponsor_owner;
      $scope.lsponsor_owner = response.data.lsponsor_owner;
      
      $sponsors = sponsors[$scope.lsponsor_owner];
      
      $scope.level_root = $sponsors.level;
      
      $scope.sponsors = [];
      $scope.sponsors.items = [];
      $scope.sponsors.items.push($sponsors);
      
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
    
    $scope.message_type = 0;
    $scope.message = '';
    
    $SponsorService.search(keyword).then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      var sponsors = response.data.sponsors;
      
      $scope.sponsor_owner = response.data.sponsor_owner;
      $scope.lsponsor_owner = response.data.lsponsor_owner;
      
      $sponsors = sponsors[$scope.lsponsor_owner];
      
      $scope.level_root = $sponsors.level;
      
      $scope.sponsors = [];
      $scope.sponsors.items = [];
      $scope.sponsors.items.push($sponsors);
      
      $scope.group_id = response.data.group_id;
      
      $('#path_breakumb').empty();
      
      if ($sponsors && $sponsors.item) {
        $scope.path_breakumb = $compile($scope.get_path_in_breakumb($sponsors.item.path))($scope);
        $('#path_breakumb').append($scope.path_breakumb);
      }
    }); 
  };
  
  $scope.get_child_nodes = function(node) {
    //if (node.item.is_loaded) {
    //  return;
    //}
    
    node.item.is_loading = true;
    
    $SponsorService.get_child_sponsor(node.item.item).then(function(response) {
      var data = response.data;
      node.item.items = data.sponsors;
      node.item.is_loaded = true;
      node.item.is_loading = false;
    });
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
  
  $scope.show_edit = function(sponsor) {
    var options = {
      'init': function(mscope) {
        mscope.sponsor = sponsor;
        mscope.editing = false;
        // lay thong tin sponsor invest
        $SponsorService.check_sponsor_invest(sponsor.item.username).then(function(response) {
          var data = response.data;
          if (data.id && data.id > 0) {
            mscope.sponsor.item.sponsor_invest = 'dt';
          }
          else {
            mscope.sponsor.item.sponsor_invest = 'ht';
          }
          mscope.$broadcast('send::data::edit', mscope.sponsor);
        });
      },
      'ok' : function(mscope) {
       
      }
    };
    $SponsorService.show_modal_detail(options).then(function(response){
      
    });
  };
  
  $scope.show_add_modal = function(sponsor) {
    var options = {
      'init': function(mscope) {
        mscope.sponsor = {};
        mscope.sponsor.upline = sponsor.item.username;
        mscope.sponsor.name = '';
        mscope.sponsor.name = '';
        mscope.$broadcast('send::data::add::modal', {'sponsor': mscope.sponsor, 'mscope': mscope } );
      },
      'ok' : function(mscope) {
        mscope.close();
        $scope.init();
      },
    };
    $SponsorService.show_add_modal(options).then(function(response){
      
    });
  };
  
  $scope.show_delete = function(sponsor) {
    var options = {
      'init': function(mscope) {
        mscope.sponsor = sponsor;
        mscope.$broadcast('SponsorListCtrl::send::data::delete', mscope);
      },
      'ok' : function(mscope) {
       
      }
    };
    $SponsorService.show_modal_delete(options).then(function(response){
      
    });
  };
   
  $scope.show_test_153 = function(sponsor) {
    var options = {
      'init': function(mscope) {
        mscope.sponsor = sponsor;
        mscope.$broadcast('SponsorListCtrl::send::data::show_test_153', mscope);
        
        mscope.$on('SponsorListCtrl::edit::find', function(e, data) {
          mscope.close();
           var keyword = $("#keyword").val(data.username);
           $scope.search();
        });
        
      },
      'ok' : function(mscope) {
       
      }
    };
    $SponsorService.show_modal_test_153(options).then(function(response){
      
    });
  };
  
  $scope.show_profit = function (sponsor) {
    var options = {
      'init': function(mscope) {
        mscope.sponsor = sponsor;
        mscope.$broadcast('SponsorListCtrl::send::data::show_profit', mscope);
      }
    };
    $SponsorService.show_modal_profit(options).then(function(response){
      
    });
  };
  
  $scope.bind_click_path_event = function (name) {
    $("#keyword").val(name);
    $scope.search();
  };
  /***
   * xu ly path thanh breakumb
   * 
   * value1>valu2>value3> to <a>value1></a><a>value2</a><a>value3></a>
   * 
   *  */
  $scope.get_path_in_breakumb = function(path) {
    if (!path) {
      return '';
    }
    
    var ret = '';
    var arrPath = path.split('>');
    
    for(var i = 0; i < arrPath.length; i ++) {
      var name = arrPath[i];
      
      if (i == arrPath.length - 2) {
        ret += '<a>' + name + '</a>';
        continue;
      }
      
      if (name && name.length > 0) {
        ret += '<a href="javascript:void(0)" ng-click="bind_click_path_event(\''+ name +'\')">' + name + '</a> <i class="fa fa-angle-right"></i>';
      }
    }
    
    return ret;
  };
});
 
app.controller('SponsorAddCtrl', function($scope, $http, $location, $modal, $SponsorService, $BankService, noty) {
  $scope.processing = false;
  
  $scope.banks = [];
  
  $scope.sponsor = {};
  $scope.sponsor_check = {};
  $scope.sponsor.sponsor_invest = 'dt';
  $scope.sponsor.bank = {};
  
  $scope.sponsor.force_downline_f1 = false;
  $scope.sponsor.force_downline_fork = false;
  
  $scope.levels = ['M0', 'M1', 'M2', 'M3', 'M4', 'M5', 'M-GOLD'];
  
  $scope.init = function () {
    $BankService.get_list().then(function(response){
      $scope.banks = response.data.banks;
    });
    $scope.sponsor.sponsor_level = 'M0';
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
      !$scope.sponsor.email || !$scope.sponsor.mobile || !$scope.sponsor.sponsor_invest || $scope.processing) {
      return true;
    }
    return $scope.sponsor.name.length > 0 && $scope.sponsor.username.length > 0 && 
    $scope.sponsor.email.length > 0 && $scope.sponsor.sponsor_invest.length > 0 && $scope.sponsor.mobile.length > 0 ? false : true;
    
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
  
  $scope.toggle_password = function() {
    if ($('#show_password').is(":checked")) {
      $('#ptl').attr('type', 'text');
    } else {
      $('#ptl').attr('type', 'password');
    }
  };
 
  $scope.toggle_security = function() {
    if ($('#show_security').is(":checked")) {
      $('#security').attr('type', 'text');
    } else {
      $('#security').attr('type', 'password');
    }
  };
});
 
app.controller('SponsorAddModalCtrl', function($scope, $http, $location, $modal, $SponsorService, $BankService, noty) {
  $scope.sponsor = {};
  
  $scope.$on('send::data::add::modal', function(e, data) {
     $scope.sponsor = data.sponsor;
     $scope.mscope = data.mscope;
  });
  
  $scope.noty = noty;
  
  $scope.processing = false;
  
  $scope.sponsor_check = {};
  $scope.sponsor.sponsor_invest = 'dt';
  
  $scope.sponsor.force_downline_f1 = false;
  $scope.sponsor.force_downline_fork = false;
  
  $scope.levels = ['M0', 'M1', 'M2', 'M3', 'M4', 'M5', 'M-GOLD'];
  
  $scope.sponsor.sponsor_level = 'M0';
  
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
      !$scope.sponsor.email || !$scope.sponsor.mobile || !$scope.sponsor.sponsor_invest || $scope.processing) {
      return true;
    }
    return $scope.sponsor.name.length > 0 && $scope.sponsor.username.length > 0 && 
    $scope.sponsor.email.length > 0 && $scope.sponsor.sponsor_invest.length > 0 && $scope.sponsor.mobile.length > 0 ? false : true;
    
  };
  
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
      
      if ($scope.message_type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body: 'Thêm thành công!'});
        //$scope.mscope.ok($scope.mscope);
      }
    });
  };
  
  $scope.toggle_password = function() {
    if ($('#show_password').is(":checked")) {
      $('#ptl').attr('type', 'text');
    } else {
      $('#ptl').attr('type', 'password');
    }
  };
 
  $scope.toggle_security = function() {
    if ($('#show_security').is(":checked")) {
      $('#security').attr('type', 'text');
    } else {
      $('#security').attr('type', 'password');
    }
  };
});

app.controller('SponsorEditCtrl', function($scope, $http, $location, $modal, $SponsorService) {
  $scope.processing = false;
  
  $scope.levels = ['M0', 'M1', 'M2', 'M3', 'M4', 'M5', 'M-GOLD'];
  
   $scope.$on('send::data::edit', function(e, data) {
     $scope.sponsor = data;
   });
  
  $scope.disabled = function() {
    if (!$scope.sponsor || !$scope.sponsor.item.name || !$scope.sponsor.item.username || 
      !$scope.sponsor.item.email || !$scope.sponsor.item.mobile || $scope.processing) {
      return true;
    }
    return $scope.sponsor.item.name.length > 0 && $scope.sponsor.item.username.length > 0 && 
    $scope.sponsor.item.email.length > 0 && $scope.sponsor.item.mobile.length > 0 ? false : true;
    
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $SponsorService.edit($scope.sponsor.item).then(function(response) {
      $scope.processing = false;
      var data = response.data;
      
      $scope.message = data.message;
      $scope.message_type = data.type;
    });
  };
  
  $scope.toggle_password = function() {
    if ($('#show_password').is(":checked")) {
      $('#password').attr('type', 'text');
    } else {
      $('#password').attr('type', 'password');
    }
  };
  $scope.toggle_password_input = function() {
    if ($('#show_password_input').is(":checked")) {
      $('#password_input').attr('type', 'text');
    } else {
      $('#password_input').attr('type', 'password');
    }
  };
  
  $scope.toggle_security = function() {
    if ($('#show_security').is(":checked")) {
      $('#security').attr('type', 'text');
    } else {
      $('#security').attr('type', 'password');
    }
  };
  $scope.toggle_security_input = function() {
    if ($('#show_security_input').is(":checked")) {
      $('#security_input').attr('type', 'text');
    } else {
      $('#security_input').attr('type', 'password');
    }
  };
});

app.controller('SponsorDeleteModalCtrl', function($scope, $http, $location, $modal, $SponsorService, $BankService, noty) {
  $scope.sponsor = {};
  $scope.sponsor.item = {};
  $scope.sponsor.items = [];
  
  $scope.$on('SponsorListCtrl::send::data::delete', function(e, data) {
     
     $scope.sponsor = data.sponsor; 
     
     $scope.mscope = data.mscope;
  });
  
  $scope.noty = noty;
  
  $scope.processing = false;
  
  $scope.disabled = function() {
    if (!$scope.sponsor.item.username || $scope.processing) {
      return true;
    }
    
    return $scope.sponsor.item.username.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $SponsorService.delete($scope.sponsor).then(function(response) {
      $scope.processing = false;
      var data = response.data;
      
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      if ($scope.message_type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body: 'Xóa thành công!'});
      }
    });
  };
  
});

app.controller('SponsorTest153ModalCtrl', function($scope, $http, $location, $modal, $SponsorService, $BankService,  $compile, noty) {
  $scope.sponsor = {};
  $scope.sponsor.item = {};
  
  $scope.result_test = [];
  
  $scope.loading = false;
  
  $scope.$on('SponsorListCtrl::send::data::show_test_153', function(e, data) {
     
     $scope.sponsor = data.sponsor; 
    
     $scope.mscope = data.mscope;
     
     $scope.loading = true;
     
     $scope.less_than_5_f1_list = [];
     $scope.less_than_3_fork_list = [];
     
     $SponsorService.test_153($scope.sponsor.item).then(function(response){
       $scope.loading = false;
       
       var data = response.data;
       
       $scope.less_than_5_f1_list = data.less_than_5_f1_list;
       $scope.less_than_3_fork_list = data.less_than_3_fork_list;
     });
  });
  
  
  $scope.find = function(item) {
    $scope.$emit('SponsorListCtrl::edit::find', {'username': item.username});
  };
  
  $scope.processing = false;
  
  $scope.disabled = function() {
    if (!$scope.sponsor.item.username ||  $scope.processing) {
      return true;
    }
    
    return $scope.sponsor.item.username.length > 0 ? false : true;
  };
  
});
