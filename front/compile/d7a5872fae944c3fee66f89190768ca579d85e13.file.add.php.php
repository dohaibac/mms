<?php /* Smarty version Smarty-3.1.18, created on 2016-05-12 11:16:01
         compiled from "views/pd/add.php" */ ?>
<?php /*%%SmartyHeaderCode:84390345457340381e3eb53-90610599%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7a5872fae944c3fee66f89190768ca579d85e13' => 
    array (
      0 => 'views/pd/add.php',
      1 => 1462868884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '84390345457340381e3eb53-90610599',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'app' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_57340381e999e9_67115987',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57340381e999e9_67115987')) {function content_57340381e999e9_67115987($_smarty_tpl) {?><div class="dashboard-main" ng-init="init()">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-plus"></i> Đặt lệnh PD</h1>
  </div>
  <div>
  <div class="col-md-8">
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Mã PD</label>
      </div>
      <div class="col-md-8">
      <input ng-model="pd.code" type="input" name="code" class="form-control width300" 
          required autofocus ng-trim="true" ng-maxlength="255" placeholder="">
       </div>
       <div class="clearfix"></div>
    </div>
    
    <div class="form-group1">
      <div class="col-md-4 align-right">
      <label class="control-label">Sponsor</label>
      </div>
      <div class="col-md-8">
         <ui-select ng-model="pd.sponsor" theme="bootstrap" style="width:300px;" class="fleft">
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
    
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Amount</label>
      </div>
      <div class="col-md-8">
        <input ng-model="pd.amount" type="input" name="amount" class="form-control width300" 
         required ng-trim="true" ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Remain Amount</label>
      </div>
      <div class="col-md-8">
        <input ng-model="pd.remain_amount" type="input" name="remain_amount" class="form-control width300" 
         required ng-trim="true" ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Ngày tạo</label>
      </div>
      <div class="col-md-8">
        <input ng-model="pd.issued_at" datetime-picker date-format="dd/MM/yyyy HH:mm:ss" name="issued_at" class="form-control width300" 
         required ng-trim="true" ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    
    <div class="form-group1">
      <div class="col-md-4 align-right">
      <label class="control-label">Ngân hàng dự định PD</label>
      </div>
      <div class="col-md-8">
         <ui-select ng-model="pd.bank" theme="bootstrap" style="width:300px;" class="fleft">
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
    
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Số ngày chờ PD</label>
      </div>
      <div class="col-md-8">
        <input ng-model="pd.num_days_pending" type="text"  name="num_days_pending" class="form-control width300" 
         required ng-trim="true" ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Số giờ chờ chuyển tiền sau khi được xác nhận</label>
      </div>
      <div class="col-md-8">
        <input ng-model="pd.num_hours_transfer" type="text"  name="num_hours_transfer" class="form-control width300" 
         required ng-trim="true" ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-4 align-right">
      <label class="control-label">Trạng thái</label>
      </div>
      <div class="col-md-8">
        <select class="form-control width300" id="status" ng-model="pd.status"
         ng-options="option.name for option in optionStatus track by option.id">
        </select>
        <em>Pending: Đang chờ PD; Pending Payment: PD; Approved: Hoàn thành.</em>
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
        {{ message }}
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
      <i class="glyphicon glyphicon-save"></i> <?php echo $_smarty_tpl->tpl_vars['app']->value->lang('common-btn-save');?>
 <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
      <a ng-disabled="processing" href="/pd#!/list" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> Trở về</a>
    </div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-3"></div>
  <div class="clearfix"></div>
  </div>
</div><?php }} ?>
