<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-th"></i> Danh sách GET</h1>
  </div>
  <div id="toolbar-list" class="toolbar">
    <a href="/gd#!/add"
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
   <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-code">Mã</th>
        <th class="th-name">Sponsor</th>
        <th class="th-amount">Amount</th>
        <th class="th-date">Ngày tạo</th>
        <th class="th-status">Trạng thái</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="gd in gds">
        <td> {{ $index + 1 }} </td>
        <td> {{ gd.code }} </td>
        <td> {{ gd.sponsor }} </td>
        <td> {{ gd.amount }} </td>
        <td> {{ gd.issued_at }} </td>
        <td> 
          <span ng-if="gd.status==1">Pending</span>
          <span ng-if="gd.status==2">Pending Verification</span>
          <span ng-if="gd.status==3">Done</span>
        <td>
           <a type="button" href="/gd#!/edit/{{ gd.id }}"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa"
            class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" ng-click="delete(gd)"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa"
            type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a>
        </td>
      </tr>
      <tr ng-if="gds.length == 0">
        <td colspan="7">Chưa có lệnh GET nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
</div>