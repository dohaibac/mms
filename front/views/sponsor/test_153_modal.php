<div ng-controller="SponsorTest153ModalCtrl">
{literal}
<div class="modal-header">
  <h3 class="modal-title">Kiểm tra sơ đồ 1/5/3</h3>
</div>
<div class="modal-body dashboard-main"> 
   <div class="form-group">
    <div class="col-md-2 align-right">
      <label class="control-label">Mã</label>
    </div>
    <div class="col-md-10">
      <p>Dang cap nhat chuc nang!</p>
      {{ sponsor.item.username}}
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
    class="btn btn-sm btn-warning" type="button"> Kiểm tra <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></a>
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}
</div>