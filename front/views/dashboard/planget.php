<div class="dashboard-main" ng-controller="PlanGetListCtrl" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h4>Danh sách GET dự kiến ngày <b>{literal} {{ from_date }} {/literal}</b></h4>
    <span>Bạn cần vào M5 để đặt lệnh GET cho các mã sau, GET càng sớm tiền về càng sớm:<br/><br/></span>
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
      <tr ng-repeat="get in plangets">
        <td> {{ $index + 1 }} </td>
        <td><a class="btn-link" ng-click="view_sponsor(get)"> {{ get.sponsor }} </a></td>
        <td>
          <div ng-if="get.status == 0">
           <button class="btn btn-sm btn-warning" ng-click="confirm(get)">Xác nhận</button>
           <a class="btn btn-link" target="_blank" href="https://vphp.biz/login">Link M5</a>
          </div>
          <div ng-if="get.status == 1">
           <a class="btn confirmed"><i class="fa fa-check"></i></a>
          </div> 
        </td>
      </tr>
      <tr ng-if="plangets.length == 0">
        <td colspan="3">Chưa có GET dự kiến nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  </div>
</div>