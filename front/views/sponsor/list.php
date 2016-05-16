<div class="dashboard-main">
<br/>
{literal}
<script type="text/ng-template" id="nodes_renderer.html">
  <div ui-tree-handle>
    {{ item.level }} <a ng-click="show_detail(item)">{{ item.name }}</a>
  </div>
  <ol ui-tree-nodes="" ng-model="node.items">
    <li ng-repeat="item in item.items" ui-tree-node ng-include="'nodes_renderer.html'">
    </li>
  </ol>
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
<div ui-tree>
  <ol ui-tree-nodes="" id="tree-root">
    <li>
    <div><a ng-click="show_detail(sponsor_owner_object)"><b>{{ sponsor_owner }}</b></a></div>
    <ol ui-tree-nodes=""  ng-model="sponsors">
      <li ng-repeat="item in sponsors.items" ui-tree-node ng-include="'nodes_renderer.html'"></li>
    </ol>
    </li>
  </ol>
</div>
</div>
{/literal}
</div>