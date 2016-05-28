<div class="dashboard-main">
<br/>
{literal}
<script type="text/ng-template" id="nodes_renderer.html">
  <div context-menu="menuOptions">
    <span class="mnu-arrow" ng-click="toggle(this)" ng-if="item.items.length > 0">
      <i ng-if="collapsed" class="fa fa-plus"></i>
      <i ng-if="!collapsed" class="fa fa-minus"></i>
    </span>
    <a ng-click="toggle(this)" ng-if="item.level - level_root ==0"><b>{{ item.name }}</b></a>
    <a ng-click="toggle(this)" ng-if="item.level - level_root >0"><b>{{ item.level - level_root }} . {{ item.name }}</b></a>
  </div>
  <ol ui-tree-nodes="" ng-model="item.items" ng-class="{hidden: collapsed}">
    <li collapsed="true" ng-repeat="item in item.items" ui-tree-node ng-include="'nodes_renderer.html'">
    </li>
  </ol>
</script>

<div class="container" ng-init="init()">
<div class="form-group">
  <input class="form-control fleft" ng-enter="search()" id="keyword" name="keyword" style="width:300px" placeholder="Search sponsor"/>&nbsp; 
  <button class="btn btn-sm btn-primary bold" ng-click="search()">Search</button>
  <div class="clearfix"></div>
</div>
<p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin"></i></p>
<div class="alert alert-warning" ng-if="message">
<div ng-class="message_type == 1 ? 'error-message' : 'success'">
  {{ message }}
</div>
</div>
<div ui-tree>
  <ol ui-tree-nodes="" id="tree-root" ng-model="sponsors">
    <li collapsed="false" ng-repeat="item in sponsors.items" ui-tree-node ng-include="'nodes_renderer.html'"></li>
  </ol>
</div>
</div>
{/literal}
</div>