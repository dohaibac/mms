<div class="dashboard-main">
<br/>
{literal}
<script type="text/ng-template" id="nodes_renderer.html">
  <div context-menu="menuOptions">
    <span class="mnu-arrow" ng-show="item.is_loading">
      <i class="fa fa-spinner fa-spin"></i>
    </span>
    <span class="mnu-arrow" ng-click="toggle(this); get_child_nodes(this)" ng-if="item.has_fork == 1 && !item.is_loading">
      <i ng-if="collapsed" class="fa fa-plus"></i>
      <i ng-if="!collapsed" class="fa fa-minus"></i>
    </span>
    <a ng-click="toggle(this); get_child_nodes(this)" ng-if="item.level - level_root ==0"><b>{{ item.name }}</b></a>
    <a ng-click="toggle(this); get_child_nodes(this)" ng-if="item.level - level_root >0"><b>{{ item.level - level_root }} . {{ item.name }}</b></a>
  </div>
  <ol ui-tree-nodes="" ng-model="item.items" ng-class="{hidden: collapsed}" data-nodrop>
    <li collapsed="true" ng-repeat="item in item.items" ui-tree-node ng-include="'nodes_renderer.html'">
    </li>
  </ol>
</script>

<div class="container" ng-init="init()">
<div class="form-group">
  <input class="form-control fleft" ng-enter="search()" id="keyword" name="keyword" placeholder="Search sponsor"/>&nbsp; 
  <button class="btn btn-sm btn-primary bold" ng-click="search()">Search</button>
  <div class="clearfix"></div>
  <span class="mob-context-note"><em>Để hiển thị context menu, bạn vui lòng nhấn giữ một lúc bên cạnh mã thành viên tương ứng.</em></span>
</div>
<p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin"></i></p>
<div class="alert alert-warning" ng-if="message">
<div ng-class="message_type == 1 ? 'error-message' : 'success'">
  {{ message }}
</div>
</div>
<div class="sponsor-path" ng-show="path_breakumb && path_breakumb.length > 0">
  <div id="path_breakumb"></div>
</div>
<div ui-tree id="tree-root">
  <ol ui-tree-nodes="" ng-model="sponsors" data-nodrop-enabled="false">
    <li collapsed="false" ng-repeat="item in sponsors.items" ui-tree-node ng-include="'nodes_renderer.html'" class="animate-repeat"></li>
  </ol>
</div>
</div>
{/literal}
</div>