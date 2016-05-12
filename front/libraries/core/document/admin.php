<?php
defined('LIBS_PATH') or die;
class JDocumentAdmin extends JDocument
{
    public function render($Vng3wph212pq, $Vsunthr0dov3 = '')
    {
        
        $Voxdult2a2fb = '';
        if (empty($Vsunthr0dov3)) {
            $Vuycbdb1513s    = $Vng3wph212pq['file'];
            $this->_template = $this->_loadTemplate($Vuycbdb1513s);
            $Voxdult2a2fb    = $this->_parseTemplate()->_renderTemplate();
        } else {
            $this->_template = $Vsunthr0dov3;
            $Voxdult2a2fb    = $this->_parseTemplate()->_renderTemplate();
        }
        
        $appConf = JAppConf::getInstance();
        
        if ($appConf->enable_zip_page == 1) {
            echo $this->outputfilter_trimwhitespace($Voxdult2a2fb);
        } else {
            echo $Voxdult2a2fb;
        }
    }
    public function setBuffer($Voxdult2a2fb, $options = array())
    {
        if (func_num_args() > 1 && !is_array($options)) {
            $Vlifv0bgpkco     = func_get_args();
            $options          = array();
            $options['type']  = $Vlifv0bgpkco[1];
            $options['name']  = (isset($Vlifv0bgpkco[2])) ? $Vlifv0bgpkco[2] : null;
            $options['title'] = (isset($Vlifv0bgpkco[3])) ? $Vlifv0bgpkco[3] : null;
        }
        parent::$_buffer[$options['type']][$options['name']][$options['title']] = $Voxdult2a2fb;
        return $this;
    }
    public function getBuffer($Vaauujkx5n3o = null, $name = null, $Vhisqbhotnm1 = array())
    {
        if ($Vaauujkx5n3o === null) {
            return parent::$_buffer;
        }
        $title = (isset($Vhisqbhotnm1['title'])) ? $Vhisqbhotnm1['title'] : null;
        if (isset(parent::$_buffer[$Vaauujkx5n3o][$name][$title])) {
            return parent::$_buffer[$Vaauujkx5n3o][$name][$title];
        }
        $V1poxhtzsgho = $this->loadRenderer($Vaauujkx5n3o);
        $this->setBuffer($V1poxhtzsgho->render($name, $Vhisqbhotnm1, null), $Vaauujkx5n3o, $name, $title);
        return parent::$_buffer[$Vaauujkx5n3o][$name][$title];
    }
}