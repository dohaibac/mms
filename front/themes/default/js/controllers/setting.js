app.controller('SettingCtrl', function($scope, $http, $SettingService) {
  $scope.setting = {};
  
  $scope.processing = false;
  
  $scope.disabled = function() {
    if (!$scope.setting.num_commands_per_day || 
      !$scope.setting.num_days_pd_pending || 
      !$scope.setting.num_days_pd_transfer || 
      !$scope.setting.num_days_gd_pending || 
      !$scope.setting.num_days_gd_pending_verification || 
      !$scope.setting.num_days_pd_next || 
      !$scope.setting.percent_rate_days || 
      !$scope.setting.percent_hoa_hong || $scope.processing) {
      return true;
    }
    return $scope.setting.num_commands_per_day.length > 0 && 
    $scope.setting.num_days_pd_pending.length > 0 && 
    $scope.setting.num_days_pd_transfer.length > 0 && 
    $scope.setting.num_days_gd_pending.length > 0 && 
    $scope.setting.num_days_gd_pending_verification.length > 0 && 
    $scope.setting.num_days_pd_next.length > 0 && 
    $scope.setting.percent_rate_days.length > 0 && 
    $scope.setting.percent_hoa_hong.length > 0 ? false : true;
  };
  
  $scope.init = function () {
    $SettingService.view().then(function(response) {
      if (response.data) {
        $scope.setting = response.data;
      }
    });
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    if ($scope.setting.id > 0) {
      $SettingService.edit($scope.setting).then(function(response) {
        $scope.processing = false;
        $scope.message_type = response.data.type;
        $scope.message = response.data.message;
      });
    }
    else {
      $SettingService.add($scope.setting).then(function(response) {
        $scope.processing = false;
        $scope.message_type = response.data.type;
        $scope.message = response.data.message;
      });
    }
  };
});