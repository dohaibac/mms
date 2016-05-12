<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-edit"></i> Sửa thông tin ứng viên</h1>
  </div>
  <div>
  <div class="col-md-8">
    <div class="form-group">
      <label class="col-md-2 control-label">Họ và Tên</label>
      <div class="col-md-10">
      <input ng-model="candidate.display_name" type="input" name="display_name" class="form-control" 
          required autofocus ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Email</label>
      <div class="col-md-10">
      <input ng-model="candidate.email" type="input" name="email" class="form-control" 
         required ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Mobile</label>
      <div class="col-md-10">
      <input ng-model="candidate.mobile" type="input" name="mobile" class="form-control" 
         required ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
     <div class="form-group">
      <label class="col-md-2 control-label">Địa chỉ</label>
      <div class="col-md-10">
      <input ng-model="candidate.addr" type="input" name="addr" class="form-control" 
         required ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Ghi chú</label>
      <div class="col-md-10">
        <textarea ng-model="candidate.notes" ng-trim="true" class="form-control"></textarea>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label"></label>
      <div class="col-md-10">
      <div class="alert alert-warning" ng-if="message">
      <div ng-class="message_type == 1 ? 'error-message' : 'success'">
        {literal}{{ message }}{/literal}
      </div>
      </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label"></label>
      <div class="col-md-10">
      <button ng-disabled="disabled()" ng-click="submit()" 
      class="btn btn-sm btn-primary" type="submit">
      <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
      <a ng-disabled="processing" href="/other#!/candidate/list" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> Trở về</a>
    </div>
    <div class="clearfix"></div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-3"></div>
  <div class="clearfix"></div>
  </div>
</div>