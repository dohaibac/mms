<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="vi"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="vi"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="vi"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="vi"> <!--<![endif]-->
<head>
  <link href="<?= $appConf->current_url ?>/" rel="canonical">
  <meta charset="UTF-8" content="text/html" http-equiv="content-type">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="<?= $appConf->copyright  ?>">
  <jdoc:include type="module" name="seo" />
  
  <link rel='shortcut icon' type='image/x-icon' href='<?= $appConf->cdn_base_url ?>favicon.ico' />
  
  <link href="<?= $appConf->cdn_base_url ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $appConf->cdn_base_url ?>css/bootstrap-responsive.min.css" rel="stylesheet">
  <link href="<?= $appConf->cdn_base_url ?>css/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?= $appConf->cdn_base_url ?>css/responsive-tables.css" rel="stylesheet">
  
  <link href="<?= $appConf->theme ?>/css/login.css?v=<?= $appConf->theme_css_version ?>" rel="stylesheet">
  
  <script src="<?= $appConf->cdn_base_url ?>js/jquery.2.1.1.min.js" type="text/javascript"></script>
  <script src="<?= $appConf->cdn_base_url ?>js/angular.1.3.10.min.js" type="text/javascript"></script>
  <script src="<?= $appConf->cdn_base_url ?>js/angular-cookies.js" type="text/javascript"></script>
  <script src="<?= $appConf->cdn_base_url ?>js/ui-bootstrap-tpls-0.12.1.min.js" type="text/javascript"></script>
  <script src="<?= $appConf->cdn_base_url ?>js/dirPagination.js" type="text/javascript"></script>
  <script type="text/javascript" src="<?= $appConf->cdn_base_url ?>js/angular-route.min.js"></script>
  
  <script src="<?= $appConf->theme_default ?>/js/provider/appConf.js" type="text/javascript"></script>
  <script src="<?= $appConf->theme_default ?>/js/web-app.js" type="text/javascript"></script>
  <script type="text/javascript">
    var appConf = {
      'domain': '<?= $appConf->domain  ?>',
      'full_domain' : '<?= $appConf->full_domain  ?>',
      'ctrl': '<?= $appConf->ctrl  ?>',
      'task': '<?= $appConf->task  ?>'
    };
</script>
</head>
<body>
<section class="wrapper" ng-app="jApp">
  <jdoc:include type="modules" name="position-1" />
  <jdoc:include type="modules" name="position-2" />
  <jdoc:include type="modules" name="position-3" />
  
</section>
</body>
</html>