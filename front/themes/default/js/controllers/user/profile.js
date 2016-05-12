app.controller('ProfileCtrl', function($scope, $http) {
  $scope.editing = false;
  
  $scope.user = {};
  
  $scope.processing = false;
  
  $scope.disabled = function() {
    return $scope.processing;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    var url = generate_url ('user', 'update');
   $http({
    method  : 'POST',
    url     : url,
    data    : $scope.user, 
    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
   })
   .success(function(data) {
      check_ajax_required_login(data);
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      $scope.processing = false;
      if (data.type == 0) {
        $scope.user = data.user;
        $scope.editing = false;
      }
   });
  };
  
});