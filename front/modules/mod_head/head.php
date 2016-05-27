<?php 
  // lay thong tin group 
  $group = JBase::getSession()->get('group');
  
  if (empty($group)) {
    $system_code = $this->system_code();
    $group_id = $this->user->data()->group_id;
  
    $data = array(
      'id' => $group_id,
      'system_code' => $system_code
    );
    require_once PATH_COMPONENT . '/com_group/models/group.php';
    
    $group_model =  new GroupModel($this);
    
    $group = $group_model->get($data)->body;
    JBase::getSession()->set('group', $group);
  }
?>

<script type="text/javascript" src="<?= $this->appConf->theme_default ?>/js/controllers/head.js"></script>
<header id="header" ng-controller="HeadCtrl">
  
<div class="navbar-inner">
  <div class="container top-container">
    <div class="navbar-header col-md-2">
      <a class="navbar-brand logo" href="/"></a>
    </div>
    <div class="col-md-10">
          <ul class="menu-user">
            <li><a href="javascript:void(0)"><span>
              <?= $this->user->data()->email ?>
            </span> <i class="fa fa-caret-down"></i></a>
            <ul class="subuser">
                <li><a href="/<?=$this->lang('common-url-account_info')?>"><i class="fa fa-unlock-alt"></i> Tài khoản</a></li>
                <li><a href="/<?=$this->lang('common-url-change_password') ?>"><i class="fa fa-info-circle"></i> <?=$this->lang('common-menu-change_password') ?></a></li>
                <li><a href="/<?=$this->lang('common-url-logout') ?>"><i class="fa fa-external-link"></i> Đăng xuất</a></li>
            </ul>
            </li>
          </ul>
     </div>
  </div>
</div>
 <div class="top-nav"> 
    <section class="container">
      <ul class="menu">
        <li>
          <a href="<?= $this->lang('common-url-dashboard') ?>">
            <i class="fa fa-eye"></i> <?= $this->lang('common-menu-dashboard') ?>
          </a>
          <ul class="sub sub2">
            <li><a href="/dashboard#!/planpd">Danh sách PD dự kiến</a></li>
            <li><a href="/dashboard#!/pd">Danh sách PD cho đi</a></li>
            <li><a href="/dashboard#!/pd/approved">Danh sách PD hoàn thành</a></li>
            <hr/>
            <li><a href="/dashboard#!/planget">Danh sách GET dự kiến</a></li>
            <li><a href="/dashboard#!/get">Danh sách GET</a></li>
            <li><a href="/dashboard#!/gd">Danh sách GD</a></li>
            <li><a href="/dashboard#!/approve">Danh sách Xác nhận GD</a></li>
          </ul>
        </li>
        <li><a href="pd#!/add">PD</a></li>
        <li><a href="gd#!/add">GET</a></li>
        <li><a href="sponsor#!/list">
          <i class="fa fa-user"></i> Thành viên</a>
          <ul class="sub">
            <li><a href="/sponsor#!/add">Thêm thành viên</a></li>
            <li><a href="/sponsor#!/list">Danh sách thành viên</a></li>
            <li><a href="/sponsor#!/list_invest">Danh sách Mã đầu tư</a></li>
            <li><a href="/sponsor#!/list_tree">Danh sách tree</a></li>
          </ul>
        </li>
        <li><a href="/report#!/profit">
          <i class="fa fa-bar-chart"></i> Báo cáo</a>
          <ul class="sub">
            <li><a href="/report#!/profit">Báo cáo doanh thu</a></li>
            <li><a href="/report#!/bankaccount">Báo cáo theo tài khoản</a></li>
          </ul>
        </li>
        </li>
        <?php
        if ($group->id == 1 || $group->name == 'Manager') {
        ?> 
        <li><a href="/system"><i class="fa fa-cog"></i> Hệ thống</a>
          <ul class="sub">
            <li><a href="/system#!/setting">Cài đặt tham số</a></li>
            <li><a href="/system#!/user/list">Thành viên quản trị</a></li>
            <li><a href="/system#!/group/list">Nhóm quản trị</a></li>
          </ul>
        </li>
        <?php } ?>
        <li><a href="/other"><i class="fa fa-connectdevelop"></i> Khác</a>
          <ul class="sub">
            <li><a href="/other#!/candidate/list">Ứng viên tiềm năng</a></li>
            <li><a href="/other#!/plan/list">Lịch Công Tác</a></li>
          </ul>
        </li>
      </ul>
    </section>

 <div class="nav-bar">
   <button class="btn btn-sm btn-primary" ng-click="toggle_menu($event)"><i class="fa fa-bars" aria-hidden="true"></i></button>
 </div>
 <menu visible="showmenu" alignment="left">
    <ul>
      <li>
        <a href="<?= $this->lang('common-url-dashboard') ?>">
          <i class="fa fa-eye"></i> <?= $this->lang('common-menu-dashboard') ?>
        </a>
        <ul>
          <li><a href="/dashboard#!/planpd">Danh sách PD dự kiến</a></li>
            <li><a href="/dashboard#!/pd">Danh sách PD cho đi</a></li>
            <li><a href="/dashboard#!/pd/approved">Danh sách PD hoàn thành</a></li>
            <li><a href="/dashboard#!/planget">Danh sách GET dự kiến</a></li>
            <li><a href="/dashboard#!/get">Danh sách GET</a></li>
            <li><a href="/dashboard#!/gd">Danh sách GD</a></li>
            <li><a href="/dashboard#!/approve">Danh sách Xác nhận GD</a></li>
        </ul>
      </li>
      <li>
        <a href="pd#!/add">PD</a>
        <ul>
            <li><a href="/dashboard#!/planpd">Danh sách PD</a></li>
        </ul>
      </li>
      <li>
        <a href="gd#!/add">GET</a>
        <ul>
            <li><a href="/dashboard#!/planpd">Danh sách GET</a></li>
        </ul>
      </li>
      <li><a href="sponsor#!/list">
          <i class="fa fa-user"></i> Thành viên</a>
          <ul>
            <li><a href="/sponsor#!/add">Thêm thành viên</a></li>
            <li><a href="/sponsor#!/list">Danh sách thành viên</a></li>
            <li><a href="/sponsor#!/list_invest">Danh sách Mã đầu tư</a></li>
            <li><a href="/sponsor#!/list_tree">Danh sách tree</a></li>
          </ul>
        </li>
       <li><a href="/report#!/profit">
          <i class="fa fa-bar-chart"></i> Báo cáo</a>
          <ul>
            <li><a href="/report#!/profit">Báo cáo doanh thu</a></li>
            <li><a href="/report#!/bankaccount">Báo cáo theo tài khoản</a></li>
          </ul>
        </li>
        <?php
        if ($group->id == 1 || $group->name == 'Manager') {
        ?> 
        <li><a href="/system"><i class="fa fa-cog"></i> Hệ thống</a>
          <ul>
            <li><a href="/system#!/setting">Cài đặt tham số</a></li>
            <li><a href="/system#!/user/list">Thành viên quản trị</a></li>
            <li><a href="/system#!/group/list">Nhóm quản trị</a></li>
          </ul>
        </li>
        <?php } ?>
        <li><a href="/other"><i class="fa fa-connectdevelop"></i> Khác</a>
          <ul>
            <li><a href="/other#!/candidate/list">Ứng viên tiềm năng</a></li>
            <li><a href="/other#!/plan/list">Lập kế hoạch</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-user"></i> <?= $this->lang('dashboard-title-account') ?></a>
          <ul>
          <li><a href="/<?= $this->lang('common-url-account_info') ?>"><i class="fa fa-info-circle"></i> <?= $this->lang('common-menu-account_info') ?></a></li>
          <li><a href="/<?= $this->lang('common-url-change_password') ?>"><i class="fa fa-key"></i><?= $this->lang('common-menu-change_password') ?></a></li>
          <li><a href="/<?= $this->lang('common-url-logout') ?>"><i class="fa fa fa-sign-out"></i><?= $this->lang('common-menu-logout') ?></a></li>
          </ul>
        </li>
    </ul>
</menu>
</header>