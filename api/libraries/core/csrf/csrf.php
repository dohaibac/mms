<?php
defined('LIBS_PATH') or die;
class JCsrf
{
    public function check($Vvswr5oi2rm1, $Vjupg115ktwn = null)
    {
        if (!isset($_SESSION[csrf_token])) {
            throw new Exception('Missing ' . csrf_token);
        }
        if (!isset($Vvswr5oi2rm1[csrf_token])) {
            throw new Exception('Missing ' . csrf_token . ' form token');
        }
        $Vozuyvsewgu4 = $_SESSION[csrf_token];
        if ($Vozuyvsewgu4 != $Vvswr5oi2rm1[csrf_token]) {
            throw new Exception('Invalid ' . csrf_token . ' form token');
        }
        
        $appConf = JAppConf::getInstance();
        
        $Vppglja12l14 = base64_encode(md5(sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $appConf->app_secret)));
        if ($Vppglja12l14 != $Vvswr5oi2rm1[csrf_token]) {
            throw new Exception('Form origin does not match token origin.');
        }
        return true;
    }
    public function generate()
    {
        if (isset($_SESSION[csrf_token])) {
            return $_SESSION[csrf_token];
        }
        
        $appConf = JAppConf::getInstance();
        
        $Vppglja12l14         = base64_encode(md5(sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $appConf->app_secret)));
        $_SESSION[csrf_token] = $Vppglja12l14;
        return $Vppglja12l14;
    }
    public function generate_form_names($Vuy4rgscbgxu, $Vqx0ceiyrpsk, $Vmkaric00d0h = true)
    {
        $Vr2mv2exg0la = array();
          
        $appConf = JAppConf::getInstance();
        
        if (!isset($_SESSION['csrf_form'])) {
            $_SESSION['csrf_form'] = array();
        }
        if (!isset($_SESSION['csrf_form'][$Vuy4rgscbgxu])) {
            $_SESSION['csrf_form'][$Vuy4rgscbgxu] = array();
        } else {
            if ($Vmkaric00d0h == true) {
                unset($_SESSION['csrf_form'][$Vuy4rgscbgxu]);
            }
        }
        foreach ($Vqx0ceiyrpsk as $Vlxqddwqofgw) {
            if ($appConf->enable_random_form_name == 0) {
                $_SESSION['csrf_form'][$Vuy4rgscbgxu][$Vlxqddwqofgw] = $Vlxqddwqofgw;
                $Vr2mv2exg0la[$Vlxqddwqofgw]                         = $Vlxqddwqofgw;
                continue;
            }
            $Vtix22epnhyb                                        = isset($_SESSION['csrf_form'][$Vuy4rgscbgxu][$Vlxqddwqofgw]) ? $_SESSION['csrf_form'][$Vuy4rgscbgxu][$Vlxqddwqofgw] : $this->randomString(10);
            $_SESSION['csrf_form'][$Vuy4rgscbgxu][$Vlxqddwqofgw] = $Vtix22epnhyb;
            $Vr2mv2exg0la[$Vlxqddwqofgw]                         = $Vtix22epnhyb;
        }
        return $Vr2mv2exg0la;
    }
    public function remove_session_form_names($Vuy4rgscbgxu)
    {
        unset($_SESSION['csrf_form'][$Vuy4rgscbgxu]);
    }
    public function get_form_names($Vuy4rgscbgxu)
    {
        $Vtts40f0ixj0 = isset($_SESSION['csrf_form'][$Vuy4rgscbgxu]) ? $_SESSION['csrf_form'][$Vuy4rgscbgxu] : array();
        $this->remove_session_form_names($Vuy4rgscbgxu);
        return $Vtts40f0ixj0;
    }
    protected function randomString($Vroid5qrdeps)
    {
        $Vtix22epnhybeed   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789';
        $V0a0cbxlt45l      = strlen($Vtix22epnhybeed) - 1;
        $Vtix22epnhybtring = '';
        for ($Vfxks3twhnji = 0; $Vfxks3twhnji < $Vroid5qrdeps; ++$Vfxks3twhnji) {
            $Vtix22epnhybtring .= $Vtix22epnhybeed{intval(mt_rand(0.0, $V0a0cbxlt45l))};
        }
        return $Vtix22epnhybtring;
    }
}
?>