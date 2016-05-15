<div ng-controller="SponsorEditCtrl">
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
        <div ng-hide="editing">
        {{ sponsor.item.sponsor_level }}
        </div>
        <div ng-show="editing">
          <select class="form-control" id="sponsor_level" ng-model="sponsor.item.sponsor_level"
           ng-options="item as item for item in levels">
          </select>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Họ tên</label>
      </div>
      <div class="col-md-9">
        <div ng-hide="editing">
        {{ sponsor.item.name }}
        </div>
        <div ng-show="editing">
          <input class="form-control" ng-model="sponsor.item.name" ng-maxlength="255"/>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label red">Mật khẩu</label>
      </div>
      <div class="col-md-9">
        <div ng-hide="editing">
        <input class="sim-span" id="password" type="password" ng-model="sponsor.item.ptl" ng-maxlength="255"/>
        &nbsp;<input id="show_password" type="checkbox" ng-click="toggle_password()" /> Hiển thị
        </div>
         <div ng-show="editing">
          <input class="form-control" type="password" id="password_input" ng-model="sponsor.item.ptl" ng-maxlength="255"/>
           &nbsp;<input id="show_password_input" type="checkbox" ng-click="toggle_password_input()" /> Hiển thị
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label red">Security</label>
      </div>
      <div class="col-md-9">
        <div ng-hide="editing">
          <input class="sim-span" id="security" type="password" ng-model="sponsor.item.sec" ng-maxlength="255"/>
          &nbsp;
        <input id="show_security" type="checkbox" ng-click="toggle_security()" /> Hiển thị
        </div>
         <div ng-show="editing">
          <input class="form-control" type="password" id="security_input" ng-model="sponsor.item.sec" ng-maxlength="255"/>
          &nbsp;<input id="show_security_input" type="checkbox" ng-click="toggle_security_input()" /> Hiển thị
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Email</label>
      </div>
      <div class="col-md-9">
        <div ng-hide="editing">
        {{ sponsor.item.email }}
        </div>
        <div ng-show="editing">
          <input class="form-control" ng-model="sponsor.item.email" ng-maxlength="255"/>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Mobile</label>
      </div>
      <div class="col-md-9">
        <div ng-hide="editing">
        {{ sponsor.item.mobile }}
        </div>
        <div ng-show="editing">
          <input class="form-control" ng-model="sponsor.item.mobile" ng-maxlength="255"/>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
      <label class="control-label">&nbsp;</label>
      </div>
      <div class="col-md-9">
        <input type="radio" ng-model="sponsor.item.sponsor_invest" name="sponsor_invest[]" value="dt" checked="checked" /> Mã đầu tư &nbsp;
        <input type="radio" ng-model="sponsor.item.sponsor_invest" name="sponsor_invest[]" value="ht"/> Mã hệ thống
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
</div>