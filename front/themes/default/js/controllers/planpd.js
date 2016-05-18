app.controller('PlanpdListCtrl', function($scope, $http, $location, $modal, noty, $PlanpdService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.planpds = [];
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    $PlanpdService.get_all().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.from_date = response.data.from_date;
      $scope.planpds = response.data.planpds;
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
    alert('Dang cap nhat!');
  };
  
});
