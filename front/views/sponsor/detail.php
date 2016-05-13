{literal}
<div class="modal-header">
  <h3 class="modal-title">Thông tin thành viên</h3>
</div>
<div class="modal-body dashboard-main" ng-controller="SponsorEditCtrl"> 
   <div class="table-responsive">
     <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">User name</label>
      </div>
      <div class="col-md-9">
        {{ sponsor.item.username}}
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Upline</label>
      </div>
      <div class="col-md-9">
        {{ sponsor.item.upline}}
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Cấp độ</label>
      </div>
      <div class="col-md-9">
        <span ng-hide="editing">
        {{ sponsor.item.sponsor_level }}
        </span>
        <span ng-show="editing">
          <input class="form-control" ng-model="sponsor.item.sponsor_level" ng-maxlength="255"/>
        </span>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Họ tên</label>
      </div>
      <div class="col-md-9">
        <span ng-hide="editing">
        {{ sponsor.item.name }}
        </span>
        <span ng-show="editing">
          <input class="form-control" ng-model="sponsor.item.name" ng-maxlength="255"/>
        </span>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Mật khẩu</label>
      </div>
      <div class="col-md-9">
        <span ng-hide="editing">
        <input class="form-control sim-span" id="password"  type="password" ng-model="sponsor.item.ptl" ng-maxlength="255"/>
        &nbsp;<input id="show_password" type="checkbox" ng-click="toggle_password()" /> Hiển thị
        </span>
         <span ng-show="editing">
          <input class="form-control" id="security_input" ng-model="sponsor.item.ptl" ng-maxlength="255"/>
           &nbsp;<input id="show_password_input" type="checkbox" ng-click="toggle_password_input()" /> Hiển thị
        </span>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Security</label>
      </div>
      <div class="col-md-9">
        <span ng-hide="editing">
          <input class="form-control sim-span" id="security" type="password" ng-model="sponsor.item.sec" ng-maxlength="255"/>
          &nbsp;
        <input id="show_security" type="checkbox" ng-click="toggle_security()" /> Hiển thị
        </span>
         <span ng-show="editing">
          <input class="form-control" id="security_input" ng-model="sponsor.item.sec" ng-maxlength="255"/>
          &nbsp;<input id="show_security_input" type="checkbox" ng-click="toggle_security_input()" /> Hiển thị
        </span>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Email</label>
      </div>
      <div class="col-md-9">
        <span ng-hide="editing">
        {{ sponsor.item.email }}
        </span>
        <span ng-show="editing">
          <input class="form-control" ng-model="sponsor.item.email" ng-maxlength="255"/>
        </span>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Mobile</label>
      </div>
      <div class="col-md-9">
        <span ng-hide="editing">
        {{ sponsor.item.mobile }}
        </span>
        <span ng-show="editing">
          <input class="form-control" ng-model="sponsor.item.mobile" ng-maxlength="255"/>
        </span>
      </div>
      <div class="clearfix"></div>
    </div>
   </div>
</div>
<div class="modal-footer">
  <span ng-hide="editing">
    <a ng-click="editing = true" class="btn btn-sm btn-warning" type="button"><i class="glyphicon glyphicon-edit"></i> Sửa thông tin</a>
  </span>
  <span ng-show="editing">
  <a ng-disabled="disabled()" ng-click="submit()" 
    class="btn btn-sm btn-primary" type="button"><i class="glyphicon glyphicon-save"></i> Lưu lại <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></a>
  <a ng-disabled="processing" ng-click="editing = false" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> Hủy bỏ</a>
  </span>
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}