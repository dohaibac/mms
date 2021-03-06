<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h4>Danh sách PD ngày <b>{literal} {{ from_date }} {/literal}</b></h4>
    <span class="red bold">Bạn cần vào M5 để chuyển tiền!<br/><br/></span>
  </div>
  <div class="dashboard-main-body">
   <div class="table-responsive">
    <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
    <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-code">Mã</th>
        <th class="th-date">Ngày đặt lệnh</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="pd in pdexs">
        <td> {{ $index + 1 }} </td>
        <td><a class="btn-link" ng-click="view_sponsor(pd)"> {{ pd.sponsor }} </a></td>
        <td>
          {{ pd.issued_at_display}}
        </td>
        <td>
          <div ng-if="pd.status == 0">
           <button class="btn btn-sm btn-warning" ng-click="confirm(pd)">Xác nhận đã chuyển tiền</button>
           <a class="btn btn-link" target="_blank" href="https://vphp.biz/login">Link M5</a>
          </div>
          <div ng-if="pd.status == 1">
           <a class="btn confirmed"><i class="fa fa-check"></i></a>
          </div> 
        </td>
      </tr>
      <tr ng-if="pdexs.length == 0">
        <td colspan="4">Chưa có PD nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  </div>
</div>