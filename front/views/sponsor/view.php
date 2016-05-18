{literal}
<div class="modal-header">
  <h3 class="modal-title">Thông tin thành viên</h3>
</div>
<div class="modal-body dashboard-main"> 
   <div class="table-responsive">
     <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">User name</label>
      </div>
      <div class="col-md-9">
        {{ sponsor.username}}
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Upline</label>
      </div>
      <div class="col-md-9">
        {{ sponsor.upline}}
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Cấp độ</label>
      </div>
      <div class="col-md-9">
        {{ sponsor.sponsor_level }}
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label red">Mật khẩu</label>
      </div>
      <div class="col-md-9">
        <input class="sim-span" id="password" type="password" ng-model="sponsor.ptl" ng-maxlength="255"/>
        &nbsp;<input id="show_password" type="checkbox" ng-click="toggle_password()" /> Hiển thị
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label red">Security</label>
      </div>
      <div class="col-md-9">
         <input class="sim-span" id="security" type="password" ng-model="sponsor.sec" ng-maxlength="255"/>
          &nbsp;
        <input id="show_security" type="checkbox" ng-click="toggle_security()" /> Hiển thị
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
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}