<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-plus"></i> Đặt lệnh GET</h1>
  </div>
  <div>
  <div class="col-md-8">
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Mã GD</label>
      </div>
      <div class="col-md-8">
      <input ng-model="gd.code" type="input" name="code" class="form-control width300" 
          required autofocus ng-maxlength="255" placeholder="">
       </div>
       <div class="clearfix"></div>
    </div>
    {literal}
    <div class="form-group1">
      <div class="col-md-4 align-right">
      <label class="control-label">Sponsor</label>
      </div>
      <div class="col-md-8">
         <ui-select ng-model="gd.sponsor" theme="bootstrap" style="width:300px;" class="fleft">
          <ui-select-match placeholder="Select or search a sponsor in the list...">{{$select.selected.username}}</ui-select-match>
          <ui-select-choices repeat="item in sponsors | filter: $select.search">
          <div ng-bind-html="item.name | highlight: $select.search"></div>
          <small ng-bind-html="item.username | highlight: $select.search"></small>
          </ui-select-choices>
          </ui-select>
         <div class="clearfix"></div>
       </div>
       <div class="clearfix"></div>
    </div>
    {/literal}
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Receivable Amount</label>
      </div>
      <div class="col-md-8">
        <input ng-model="gd.amount" type="input" name="amount" class="form-control width300" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">From Wallet</label>
      </div>
      <div class="col-md-8">
        <input type="radio" ng-model="gd.wallet" name="wallet" value="C-Wallet"> C-Wallet 
        <input type="radio" ng-model="gd.wallet" name="wallet" value="R-Wallet"> R-Wallet 
      </div>
      <div class="clearfix"></div>
    </div>
    {literal}
    <div class="form-group1">
      <div class="col-md-4 align-right">
      <label class="control-label">Ngân hàng dự định GET</label>
      </div>
      <div class="col-md-8">
         <ui-select ng-model="gd.bank" theme="bootstrap" style="width:300px;" class="fleft">
          <ui-select-match placeholder="Select or search a bank in the list...">{{$select.selected.name}} {{$select.selected.account_hold_name}} {{$select.selected.account_number}}</ui-select-match>
          <ui-select-choices repeat="item in banks | filter: $select.search">
          <div ng-bind-html="item.name | highlight: $select.search"></div>
          <small ng-bind-html="item.account_hold_name + ' ' + item.account_number | highlight: $select.search"></small>
          </ui-select-choices>
     </ui-select> &nbsp;
         <a class="btn btn-sm btn-success" title="Add new" ng-click="show_bank_add()"> Thêm </a>
         <div class="clearfix"></div>
       </div>
       <div class="clearfix"></div>
    </div>
    {/literal}
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Số giờ y/c vào approve đã nhận tiền</label>
      </div>
      <div class="col-md-8">
        <input ng-model="gd.num_hours_gd_approve" ng-trim="true" type="input" name="num_hours_gd_approve" class="form-control width300" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Ngày tạo</label>
      </div>
      <div class="col-md-8">
        <input ng-model="gd.issued_at" datetime-picker date-format="dd/MM/yyyy HH:mm:ss" name="issued_at" class="form-control width300" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Trạng thái</label>
      </div>
      <div class="col-md-8">
        <select class="form-control width300" id="status" ng-model="gd.status" 
          ng-options="option.name for option in optionStatus track by option.id">
        </select>
        <em>Pending: Đang chờ xác nhận; Approved: Đã được xác nhận; Done: Đã hoàn thành.</em>
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
      <a ng-disabled="processing" href="/gd#!/list" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> Trở về</a>
    </div>
    <div class="clearfix"></div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-3"></div>
  <div class="clearfix"></div>
  </div>
</div>