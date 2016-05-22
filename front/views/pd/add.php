<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-plus"></i> Đặt lệnh PD</h1>
  </div>
  <div>
  <div class="col-md-8">
    <div class="form-group" ng-if="message_setting">
      <div class="col-md-4 align-right">
      <label class="control-label"></label>
      </div>
      <div class="col-md-8">
      <div class="alert alert-warning">
      <div ng-class="message_setting_type == 1 ? 'error-message' : 'success'">
        {literal}{{ message_setting }}{/literal}
      </div>
      </div>
      </div>
      <div class="clearfix"></div>
    </div>
    {literal}
    <div class="form-group1">
      <div class="col-md-4 align-right">
      <label class="control-label">Thành viên</label>
      </div>
      <div class="col-md-8">
         <ui-select ng-model="pd.sponsor" theme="bootstrap" class="width100p fleft">
          <ui-select-match placeholder="Select or search a sponsor in the list...">{{$select.selected.sponsor}}</ui-select-match>
          <ui-select-choices repeat="item in sponsors | filter: $select.search">
          <div ng-bind-html="item.sponsor | highlight: $select.search"></div>
          <small ng-bind-html="item.sponsor | highlight: $select.search"></small>
          </ui-select-choices>
          </ui-select>
         <div class="clearfix"></div>
       </div>
       <div class="clearfix"></div>
    </div>
    {/literal}
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Số tiền</label>
      </div>
      <div class="col-md-8">
        <input ng-model="pd.amount" type="input" name="amount" class="form-control width100p" 
         required ng-trim="true" ng-maxlength="255" ng-model-onblur ng-change="convert_money()">
          {literal}
          <div>
           {{ pd.amount }} = {{ pd.amount * 10000 | currency: "VND " : 2 }}
          </div>
          <div>
           {{ amount_money_text }}
          </div>
          {/literal}
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Ngày đặt lệnh</label>
      </div>
      <div class="col-md-8">
        <input ng-model="pd.issued_at" datetime-picker date-format="MM/dd/yyyy" name="issued_at" class="form-control width100p" 
         required ng-trim="true" ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Trạng thái</label>
      </div>
      <div class="col-md-8">
        <select class="form-control width100p" id="status" ng-model="pd.status"
         ng-options="option.name for option in optionStatus track by option.id">
        </select>
        <em>Pending: Đang chờ PD; Pending Payment: PD; Approved: Hoàn thành.</em>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label"></label>
      </div>
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
      <div class="col-md-4 align-right">
        <label class="control-label"></label>
      </div>
      <div class="col-md-8">
      <button ng-disabled="disabled()" ng-click="submit()" 
      class="btn btn-sm btn-primary" type="submit">
      <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
      <a ng-disabled="processing" href="/pd#!/list" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> Trở về</a>
    </div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-3"></div>
  <div class="clearfix"></div>
  </div>
</div>