<div class="container">
<div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-plus"></i> Cập nhật Thành viên</h1>
  </div>
  <div>
  <div class="col-md-1"></div>
  <div class="col-md-10">
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
          required ng-minlength="3" ng-maxlength="255">
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
      <label class="control-label">Mật khẩu</label>
      </div>
      <div class="col-md-10">
      <input ng-model="sponsor.ptl" type="password" id="ptl" name="ptl" class="form-control width50p fleft" 
       ng-maxlength="255">&nbsp;
       <input id="show_password" type="checkbox" ng-click="toggle_password()" /> Show password
       <div class="clearfix"></div>
       </div>
       <div class="clearfix"></div>
    </div>
    {literal}
    <div class="form-group1">
      <div class="col-md-2 align-right">
      <label class="control-label">Ngân hàng</label>
      </div>
      <div class="col-md-10">
         <ui-select ng-model="sponsor.bank" theme="bootstrap" style="width:300px;" class="fleft">
          <ui-select-match placeholder="Select or search a bank in the list...">{{$select.selected.name}} {{$select.selected.account_hold_name}} {{$select.selected.account_number}}</ui-select-match>
          <ui-select-choices repeat="item in banks | filter: $select.search">
          <div ng-bind-html="item.name | highlight: $select.search"></div>
          <small ng-bind-html="item.account_hold_name + ' ' + item.account_number | highlight: $select.search"></small>
          </ui-select-choices>
     </ui-select> &nbsp;
         <a class="btn btn-sm btn-success" title="Add new" ng-click="show_bank_add()"> Thêm ngân hàng </a>
         <div class="clearfix"></div>
       </div>
       <div class="clearfix"></div>
    </div>
    {/literal}
    <div class="form-group">
      <div class="col-md-2 align-right">
      <label class="control-label"></label>
      </div>
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
      <div class="col-md-2 align-right">
      <label class="control-label"></label>
      </div>
      <div class="col-md-10">
      <button ng-disabled="disabled()" ng-click="submit()" 
      class="btn btn-sm btn-primary" type="submit">
      <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
    </div>
    <div class="clearfix"></div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-1"></div>
  <div class="clearfix"></div>
  </div>
</div>
</div>