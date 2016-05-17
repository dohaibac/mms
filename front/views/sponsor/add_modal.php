<div ng-controller="SponsorAddModalCtrl">
{literal}
<div class="modal-header">
  <h3 class="modal-title">Thêm thành viên</h3>
</div>
<div class="modal-body dashboard-main"> 
   <div class="table-responsive">
     <div class="form-group">
      <div class="col-md-2 align-right">
        <label class="control-label">Họ tên</label>
      </div>
      <div class="col-md-10">
        <input ng-model="sponsor.name" type="input" name="name" class="form-control" 
         required autofocus ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
     <div class="form-group">
      <div class="col-md-2 align-right">
        <label class="control-label">Mã</label>
      </div>
      <div class="col-md-10">
        <input ng-model="sponsor.username" type="input" name="username" class="form-control" 
          required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-2 align-right">
        <label class="control-label">Cấp độ</label>
      </div>
      <div class="col-md-10">
        <select class="form-control" id="sponsor_level" ng-model="sponsor.sponsor_level"
         ng-options="item as item for item in levels">
        </select>
      </div>
      <div class="clearfix"></div>
    </div>
    {literal}
    <div class="form-group">
      <div class="col-md-2 align-right">
      <label class="control-label">Upline</label>
      </div>
      <div class="col-md-10">
      <input ng-model="sponsor.upline" type="input" name="upline" class="txt-sm fleft upline" 
          ng-minlength="3" ng-maxlength="255">&nbsp;
          <a class="btn btn-sm btn-success" ng-click="check_sponsor()">Kiểm tra</a>
       <div class="clearfix"></div>
        <div ng-if="sponsor_check.message_type == 1">
          <span class="red">{{ sponsor_check.message }}</span>
        </div>
        <div ng-if="sponsor_check.message_type == 0">
         <span class="green">{{ sponsor_check.sponsor.name }} - {{ sponsor_check.sponsor.username }} - {{ sponsor_check.sponsor.mobile }} - {{ sponsor_check.sponsor.email }}</span>
        </div>
       </div>
       <div class="clearfix"></div>
    </div>
    {/literal}
    <div class="form-group">
      <div class="col-md-2 align-right">
      <label class="control-label">Email</label>
      </div>
      <div class="col-md-10">
      <input ng-model="sponsor.email" type="input" name="email" class="form-control" 
          required ng-minlength="3" ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-2 align-right">
      <label class="control-label">Mobile</label>
      </div>
      <div class="col-md-10">
      <input ng-model="sponsor.mobile" type="input" name="mobile" class="form-control" 
          required ng-minlength="3" ng-maxlength="255">
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-2 align-right">
      <label class="control-label red">Mật khẩu</label>
      </div>
      <div class="col-md-10">
      <input ng-model="sponsor.ptl" type="password" id="ptl" name="ptl" class="form-control width50p fleft" 
       ng-maxlength="255">&nbsp;
       <input id="show_password" type="checkbox" ng-click="toggle_password()" /> Hiển thị
       <div class="clearfix"></div>
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-2 align-right">
      <label class="control-label red">Security</label>
      </div>
      <div class="col-md-10">
        <input ng-model="sponsor.sec" type="password" id="security" name="security" class="form-control width50p fleft" 
         ng-maxlength="255">&nbsp;
       <input id="show_security" type="checkbox" ng-click="toggle_security()" /> Hiển thị
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-2 align-right">
      <label class="control-label">&nbsp;</label>
      </div>
      <div class="col-md-10">
        <input type="radio" ng-model="sponsor.sponsor_invest" name="sponsor_invest[]" value="dt" checked="checked" /> Mã đầu tư &nbsp;
        <input type="radio" ng-model="sponsor.sponsor_invest" name="sponsor_invest[]" value="ht"/> Mã hệ thống
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
      <label class="control-label"></label>
      </div>
      <div class="col-md-9">
      <div class="alert alert-warning" ng-if="message">
      <div ng-class="message_type == 1 ? 'error-message' : 'success'">
        {literal}{{ message }}{/literal}
      </div>
      </div>
      </div>
      <div class="clearfix"></div>
    </div>
   </div>
</div>
<div class="modal-footer">
  <a ng-disabled="disabled()" ng-click="submit()" 
    class="btn btn-sm btn-primary" type="button"><i class="glyphicon glyphicon-save"></i> Lưu lại <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></a>
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}
</div>