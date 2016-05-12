<div class="modal-header">
  <h3 class="modal-title">Danh sách tài khoản ngân hàng</h3>
</div>
<div class="modal-body dashboard-main" ng-controller="BankListCtrl"> 
   <div class="table-responsive" ng-init="init()">
   <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-name">Name</th>
        <th class="th-name">Branch Name</th>
        <th class="th-amount">Account Hold Name</th>
        <th class="th-amount">Account Number</th>
        <th class="th-mobile">Linked Mobile</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="bank in banks">
        <td> <input type="checkbox" ng-click="toggleSelection(bank)" /> </td>
        <td> {{ bank.name }} </td>
        <td> {{ bank.branch_name }} </td>
        <td> {{ bank.account_hold_name }} </td>
        <td> {{ bank.account_number }} </td>
        <td> {{ bank.linked_mobile_number }} </td>
        <td>
           <a type="button" href="javascript:void(0)" ng-click="edit(bank)"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Sửa"
            class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" ng-click="delete(bank)"
             data-toggle="tooltip" tooltip-placement="top" tooltip="Xóa"
            type="button" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i></a>
        </td>
      </tr>
      <tr>
        <td colspan="6" ng-if="banks.length == 0">
          Chưa có ngân hàng nào!
        </td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> <!-- end list-->
  <div id="toolbar-list" class="toolbar">
    <a href="javascript:void(0)" title="Thêm" ng-click="add()" 
      class="btn btn-primary btn-sm">
      Thêm tài khoản
    </a>
  </div> <!-- end toolbar -->
</div>
<div class="modal-footer">
  <button class="btn btn-sm btn-primary" ng-click="ok()">OK</button>
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>