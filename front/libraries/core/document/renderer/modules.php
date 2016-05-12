<?php
defined('BASEPATH') or die;
class JDocumentRendererModules
{
  public $appName = '';
  public function __construct($doc = array())
  {
      $this->appName = $doc->appName;
  }
  public function render($modules, $attribs = array(), $content = null)
  {
      $app = JBase::getApplication($this->appName);
      return $app->renderModules($modules, $attribs, $content);
  }
}