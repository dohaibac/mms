<section id="content" class="main-content">
  <div class="col-md-3 sidebar-container">
    <?php echo $this->renderModule('sidebar'); ?>
  </div>
  <div class="col-md-9 dashboard-main-container">
    <?php echo $this->loadView('dashboard/main'); ?>
  </div>
  <div class="clearfix"></div>
</section>