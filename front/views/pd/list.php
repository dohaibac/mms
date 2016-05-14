<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-list"></i> Danh sách PD</h1>
  </div>
  <div id="toolbar-list" class="toolbar">
    <a href="/pd#!/add"
      data-toggle="tooltip" class="btn btn-primary btn-sm">
      <i class="fa fa-plus-square"></i>
      Đặt lệnh
    </a>
  </div> <!-- end toolbar -->
  <div class="table-responsive">
    <div class="alert alert-warning" ng-if="message">
      <div ng-class="message_type == 1 ? 'error-message' : 'success'">
        {literal}{{ message }}{/literal}
      </div>
    </div>
    <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
    <input ng-model="searchText" ng-change="refreshData()" placeholder="Search...">
    <div class="gridStyle" ng-grid="gridOptions" ng-hide="loading">
    </div>
  </div> <!-- end list-->
</div>
