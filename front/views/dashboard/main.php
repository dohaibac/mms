<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/pd.js"></script>
<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/gd.js"></script>
<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/planpd.js"></script>
<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/planpd.js"></script>
<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/dashboard.js"></script>

<div ng-controller="DashboardCtrl" ng-init="init()">
<!-- load phan storage -->
{literal}
<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h1>Dashboard</h1>
  </div>
  <div class="dashboard-main-body">
  <ul class="switch-item">
  <li ng-repeat="pd in pds">
    <a><span>{{ pd.stotal }}</span> <br/>PD {{ pd.name }}</a>
  </li>
  <li ng-repeat="gd in gds">
    <a>
    <div ng-if="gd.name == 'Pending'">
      <span>{{ gd.stotal }}</span> <br/> GET
    </div>
    <div ng-if="gd.name == 'Pending Verification'">
      <span>{{ gd.stotal }}</span> <br/> GD
    </div>
    <div ng-if="gd.name == 'Done'">
     <span>{{ gd.stotal }}</span> <br/>  GD hoàn thành
    </div>
    </a>
  </li>
  </ul>
  <div class="clearfix"></div>
  </div>
</div>
<!-- END load phan storage -->
{/literal}
</div>

<div class="dashboard-main" ng-controller="PlanpdListCtrl" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h4>Danh sách PD dự kiến <b>{literal} {{ from_date }} {/literal}</b></h4>
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
        <td> {{ pd.sponsor }} </td>
        <td>
           <button class="btn btn-warning" ng-click="confirm(pd)">Xác nhận</button>
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
</div>