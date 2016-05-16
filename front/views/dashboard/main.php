<div ng-controller="DashboardCtrl" ng-init="init()">
<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/pd.js"></script>
<script type="text/javascript" src="{$app->appConf->theme_default}/js/service/gd.js"></script>
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
<div class="dashboard-main">
  <div class="dashboard-main-title">
    <i class="fa fa-cube"></i> Thông tin PD
  </div>
  <div class="dashboard-main-body">
  <div class="col-sm-12" ng-repeat="pd in pds">
    <a class="btn">
     <b> Có <span class="bold red">{{ pd.stotal }}</span> PD {{ pd.name }}</b>
    </a>
  </div>
  <div class="clearfix"></div>
  </div>
</div>
<!-- END load phan storage -->

<!-- load phan short menu -->
<div class="dashboard-main">
  <div class="dashboard-main-title">
    <i class="fa fa-external-link"></i> Thông tin GD
  </div>
  <div class="dashboard-main-body">
  <div class="col-sm-12" ng-repeat="gd in gds">
    <a class="btn">
      <span ng-if="gd.name == 'Pending'">
       <b> Có <span class="bold red">{{ gd.stotal }}</span> lệnh GET</b>
      </span>
      <span ng-if="gd.name == 'Pending Verification'">
        <b>Có <span class="bold red">{{ gd.stotal }}</span> lệnh GD</b>
      </span>
      <span ng-if="gd.name == 'Done'">
       <b> Có <span class="bold red">{{ gd.stotal }}</span> lệnh GD đã hoàn thành</b>
      </span>
    </a>
  </div>
  <div class="clearfix"></div>
  </div>
</div>
{/literal}
<!-- END load phan short menu -->
</div>