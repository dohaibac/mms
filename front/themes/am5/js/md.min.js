app.controller('ModalInstanceCtrl', function ($scope, $modalInstance, options) {
  $scope.options = $.extend({}, options);
  $scope.processing = false;

  // call the init method
  if (typeof $scope.options.init === 'function') {
    window.setTimeout(function() {
      $scope.options.init($scope);
      return true;
    }, 1);
  }

  $scope.submit = function() {
    if (!$scope.disabled()) {
      $scope.ok();
    }
    return false;
  };

  $scope.ok = function() {
    if (typeof $scope.options.ok === 'function') {
      $scope.options.ok($scope);
      return true;
    } else {
      $scope.close('CLOSE_MODAL');
      return false;
    }
  };

  $scope.close = function(data) {
    $modalInstance.close(data);
    return false;
  };

  $scope.cancel = function(message) {
    $modalInstance.dismiss( (angular.isDefined(message)? message : '') );
    return false;
  };

  $scope.error = function(message) {
    $scope.notification.set({
      'show': true,
      'message': message,
      'class': 'alert-error'
    }, false);

    return true;
  };

  $scope.inactive = function(invalid) {
    if (invalid && !$scope.processing) {
      return true;
    } else if (!invalid && $scope.processing) {
      return true;
    }
    return false;
  };

  $scope.disabled = function() {
    if (typeof $scope.options.disabled === 'function') {
      return $scope.options.disabled($scope);
    }
    return true;
  };

  return $scope;
});