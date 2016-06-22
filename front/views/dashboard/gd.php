<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h4>Danh sách các mã đang GD</b></h4>
    <span class="bold green">Các mã đang ở trạng thái GD bên M5<br/><br/></span>
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
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="get in gds">
        <td> {{ $index + 1 }} </td>
        <td><a class="btn-link" ng-click="view_sponsor(get)"> {{ get.sponsor }} </a></td>
        <td>
          {{ get.issued_at_display}}
        </td>
      </tr>
      <tr ng-if="gds.length == 0">
        <td colspan="3">Chưa có GD nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  </div>
</div>