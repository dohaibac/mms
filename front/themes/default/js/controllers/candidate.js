app.controller('CandidateListCtrl', function($scope, $http, $location, $modal, noty, $CandidateService) {
  
  $scope.noty = noty;
  
  $scope.loading = false;
  
  $scope.candidates = {};
  
  $scope.init = function () {
    $scope.loading = true;
    $CandidateService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.candidates = response.data.candidates;
      
    });
  };
  
  $scope.delete = function(candidate) {
     if (!confirm_del()) {
       return false;
     }
     
    $scope.processing = true;
    
    $CandidateService.delete(candidate).then(function(response) {
      $scope.processing = false;
      $scope.noty.add({type:'info', title:'Thông báo', body:response.data.message});
      $scope.init();
    });
    
  };
});

app.controller('CandidateAddCtrl', function($scope, $http, $location, $modal, $CandidateService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.candidate = {};
  
  $scope.disabled = function() {
    if ($scope.processing) {
      return true;
    }
    return false;
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $CandidateService.add($scope.candidate).then(function(response) {
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
      $scope.processing = false;
      
      if ($scope.message_type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Thêm ứng viên thành công!'});
      }
    });
  };
 
});

app.controller('CandidateEditCtrl', function($scope, $routeParams, $location, $modal, $CandidateService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.candidate = {};
  $scope.candidate.id = $routeParams.id;
   $scope.init = function() {
    $CandidateService.view($scope.candidate.id).then(function(response) {
      $scope.candidate = response.data;
    });
  };
  
  $scope.disabled = function() {
    if ($scope.processing) {
      return true;
    }
    
    return false;
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $CandidateService.edit($scope.candidate).then(function(response) {
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
      $scope.processing = false;
      
      if ($scope.message_type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Cập nhật ứng viên thành công!'});
      }
    });
  };
 
});
