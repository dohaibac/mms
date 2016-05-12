app.service('noty', ['$rootScope', function( $rootScope ) {
    var queue = [];
            
    return {
      queue: queue,
      add: function( item ) {
        queue.push(item);
        setTimeout(function(){
          // remove the alert after 2000 ms
          $('.alerts .alert').eq(0).remove();
          queue.shift();
        },5000);
      },
      pop: function(){
        return this.queue.pop();
      }
    };
  }]);
  
app.controller('NotyCtrl', function($scope, noty) {
  $scope.noty = noty;
});