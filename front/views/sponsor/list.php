<div class="dashboard-main">
<br/>
{literal}
<script type="text/ng-template" id="sponsor_list_render.html">
   <div ng-if="group_id > 7">
     <a>{{ item.label }}</a>
   </div>
   <div ng-if="group_id <= 7">
     <a ng-click="show_detail(item)">{{ item.label }}</a>
   </div>
   <div class="child" ng-show="item.items.length > 0">
     <div class="child1" ng-repeat="item in item.items" ng-include="'sponsor_list_render.html'"></div>
   </div>
</script>
<div class="container" ng-init="init()">
<div class="form-group">
  <input class="form-control fleft" ng-enter="search()" id="keyword" name="keyword" style="width:300px" placeholder="Search sponsor"/>&nbsp; 
  <button class="btn btn-sm btn-primary bold" ng-click="search()">Search</button>
  <div class="clearfix"></div>
</div>
<p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
<div class="alert alert-warning" ng-if="message">
<div ng-class="message_type == 1 ? 'error-message' : 'success'">
  {{ message }}
</div>
</div>
<div class="sponsor-list" ng-hide="loading || message_type == 1">
  <div class="parent">
     <div class="parent-root"><a>{{ sponsor_owner }}</a></div>
     <div class="child child-container">
     <div class="child1" ng-repeat="item in sponsors.items" ng-include="'sponsor_list_render.html'"></div>
     </div>
  </div>
<div class="clearfix"></div>
</div>
</div>
{/literal}
</div>