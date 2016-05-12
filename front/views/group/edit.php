<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-th"></i> Sửa nhóm</h1>
  </div>
  <div>
  <div class="col-md-8">
    <div class="form-group">
      
      <label class="col-md-3 control-label">Tên nhóm</label>
      <div class="col-md-9">
      <input ng-model="group.name" type="input" name="name" class="form-control" 
          required autofocus ng-minlength="3" ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">Thứ tự</label>
      <div class="col-md-9">
      <input ng-model="group.ord" type="input" name="ord" class="form-control" 
         required ng-maxlength="4">
       </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">Mô tả</label>
      <div class="col-md-9">
      <textarea ng-model="group.description" ng-trim="true" class="form-control"></textarea>
      </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">Khóa nhóm?</label>
      <div class="col-md-9">
        <input checked data-toggle="toggle" ng-model="group.block" type="checkbox">
      </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label"></label>
      <div class="col-md-9">
      <div class="alert alert-warning" ng-if="message">
      <div ng-class="message_type == 1 ? 'error-message' : 'success'">
        {literal}{{ message }}{/literal}
      </div>
      </div>
      </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">&nbsp;</label>
      <div class="col-md-9">
      <button ng-disabled="disabled()" ng-click="submit()" 
      class="btn btn-sm btn-primary" type="submit">
      <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
      <a ng-disabled="processing" href="/system#!/group/list" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> Trở về</a>
    </div>
     <div class="clearfix"></div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-3"></div>
  <div class="clearfix"></div>
  </div>
</div>