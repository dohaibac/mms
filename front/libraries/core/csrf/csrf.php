<?php
defined('LIBS_PATH') or die;
class JCsrf
{
    public function check($V4w2zdxup4vt, $Vtrs2uu4ang1 = null)
    {
        if (!isset($_SESSION[csrf_token])) {
            throw new Exception('Missing ' . csrf_token);
        }
        if (!isset($V4w2zdxup4vt[csrf_token])) {
            throw new Exception('Missing ' . csrf_token . ' form token');
        }
        $Vpuevitbrzdm = $_SESSION[csrf_token];
        if ($Vpuevitbrzdm != $V4w2zdxup4vt[csrf_token]) {
            throw new Exception('Invalid ' . csrf_token . ' form token');
        }
        
        $appConf = JAppConf::getInstance();
        
        $remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'api';
        
        $Vjs1xzgkvbvq = base64_encode(md5(sha1($remote_addr . $user_agent . $appConf->app_secret)));
        if ($Vjs1xzgkvbvq != $V4w2zdxup4vt[csrf_token]) {
            $Vwqezuuysowz = JBase::getUser();
            $V3v2iabqvkjw = $Vwqezuuysowz->logout();
            session_unset();
            $uri = JUri::getInstance();
            header('Location: ' . $uri->root());
            exit;
        }
        return true;
    }
    public function generate()
    {
        if (isset($_SESSION[csrf_token])) {
            return $_SESSION[csrf_token];
        }
        
        $appConf = JAppConf::getInstance();
        
        $remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'api';
        
        $Vjs1xzgkvbvq         = base64_encode(md5(sha1($remote_addr . $user_agent . $appConf->app_secret)));
        $_SESSION[csrf_token] = $Vjs1xzgkvbvq;
        return $Vjs1xzgkvbvq;
    }
    public function generate_form_names($Vv3kdsd4kym1, $Vhkmfyyj2nec, $Vtzif5s02jxb = true)
    {
        $Vy5cahud1cfd = array();
        $appConf = JAppConf::getInstance();
        if (!isset($_SESSION['csrf_form'])) {
            $_SESSION['csrf_form'] = array();
        }
        if (!isset($_SESSION['csrf_form'][$Vv3kdsd4kym1])) {
            $_SESSION['csrf_form'][$Vv3kdsd4kym1] = array();
        } else {
            if ($Vtzif5s02jxb == true) {
                unset($_SESSION['csrf_form'][$Vv3kdsd4kym1]);
            }
        }
        foreach ($Vhkmfyyj2nec as $Vukm5peljnxj) {
            if ($appConf->enable_random_form_name == 0) {
                $_SESSION['csrf_form'][$Vv3kdsd4kym1][$Vukm5peljnxj] = $Vukm5peljnxj;
                $Vy5cahud1cfd[$Vukm5peljnxj]                         = $Vukm5peljnxj;
                continue;
            }
            $V1orfk3jhxlc                                        = isset($_SESSION['csrf_form'][$Vv3kdsd4kym1][$Vukm5peljnxj]) ? $_SESSION['csrf_form'][$Vv3kdsd4kym1][$Vukm5peljnxj] : $this->randomString(10);
            $_SESSION['csrf_form'][$Vv3kdsd4kym1][$Vukm5peljnxj] = $V1orfk3jhxlc;
            $Vy5cahud1cfd[$Vukm5peljnxj]                         = $V1orfk3jhxlc;
        }
        return $Vy5cahud1cfd;
    }
    public function remove_session_form_names($Vv3kdsd4kym1)
    {
        unset($_SESSION['csrf_form'][$Vv3kdsd4kym1]);
    }
    public function get_form_names($Vv3kdsd4kym1)
    {
        $Vci0awdvjg0j = isset($_SESSION['csrf_form'][$Vv3kdsd4kym1]) ? $_SESSION['csrf_form'][$Vv3kdsd4kym1] : array();
        $this->remove_session_form_names($Vv3kdsd4kym1);
        return $Vci0awdvjg0j;
    }
    protected function randomString($Vjfgyz1oj1q2)
    {
        $V1orfk3jhxlceed   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789';
        $Vabgtcjr1psq      = strlen($V1orfk3jhxlceed) - 1;
        $V1orfk3jhxlctring = '';
        for ($Vt50hlhjpr5g = 0; $Vt50hlhjpr5g < $Vjfgyz1oj1q2; ++$Vt50hlhjpr5g) {
            $V1orfk3jhxlctring .= $V1orfk3jhxlceed{intval(mt_rand(0.0, $Vabgtcjr1psq))};
        }
        return $V1orfk3jhxlctring;
    }
}
?>