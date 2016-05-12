<?php
  $currentPage = $this->currentPage;
  
  $title = $this->lang($currentPage['title']);
  $keywords = $this->lang($currentPage['keywords']);
  $description = $this->lang($currentPage['description']);
?>

<link href="<?=$this->appConf->current_url ?>" rel="canonical">
<title><?=$title?></title>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" />
<meta property="og:title" content="<?=$title?>" />
<meta property="og:url" content="<?=$this->appConf->current_url ?>"/>
<meta property="og:description" content="<?=$description ?>"/>