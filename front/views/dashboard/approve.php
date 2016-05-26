<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h4>Danh sách các mã cần xác nhận</b></h4>
    <span>Bạn cần vào M5 để xác nhận cho khách!<br/><br/></span>
  </div>
  <div class="dashboard-main-body">
   <div class="table-responsive">
    <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
    <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-name">Mã</th>
        <th class="th-date">Ngày đặt lệnh</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="gd in gds">
        <td> {{ $index + 1 }} </td>
        <td><a class="btn-link" ng-click="view_sponsor(gd)"> {{ gd.sponsor }} </a></td>
        <td>
          {{ gd.issued_at_display}}
        </td>
        <td>
          <div ng-if="gd.status == 2">
           <button class="btn btn-sm btn-warning" ng-click="confirm(gd)">Đã Xác nhận</button>
           <a class="btn btn-link" target="_blank" href="https://vphp.biz/login">Link M5</a>
          </div>
          <div ng-if="gd.status == 3">
           <a class="btn confirmed"><i class="fa fa-check"></i></a>
          </div> 
        </td>
      </tr>
      <tr ng-if="gds.length == 0">
        <td colspan="3">Chưa có mã nào cần xác nhận!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  </div>
</div>