<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/sponsor.js"></script>
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
