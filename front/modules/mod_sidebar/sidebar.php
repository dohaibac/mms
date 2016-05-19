<div id="sidebar">
  
  <?php $this->loadView('dashboard/menu'); ?>
  
  <div class="box">
    <div class="box-title">
      <i class="fa fa-user"></i> <?= $this->lang('dashboard-title-account') ?>
    </div>
    <div class="box-body">
      <ul>
      <li><i class="fa fa-info-circle"></i> <a href="/<?= $this->lang('common-url-account_info') ?>"><?= $this->lang('common-menu-account_info') ?></a></li>
      <li><i class="fa fa-info-circle"></i> <a href="/<?= $this->lang('common-url-change_password') ?>"><?= $this->lang('common-menu-change_password') ?></a></li>
      <li><i class="fa fa fa-sign-out"></i> <a href="/<?= $this->lang('common-url-logout') ?>"><?= $this->lang('common-menu-logout') ?></a></li>
      </ul>
    </div>
  </div>
</div>