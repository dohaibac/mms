{literal}
<div class="dashboard-main" ng-controller="PlanpdListCtrl">
  <div class="col-lg-12 header-title">
    <h4>Danh sách PD dự kiến <b>{literal} {{ from_date }} {/literal}</b></h4>
    <span>Đây là danh sách các mã dự kiến sẽ đặt lệnh PD do hệ thống tự động tính toán!<br/><br/></span>
  </div>
  <div class="dashboard-main-body">
   <div class="table-responsive">
    <p>Search: <input class="form-control" type="text" ng-model="filter.$" /></p>
    <a class="btn btn-link" ng-click="view_all()">Xem tất cả</a>
    <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
    <div ng-hide="loading">
    <table ng-table="tableParams" class="table table-bordered table-striped">
        <tr ng-repeat="pd in $data">
            <td class="th-ord" data-title="'#'">
              {{$index + 1}}
            </td>
            <td data-title="'Mã'" sortable="'sponsor'">
              <a class="btn-link" ng-click="view_sponsor(pd)"> {{ pd.sponsor }} </a>
            </td>
            <td>
            <div ng-if="pd.status == 0">
             <button class="btn btn-sm btn-warning" ng-click="confirm(pd)">Xác nhận</button>
             <a class="btn btn-link" target="_blank" href="https://vphp.biz/login">Link M5</a>
            </div>
            <div ng-if="pd.status == 1">
             <a class="btn confirmed"><i class="fa fa-check"></i></a>
            </div> 
          </td>
        </tr>
        <tr ng-if="$data.length == 0">
          <td colspan="3">Không có PD dự kiến nào!</td>
        </tr>
    </table>
    </div>
  </div> <!-- end list-->
  </div>
</div>
{/literal}