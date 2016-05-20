<div class="container">
<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h4>Danh sách Mã đầu tư</h4>
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
      <tr ng-repeat="pd in planpds">
        <td> {{ $index + 1 }} </td>
        <td><a class="btn-link" ng-click="view_sponsor(pd)"> {{ pd.sponsor }} </a></td>
        <td>
          <div ng-if="pd.status == 0">
           <button class="btn btn-sm btn-warning" ng-click="confirm(pd)">Đã Xác nhận</button>
           <a class="btn btn-link" target="_blank" href="https://vphp.biz/login">Link M5</a>
          </div>
          <div ng-if="pd.status == 1">
           <a class="btn confirmed"><i class="fa fa-check"></i></a>
          </div> 
        </td>
      </tr>
      <tr ng-if="planpds.length == 0">
        <td colspan="3">Chưa có GD cần xác nhận nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  </div>
</div>
</div>