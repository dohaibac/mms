app.controller('DashboardCtrl', function($scope, $http, $PdService, $GdService) {
  
  $scope.pds = {};
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    
    $PdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
    
      $scope.pds = response.data.pds;
    });
    
    $GdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
      
      $scope.gds = response.data.gds;
    });
  };
});
app.controller('DashboardPdCtrl', function($scope, $http, $PdService, $GdService) {
  
  $scope.pds = {};
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    
    $PdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
    
      $scope.pds = response.data.pds;
    });
    
    $GdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
      
      $scope.gds = response.data.gds;
    });
  };
});

app.controller('DashboardGetCtrl', function($scope, $http, $PdService, $GdService) {
  
  $scope.pds = {};
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    
    $PdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
    
      $scope.pds = response.data.pds;
    });
    
    $GdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
      
      $scope.gds = response.data.gds;
    });
  };
});
app.controller('DashboardGdCtrl', function($scope, $http, $PdService, $GdService) {
  
  $scope.pds = {};
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    
    $PdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
    
      $scope.pds = response.data.pds;
    });
    
    $GdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
      
      $scope.gds = response.data.gds;
    });
  };
});

app.controller('DashboardApproveCtrl', function($scope, $http, $PdService, $GdService) {
  
  $scope.pds = {};
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    
    $PdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
    
      $scope.pds = response.data.pds;
    });
    
    $GdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      };
      
      $scope.gds = response.data.gds;
    });
  };
});

