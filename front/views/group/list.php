<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-list"></i> Danh sách nhóm</h1>
  </div>
  <div id="toolbar-list" class="toolbar" ng-show="is_supper_group">
    <a href="{$app->lang('system-url-group_add')}"
      class="btn btn-primary btn-sm">
      <i class="fa fa-plus-square"></i>
      Thêm mới
    </a>
  </div> <!-- end toolbar -->
   <div class="table-responsive">
     <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
   <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-name">Tên nhóm</th>
        <th class="th-des">Mô tả</th>
        <th class="th-block">Trạng thái</th>
        <th ng-show="is_supper_group"></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="group in data.groups">
        <td> {{ $index + 1 }} </td>
        <td> {{ group.name }} </td>
        <td> {{ group.description }} </td>
        <td> 
          <i class="fa fa-toggle-on fa-rotate-180 inactive" ng-if="group.block == true"></i>
          <i class="fa fa-toggle-on active" ng-if="group.block == false"></i>
        </td>
        <td ng-show="is_supper_group">
           <a type="button" href="/system#!/group/edit/{{ group.id }}"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa"
            class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" ng-click="delete(group)"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa"
            type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a>
        </td>
      </tr>
      <tr ng-if="data.groups.length == 0">
        <td colspan="5">Chưa có nhóm nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
</div>