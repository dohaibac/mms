app.controller('HeadCtrl', function($scope, $rootScope, $http, $location, noty) {
  $scope.showmenu = false;
  
  $scope.close = function() {
    $scope.showmenu = false;
  };

  $scope.toggle_menu = function(e) {
    $scope.showmenu = !$scope.showmenu;
    e.stopPropagation();
  };
  
  $rootScope.$on("documentClicked", _close);
  $rootScope.$on("escapePressed", _close);

  function _close() {
    $scope.$apply(function() {
        $scope.close(); 
    });
  }
});

app.run(function($rootScope) {
  document.addEventListener("keyup", function(e) {
    if (e.keyCode === 27)
      $rootScope.$broadcast("escapePressed", e.target);
  });
  
  document.addEventListener("click", function(e) {
    $rootScope.$broadcast("documentClicked", e.target);
  });
});
app.directive("menu", function() {
  return {
    restrict: "E",
    template: "<div ng-class='{ show: visible, left: alignment === \"left\"}' ng-transclude></div>",
    transclude: true,
          scope: {
              visible: "=",
              alignment: "@"
          }
  };
});