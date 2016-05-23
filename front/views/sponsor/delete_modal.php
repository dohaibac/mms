<div ng-controller="SponsorDeleteModalCtrl">
{literal}
<div class="modal-header">
  <h3 class="modal-title">Bạn chắc chắn muốn Xóa thành viên</h3>
</div>
<div class="modal-body dashboard-main"> 
   <div class="form-group">
    <div class="col-md-2 align-right">
      <label class="control-label">Mã</label>
    </div>
    <div class="col-md-10">
      {{ sponsor.item.username}}
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="form-group" ng-if="sponsor.items.length > 0">
    <div class="col-md-2 align-right">
      <label class="control-label">&nbsp;</label>
    </div>
    <div class="col-md-10">
      <div class="bold red">Bạn không thể xóa được mã này vì đã tồn tại downline. Bạn phải xóa downline trước.</div>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="form-group" ng-if="message">
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
 </div>
<div class="modal-footer">
  <a ng-disabled="disabled()" ng-click="submit()" 
    class="btn btn-sm btn-warning" type="button"> Xóa <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></a>
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}
</div>