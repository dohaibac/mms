<div class="container" ng-init="init()">
<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h4>Danh sách Mã đầu tư</h4>
  </div>
  <div class="dashboard-main-body">
   <div class="table-responsive">
    <p>Search: <input class="form-control" type="text" ng-model="filter.$" /></p>
    
    <a class="btn btn-link" ng-click="view_all()">Xem tất cả</a>
    
    <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
    <table class="table table-bordered table-striped" ng-hide="loading" ng-table="tableParams">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-des">Mã</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="sponsor in $data">
        <td> {{ $index + 1 }} </td>
        <td><a class="btn-link" ng-click="view_sponsor(sponsor)"> {{ sponsor.sponsor }} </a></td>
        <td>
        </td>
      </tr>
      <tr ng-if="planpds.length == 0">
        <td colspan="3">Chưa có Mã đầu tư nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  </div>
</div>
</div>