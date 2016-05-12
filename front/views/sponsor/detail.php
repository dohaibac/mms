{literal}
<div class="modal-header">
  <h3 class="modal-title">Thông tin sponsor</h3>
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
        <label class="control-label">Email</label>
      </div>
      <div class="col-md-9">
        {{ sponsor.item.email }}
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3 align-right">
        <label class="control-label">Mobile</label>
      </div>
      <div class="col-md-9">
        {{ sponsor.item.mobile }}
      </div>
      <div class="clearfix"></div>
    </div>
   </div>
</div>
<div class="modal-footer">
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}