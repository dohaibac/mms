app.controller('GdexGetListCtrl', function($scope, $http, $location, $modal, noty, $GdexService, $GdService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.gds = [];
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    $GdService.get_all(1).then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.gds = response.data.gds;
    });
  };
  
  $scope.view_sponsor = function (pd) {
    var options = {
      'init': function(mscope) {
        $SponsorService.view(pd.sponsor).then(function(response) {
          var data = response.data;
          if (data.type == 1) {
            mscope.message = data.message;
            mscope.message_type = 1;
            return false;
          }
          mscope.sponsor = data.data;
          
          mscope.toggle_password = function() {
            if ($('#show_password').is(":checked")) {
              $('#password').attr('type', 'text');
            } else {
              $('#password').attr('type', 'password');
            }
         };
         
          mscope.toggle_security = function() {
            if ($('#show_security').is(":checked")) {
              $('#security').attr('type', 'text');
            } else {
              $('#security').attr('type', 'password');
            }
          };
        });
      }
    };
    
    $SponsorService.show_view_only(options);
  };
  
});

app.controller('GdexGdListCtrl', function($scope, $http, $location, $modal, noty, $GdexService, $GdService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.gds = [];
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    $GdService.get_all(2).then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.gds = response.data.gds;
    });
  };
  
  $scope.view_sponsor = function (pd) {
    var options = {
      'init': function(mscope) {
        $SponsorService.view(pd.sponsor).then(function(response) {
          var data = response.data;
          if (data.type == 1) {
            mscope.message = data.message;
            mscope.message_type = 1;
            return false;
          }
          mscope.sponsor = data.data;
          
          mscope.toggle_password = function() {
            if ($('#show_password').is(":checked")) {
              $('#password').attr('type', 'text');
            } else {
              $('#password').attr('type', 'password');
            }
         };
         
          mscope.toggle_security = function() {
            if ($('#show_security').is(":checked")) {
              $('#security').attr('type', 'text');
            } else {
              $('#security').attr('type', 'password');
            }
          };
        });
      }
    };
    
    $SponsorService.show_view_only(options);
  };
  
});
app.controller('GdexApproveListCtrl', function($scope, $http, $location, $modal, noty, $GdexService, $GdService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.gds = [];
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    
    $GdService.get_all_approve().then(function(response) {
      
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.gds = response.data.gds;
    });
  };
  
  $scope.view_sponsor = function (pd) {
    var options = {
      'init': function(mscope) {
        $SponsorService.view(pd.sponsor).then(function(response) {
          var data = response.data;
          if (data.type == 1) {
            mscope.message = data.message;
            mscope.message_type = 1;
            return false;
          }
          mscope.sponsor = data.data;
          
          mscope.toggle_password = function() {
            if ($('#show_password').is(":checked")) {
              $('#password').attr('type', 'text');
            } else {
              $('#password').attr('type', 'password');
            }
         };
         
          mscope.toggle_security = function() {
            if ($('#show_security').is(":checked")) {
              $('#security').attr('type', 'text');
            } else {
              $('#security').attr('type', 'password');
            }
          };
        });
      }
    };
    
    $SponsorService.show_view_only(options);
  };
  
  $scope.confirm = function (gd) {
    var options = {
      'init': function(mscope) {
        mscope.gd = gd;
        
        mscope.$broadcast('GdexApproveListCtrl::edit', mscope);
        mscope.$on('GdexApproveListCtrl::edit::done', function(e, data) {
          $scope.init();
        });
      }
    };
    
    $GdexService.show_confirm_approve_modal(options).then(function() {
      
    });
  };
});

app.controller('GdexApproveEditCtrl', function($scope, $http, $location, $modal, noty, $GdexService, $GdService, $SponsorService) {
  
  $scope.pdex = {};
  
  $scope.$on('GdexApproveListCtrl::edit', function(e, data) {
     $scope.gd = data.gd;
     $scope.mscope = data;
  });
  
  $scope.noty = noty;
  
  $scope.processing = false;
  
  $scope.disabled = function() {
   return false;
  };
  
  $scope.submit = function() {
    $scope.processing = true;
    
    $GdexService.edit($scope.gd).then(function(response) {
      $scope.processing = false;
      
      if ($scope.message_type == 1) { 
        $scope.message_type = response.data.type;
        $scope.message = response.data.message;
      }
      else {
        $scope.pdex.status = 3;
        $scope.mscope.cancel();
        $scope.noty.add({type:'info', title:'Thông báo', body: 'Cập nhật thành công!'});
        $scope.$emit('GdexApproveListCtrl::edit::done', []);
      }
    });
  };
});
