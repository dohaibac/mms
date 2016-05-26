<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h4>Danh sách PD đã hoàn thành ngày <b>{literal} {{ from_date }} {/literal}</b></h4>
    <span>Sau khi chuyển xong tiền thì click vào Xác nhận.<br/><br/></span>
  </div>
  <div class="dashboard-main-body">
   <div class="table-responsive">
    <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
    <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-des">Mã</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="pd in pdexs">
        <td> {{ $index + 1 }} </td>
        <td><a class="btn-link" ng-click="view_sponsor(pd)"> {{ pd.sponsor }} </a></td>
        <td>
           <button class="btn btn-sm btn-warning" ng-click="confirm(pd)">Xác nhận</button>
        </td>
      </tr>
      <tr ng-if="pdexs.length == 0">
        <td colspan="3">Chưa có PD nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  </div>
</div>