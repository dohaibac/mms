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
    <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
    <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-code">Mã</th>
        <th class="th-name">Sponsor</th>
        <th class="th-amount">Amount</th>
        <th class="th-amount">Remain Amount</th>
        <th class="th-date">Ngày tạo</th>
        <th class="th-status">Trạng thái</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="pd in pds">
        <td> {{ $index + 1 }} </td>
        <td> {{ pd.code }} </td>
        <td> {{ pd.sponsor }} </td>
        <td> {{ pd.amount }} </td>
        <td> {{ pd.remain_amount }} </td>
        <td> {{ pd.issued_at }} </td>
        <td> 
          <span ng-if="pd.status==1">Pending</span>
          <span ng-if="pd.status==2">Pending Payment</span>
          <span ng-if="pd.status==3">Approved</span>
        <td>
           <a type="button" href="/pd#!/edit/{{ pd.id }}"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa"
            class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" ng-click="delete(pd)"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa"
            type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a>
        </td>
      </tr>
      <tr ng-if="pds.length == 0">
        <td colspan="8">Chưa có PD nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
</div>