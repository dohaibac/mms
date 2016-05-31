<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-list"></i> Danh sách ứng viên</h1>
  </div>
  <div id="toolbar-list" class="toolbar">
    <a href="/other#!/candidate/add" class="btn btn-primary btn-sm">
      <i class="fa fa-plus-square"></i>
      Thêm mới
    </a>
  </div> <!-- end toolbar -->
   <div class="table-responsive">
   <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
   <input ng-model="searchText" ng-change="refreshData()" placeholder="Search...">
    <div class="gridStyle" ng-grid="gridOptions" ng-hide="loading">
    </div>
  </div> <!-- end list-->
</div>
