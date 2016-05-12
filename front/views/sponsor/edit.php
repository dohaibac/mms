<div class="container">
<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-edit"></i> Cập nhật Sponsor</h1>
  </div>
  <div>
  <div class="col-md-1"></div>
  <div class="col-md-10">
    <div class="form-group">
      <label class="col-md-2 control-label">Name</label>
      <div class="col-md-10">
      <input ng-model="sponsor.name" type="input" name="name" class="form-control" 
         required autofocus ng-maxlength="255">
       </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">User name</label>
      <div class="col-md-10">
      <input ng-model="sponsor.username" type="input" name="username" class="form-control" 
          required ng-minlength="3" ng-maxlength="255">
       </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Upline</label>
      <div class="col-md-10">
      <input ng-model="sponsor.upline" type="input" name="upline" class="txt-sm fleft upline" 
          ng-minlength="3" ng-maxlength="255">
          <a class="btn btn-sm btn-success" ng-click="view()">Check</a>
       <div class="clearfix"></div>
       {literal}
        <div ng-if="sponsor_check.message_type == 1">
          {{ sponsor_check.message }} 
        </div>
        <div ng-if="sponsor_check.message_type == 0">
         {{ sponsor_check.sponsor.name }} - {{ sponsor_check.sponsor.username }} - {{ sponsor_check.sponsor.mobile }} - {{ sponsor_check.sponsor.email }}
        </div>
       {/literal}
       </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Email</label>
      <div class="col-md-10">
      <input ng-model="sponsor.email" type="input" name="email" class="form-control" 
          required ng-minlength="3" ng-maxlength="255">
       </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Mobile</label>
      <div class="col-md-10">
      <input ng-model="sponsor.mobile" type="input" name="mobile" class="form-control" 
          required ng-minlength="3" ng-maxlength="255">
       </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Bank</label>
      <div class="col-md-10">
    <table class="table table-bordered table-striped" id="tbl_banks">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-ord">Name</th>
        <th class="th-name">Branch Name</th>
        <th class="th-des">Account Hold Name</th>
        <th class="th-des">Account Number</th>
        <th class="th-des">Linked Mobile</th>
        <th>Mac dinh</th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="bank in banks">
        <td> {{ $index + 1 }} </td>
        <td> {{ bank.name }} </td>
        <td> {{ bank.branch_name }} </td>
        <td> {{ bank.account_hold_name }} </td>
        <td> {{ bank.account_number }} </td>
        <td> {{ bank.linked_mobile_number }} </td>
        <td> 
          <input type="radio" class="rname" name="rname[]" value="{{ bank.id }}" ng-checked="$index == 0"  />
        </td>
       </tr>
      {/literal}
    </tbody>
  </table>
       <a class="btn btn-sm btn-success" title="Bank list" ng-click="show_bank_list()"> + </a>
       <div class="clearfix"></div>
       </div>
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
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label"></label>
      <div class="col-md-10">
      <button ng-disabled="disabled()" ng-click="submit()" 
      class="btn btn-sm btn-primary" type="submit">
      <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
    </div>
    </div>
  </div> <!-- end list-->
  <div class="col-md-1"></div>
  <div class="clearfix"></div>
  </div>
</div>
</div>