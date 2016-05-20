app.controller('GdexListCtrl', function($scope, $http, $location, $modal, noty, $PdexService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.pdexs = [];
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    $PdexService.get_all().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.from_date = response.data.from_date;
      $scope.pdexs = response.data.pdexs;
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
  
  $scope.confirm = function (pd) {
    var options = {
      'init': function(mscope) {
        mscope.pd = pdex;
        
        mscope.$broadcast('pdex::edit', mscope);
      }
    };
    
    $PdexService.show_confirm_modal(options).then(function() {
      
    });
  };
  
});

app.controller('GdexEditCtrl', function($scope, $http, $location, $modal, noty, $PdexService, $SponsorService) {
  
  $scope.pdex = {};
  
  $scope.$on('pdex::edit', function(e, data) {
     $scope.pdex = data.pdex;
     $scope.mscope = data;
  });
  
  $scope.noty = noty;
  
  $scope.processing = false;
  
  $scope.disabled = function() {
   return false;
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $PdexService.edit($scope.pdex).then(function(response) {
      $scope.processing = false;
      
      if ($scope.message_type == 1) { 
        $scope.message_type = response.data.type;
        $scope.message = response.data.message;
      }
      else {
        $scope.mscope.cancel();
        $scope.noty.add({type:'info', title:'Thông báo', body: 'Cập nhật thành công!'});
      }
    });
  };
});

