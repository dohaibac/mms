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
    
    <table class="table table-bordered table-striped" ng-hide="loading">
      <thead>
        <tr>
          <th class="th-ord">#</th>
          <th class="th-name">Họ tên</th>
          <th class="th-name">Tên đăng nhập</th>
          <th class="th-email">Email</th>
          <th class="th-mobile">Mobile</th>
          <th class="th-mobile">System Code</th>
          <th class="th-block">Trạng thái</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        {literal}
        <tr ng-repeat="user in users">
          <td> {{ $index + 1 }} </td>
          <td> {{ user.display_name }} </td>
          <td> {{ user.user_name }} </td>
          <td> {{ user.email }} </td>
          <td> {{ user.mobile }} </td>
          <td> {{ user.system_code }} </td>
          <td>
            <i class="fa fa-toggle-on fa-rotate-180 inactive" ng-if="user.block == true"></i>
            <i class="fa fa-toggle-on active" ng-if="user.block == false"></i>
          </td>
          <td>
             <a type="button" href="/system#!/user/edit_downline/{{ user.id }}/{{ user.system_code }}"
               data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa"
              class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>
              <a href="javascript:void(0)" ng-click="delete(user)"
               data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa"
              type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a>
          </td>
        </tr>
        <tr ng-if="users.length == 0">
          <td colspan="7">Chưa có thành viên nào!</td>
        </tr>
        {/literal}
      </tbody>
    </table>
  </div> <!-- end list-->
</div>
