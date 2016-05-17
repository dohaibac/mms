<link rel="stylesheet" type="text/css" href="{$app->appConf->theme_default}/css/ng-grid.min.css" />
<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-list"></i> Danh sách tài khoản quản trị downline</h1>
  </div>
  <div id="toolbar-list" class="toolbar">
    {if $app->user->data()->group_id == 1}
    <a href="/system#!/user/add_downline"
      data-toggle="tooltip" 
      class="btn btn-warning btn-sm">
      <i class="fa fa-plus-square"></i>
      Tạo thành viên downline
    </a>
    {/if}
  </div> <!-- end toolbar -->
    <div class="table-responsive" >
      <input ng-model="searchText" ng-change="refreshData()" placeholder="Search...">
      
      <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
      <div class="gridStyle" ng-grid="gridOptions" ng-hide="loading">
      </div>
  </div> <!-- end list-->
</div>
