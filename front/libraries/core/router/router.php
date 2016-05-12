<?php
defined('LIBS_PATH') or die;
class JRouter
{
    protected $controler = array();
    protected $controllerPrefix = '';
    
    public $action = '';
    public $pageName = '';
    public $map = array();
    
    protected $vars = array();
    protected $app = null;
    
    public function __construct($app)
    {
        $this->app = $app;
        $this->_parse();
    }
    
    public function getController($name = '')
    {
        if (!empty($name)) {
            return $this->fetchController($name);
        }
        return $this->controler;
    }
    
    public function getVars()
    {
        return $this->vars;
    }
    
    protected function _parse()
    {
        $uri  = JUri::getInstance();
        $path = $uri->getPath();
        $url  = preg_replace('/\?.*/', '', $path);
        $url  = str_replace('.php', '', $url);
        $url  = str_replace('.html', '', $url);
        $url  = trim($url, '/');
        $name = $url;
        
        if (empty($name)) {
            $name = 'home';
        }
        
        $this->map = self::getRouterMap($name);
    }
    
    public static function getRouterMap($name)
    {
        global $routerMap;
        foreach ($routerMap as $key => $value) {
            if ($key == $name) {
              return $value;
            }
        }
    }
}