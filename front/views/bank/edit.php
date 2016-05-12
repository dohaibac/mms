<div class="modal-header">
  <h3 class="modal-title">Sửa tài khoản ngân hàng</h3>
</div> 
<div class="modal-body dashboard-main">
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Name</label>
      </div>
      <div class="col-md-8">
      <select class="form-control" id="name" ng-model="bank.name">
       <option value="vietcombank">vietcombank</option>
       <option value="sacombank">sacombank</option>
       <option value="viettinbank">viettinbank</option>
       <option value="BIDV">BIDV</option>
       <option value="agribank">agribank</option>
      </select>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Branch Name</label>
      </div>
      <div class="col-md-8">
      <input ng-model="bank.branch_name" type="input" name="branch_name" class="form-control" 
         required ng-maxlength="255">
       </div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Account Hold Name</label>
      </div>
      <div class="col-md-8">
      <input ng-model="bank.account_hold_name" type="input" name="account_hold_name" class="form-control" 
         required ng-maxlength="255">
       </div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Account Number</label>
      </div>
      <div class="col-md-8">
      <input ng-model="bank.account_number" type="input" name="account_number" class="form-control" 
         required ng-maxlength="255">
       </div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Linked Mobile Number</label>
      </div>
      <div class="col-md-8">
      <input ng-model="bank.linked_mobile_number" type="input" name="linked_mobile_number" class="form-control" 
         required ng-maxlength="12">
       </div>
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
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
  <button class="btn btn-sm btn-primary" ng-click="ok()" ng-disabled="disabled()">{$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>