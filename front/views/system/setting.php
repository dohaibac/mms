<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-th"></i> Cài đặt tham số</h1>
  </div>
  <div>
  <div class="col-md-8">
    <div class="form-group">
      <label class="col-md-4 control-label">Số ngày chờ PD tạm tính</label>
      <div class="col-md-8">
        <input type="hidden" ng-model="setting.id" />
      <input ng-model="setting.num_days_pd_pending" type="input" name="num_days_pd_pending" class="form-control" 
          required autofocus ng-trim="true"  ng-maxlength="255" placeholder="">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">Số ngày chờ chuyển tiền sau khi có lệnh PD</label>
      <div class="col-md-8">
      <input ng-model="setting.num_days_pd_transfer" ng-trim="true"  type="input" name="num_days_pd_transfer" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">Số ngày chờ có lệnh GD sau khi PD thành công</label>
      <div class="col-md-8">
        <input ng-model="setting.num_days_gd_pending" ng-trim="true"  type="input" name="num_days_gd_pending" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">Số ngày GD nhận tiền</label>
      <div class="col-md-8">
        <input ng-model="setting.num_days_gd_pending_verification" ng-trim="true"  type="input" name="num_days_gd_pending_verification" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">Số ngày yêu cầu vào approve đã nhận tiền</label>
      <div class="col-md-8">
        <input ng-model="setting.num_days_gd_approve" ng-trim="true"  type="input" name="num_days_gd_approve" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">Số ngày yêu cầu đặt lệnh PD tiếp theo</label>
      <div class="col-md-8">
        <input ng-model="setting.num_days_pd_next" ng-trim="true"  type="text" name="num_days_pd_next" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">% Lãi suất</label>
      <div class="col-md-8">
        <input ng-model="setting.percent_rate_days" ng-trim="true"  type="text" name="percent_rate_days" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">% Hoa hồng</label>
      <div class="col-md-8">
        <input ng-model="setting.percent_hoa_hong" ng-trim="true"  type="text" name="percent_hoa_hong" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label"></label>
      <div class="col-md-8">
      <div class="alert alert-warning" ng-if="message">
      <div ng-class="message_type == 1 ? 'error-message' : 'success'">
        {literal}{{ message }}{/literal}
      </div>
      </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">&nbsp;</label>
      <div class="col-md-8">
        <button ng-disabled="disabled()" ng-click="submit()" 
        class="btn btn-sm btn-primary" type="submit">
        <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
      </div>
      <div class="clearfix"></div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-3"></div>
  <div class="clearfix"></div>
  </div>
</div>