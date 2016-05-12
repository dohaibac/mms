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
   <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-full-name">Họ tên</th>
        <th class="th-email">Email</th>
        <th class="th-mobile">Mobile</th>
        <th class="th-addr">Địa chỉ</th>
        <th class="th-date">Ngày tạo</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="candidate in candidates">
        <td> {{ $index + 1 }} </td>
        <td> {{ candidate.display_name }} </td>
        <td> {{ candidate.email }} </td>
        <td> {{ candidate.mobile }} </td>
        <td> {{ candidate.addr }} </td>
        <td> {{ candidate.created_at }} </td>
        <td>
           <a type="button" href="/other#!/candidate/edit/{{ candidate.id }}"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa"
            class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" ng-click="delete(candidate)"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa"
            type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a>
        </td>
      </tr>
      <tr ng-if="candidates.length == 0">
        <td colspan="7">Chưa có ứng viên nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
</div>