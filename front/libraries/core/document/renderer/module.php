<?php
defined('BASEPATH') or die;
class JDocumentRendererModule
{
    public $appName = '';
    public function __construct($doc = array())
    {
        $this->appName = $doc->appName;
    }
    public function render($module, $attribs = array(), $content = null)
    {
        $app = JBase::getApplication($this->appName);
        return $app->renderModule($module, $attribs, $content);
    }
}