<div class="box">
  <div class="box-title">
      <i class="fa fa-cog"></i> {$app->lang('system-label-title')}</div>
  <div class="box-body">
  <ul>
    <li><i class="fa fa-forumbee"></i> <a href="{$app->lang('system-url-setting')}">{$app->lang('system-menu-setting')}</a></li>
    <hr />
    <li><i class="fa fa-user-plus"></i> <a href="{$app->lang('system-url-user_add')}">{$app->lang('system-menu-user_add')}</a></li>
    <li><i class="fa fa-users"></i> <a href="{$app->lang('system-url-user_list')}">{$app->lang('system-menu-user_list')}</a></li>
    {if $app->user->data()->group_id == 1}
    <li><i class="fa fa-users"></i> <a href="{$app->lang('system-url-user_downline_list')}">{$app->lang('system-menu-user_downline_list')}</a></li>
    {/if}
    <hr />
    <li><i class="fa fa-user-plus"></i> <a href="{$app->lang('system-url-group_add')}">{$app->lang('system-menu-group_add')}</a></li>
    <li><i class="fa fa-group"></i> <a href="{$app->lang('system-url-group_list')}">{$app->lang('system-menu-group_list')}</a></li>
  </ul>
  </div>
</div>