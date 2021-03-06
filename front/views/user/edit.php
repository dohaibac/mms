<div class="dashboard-main"  ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-edit"></i> Cập nhật thành viên quản trị</h1>
  </div>
  <div>
  <div class="col-md-8">
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Họ tên</label>
      </div>
      <div class="col-md-8">
      <input ng-model="user.display_name" ng-trim="true"  type="input" name="display_name" class="form-control" 
          required autofocus ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Tên đăng nhập</label>
      </div>
      <div class="col-md-8">
      <input ng-model="user.user_name" ng-trim="true" readonly="readonly" type="input" name="user_name" class="form-control" 
          required  ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Email</label>
      </div>
      <div class="col-md-8">
      <input ng-model="user.email" ng-trim="true" readonly="readonly"  type="input" name="user_name" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Mobile</label>
      </div>
      <div class="col-md-8">
      <input ng-model="user.mobile" ng-trim="true"  type="input" name="mobile" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Mật khẩu</label>
      </div>
      <div class="col-md-8">
      <input ng-model="user.password" type="password" name="password" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Nhập lại Mật khẩu</label>
      </div>
      <div class="col-md-8">
      <input ng-model="user.repassword" type="password" name="repassword" class="form-control" 
         required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Sponsor owner</label>
      </div>
      <div class="col-md-8">
      <input ng-model="user.sponsor_owner" type="text" name="sponsor_owner" class="form-control" 
        ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Thuộc nhóm quản trị</label>
      </div>
      <div class="col-md-8">
      <select class="form-control" id="group_id" ng-model="user.group_id"
         ng-options="item.id as item.name for item in groups | orderBy:['ord','name']">
      </select>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Khóa tài khoản?</label>
      </div>
      <div class="col-md-8">
        <input checked data-toggle="toggle" ng-model="user.block" type="checkbox">
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
      <div class="col-md-4 align-right">
      <label class="control-label"> &nbsp;</label>
      </div>
      <div class="col-md-8">
        <button ng-click="show_mobile(user)" 
      class="btn btn-sm btn-warning" type="button">
      Phân quyền nhận tin</button>
      
      <button ng-disabled="disabled()" ng-click="submit()" 
      class="btn btn-sm btn-primary" type="submit">
      <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
      <a ng-disabled="processing" href="/system#!/user/list" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> Trở về</a>
    </div>
    <div class="clearfix"></div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-3"></div>
  <div class="clearfix"></div>
  </div>
</div>