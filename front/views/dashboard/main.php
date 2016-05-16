<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/pd.js"></script>
<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/gd.js"></script>s
<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/dashboard.js"></script>

<div class="dashboard-main">
  <div class="dashboard-main-title">
    <i class="fa fa-angle-right"></i> Thông tin wallet
  </div>
  <div class="dashboard-main-body">
  <div class="col-sm-4">
    <a class="btn">
      <img src="/themes/am5/images/e-wallet.png" /> <span>0.00</span>
    </a>
  </div>
  <div class="col-sm-4">
    <a class="btn">
      <img src="/themes/am5/images/r-wallet.png" /> <span>0.00</span>
    </a>
  </div>
  <div class="col-sm-4">
     <a class="btn">
      <img src="/themes/am5/images/i-wallet.png" /> <span>0.00</span>
    </a>
  </div>
  <div class="clearfix"></div>
  </div>
</div>

<!-- load phan storage -->
{literal}
<div class="dashboard-main" ng-controller="DashboardCtrl">
  <div class="dashboard-main-title">
    <i class="fa fa-cube"></i> Thông tin PD
  </div>
  <div class="dashboard-main-body" ng-init="init()">
  <div class="col-sm-12" ng-repeat="pd in pds">
    <a class="btn">
      Có {{ pd.stotal }} PD {{ pd.name }}
    </a>
  </div>
  <div class="clearfix"></div>
  </div>
</div>
<!-- END load phan storage -->

<!-- load phan short menu -->
<div class="dashboard-main" ng-controller="DashboardCtrl">
  <div class="dashboard-main-title">
    <i class="fa fa-external-link"></i> Thông tin GD
  </div>
  <div class="dashboard-main-body" ng-init="init()">
  <div class="col-sm-12" ng-repeat="gd in gds">
    <a class="btn">
      Có {{ gd.stotal }} GD {{ gd.name }}
    </a>
  </div>
  <div class="clearfix"></div>
  </div>
</div>
{/literal}
<!-- END load phan short menu -->
