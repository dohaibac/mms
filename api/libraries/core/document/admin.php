<?php
defined('LIBS_PATH') or die;
class JDocumentAdmin extends JDocument
{
    public function render($V1jvs1kxm5kc, $Vc5yvczc5pcm = '')
    {
        
        $Vtgyiab2umyn = '';
        if (empty($Vc5yvczc5pcm)) {
            $V1kzxczmgaoa    = $V1jvs1kxm5kc['file'];
            $this->_template = $this->_loadTemplate($V1kzxczmgaoa);
            $Vtgyiab2umyn    = $this->_parseTemplate()->_renderTemplate();
        } else {
            $this->_template = $Vc5yvczc5pcm;
            $Vtgyiab2umyn    = $this->_parseTemplate()->_renderTemplate();
        }
        
        $appConf = JAppConf::getInstance();
        
        echo $Vtgyiab2umyn;
    }
    public function setBuffer($Vtgyiab2umyn, $options = array())
    {
        if (func_num_args() > 1 && !is_array($options)) {
            $Vmmrdcixcnbz     = func_get_args();
            $options          = array();
            $options['type']  = $Vmmrdcixcnbz[1];
            $options['name']  = (isset($Vmmrdcixcnbz[2])) ? $Vmmrdcixcnbz[2] : null;
            $options['title'] = (isset($Vmmrdcixcnbz[3])) ? $Vmmrdcixcnbz[3] : null;
        }
        parent::$_buffer[$options['type']][$options['name']][$options['title']] = $Vtgyiab2umyn;
        return $this;
    }
    public function getBuffer($V1advpdxzywd = null, $name = null, $Vva2nitzuqs4 = array())
    {
        if ($V1advpdxzywd === null) {
            return parent::$_buffer;
        }
        $title = (isset($Vva2nitzuqs4['title'])) ? $Vva2nitzuqs4['title'] : null;
        if (isset(parent::$_buffer[$V1advpdxzywd][$name][$title])) {
            return parent::$_buffer[$V1advpdxzywd][$name][$title];
        }
        $Vbjx2frwowkf = $this->loadRenderer($V1advpdxzywd);
        $this->setBuffer($Vbjx2frwowkf->render($name, $Vva2nitzuqs4, null), $V1advpdxzywd, $name, $title);
        return parent::$_buffer[$V1advpdxzywd][$name][$title];
    }
}