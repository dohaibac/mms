<?php
defined('LIBS_PATH') or die;
class JSession implements IteratorAggregate
{
    protected $_state = 'inactive';
    protected $_expire = 15;
    protected $_security = array('fix_browser');
    protected $_force_ssl = false;
    protected static $instance;
    public function __construct()
    {
        if (!isset($_SESSION)) {
            ini_set('session.use_trans_sid', '0');
            ini_set('session.use_only_cookies', '1');
            $this->_state = 'inactive';
        }
    }
    public function __get($name)
    {
        if ($name === 'storeName') {
            return $this->$name;
        }
        if ($name === 'state' || $name === 'expire') {
            $property = '_' . $name;
            return $this->$property;
        }
    }
    public static function getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new JSession();
        }
        return self::$instance;
    }
    public function getState()
    {
        return $this->_state;
    }
    public function getExpire()
    {
        return $this->_expire;
    }
    public function getToken($forceNew = false)
    {
        $token = $this->get('session.token');
        if ($token === null || $forceNew) {
            $token = $this->_createToken(12);
            $this->set('session.token', $token);
        }
        return $token;
    }
    public function hasToken($tCheck, $forceExpire = true)
    {
        $tStored = $this->get('session.token');
        if (($tStored !== $tCheck)) {
            if ($forceExpire) {
                $this->_state = 'expired';
            }
            return false;
        }
        return true;
    }
    public function getIterator()
    {
        return new ArrayIterator($_SESSION);
    }
    public function getName()
    {
        if ($this->_state === 'destroyed') {
            return null;
        }
        return session_name();
    }
    public function getId()
    {
        if ($this->_state === 'destroyed') {
            return null;
        }
        return session_id();
    }
    public function isActive()
    {
        return (bool) ($this->_state == 'active');
    }
    public function isNew()
    {
        $counter = $this->get('session.counter');
        return (bool) ($counter === 1);
    }
    public function get($name, $default = null, $namespace = 'default')
    {
        $namespace = '__' . $namespace;
        if ($this->_state !== 'active' && $this->_state !== 'expired') {
            $error = null;
            return $error;
        }
        if (isset($_SESSION[$namespace][$name])) {
            return $_SESSION[$namespace][$name];
        }
        return $default;
    }
    public function set($name, $value = null, $namespace = 'default')
    {
        $namespace = '__' . $namespace;
        if ($this->_state !== 'active') {
            return null;
        }
        $old = isset($_SESSION[$namespace][$name]) ? $_SESSION[$namespace][$name] : null;
        if (null === $value) {
            unset($_SESSION[$namespace][$name]);
        } else {
            $_SESSION[$namespace][$name] = $value;
        }
        return $old;
    }
    public function has($name, $namespace = 'default')
    {
        $namespace = '__' . $namespace;
        if ($this->_state !== 'active') {
            return null;
        }
        return isset($_SESSION[$namespace][$name]);
    }
    public function clear($name, $namespace = 'default')
    {
        $namespace = '__' . $namespace;
        if ($this->_state !== 'active') {
            return null;
        }
        $value = null;
        if (isset($_SESSION[$namespace][$name])) {
            $value = $_SESSION[$namespace][$name];
            unset($_SESSION[$namespace][$name]);
        }
        return $value;
    }
    public function start()
    {
        if ($this->_state === 'active') {
            return;
        }
        $this->_start();
        $this->_state = 'active';
        $this->_setCounter();
        $this->_setTimers();
        $this->_validate();
    }
    protected function _start()
    {
        if (!isset($_SESSION)) {
            register_shutdown_function('session_write_close');
            @session_start();
        }
        return true;
    }
    public function destroy()
    {
        if ($this->_state === 'destroyed') {
            return true;
        }
        if (isset($_COOKIE[session_name()])) {
          
            $appConf = JAppConf::getInstance();
          
            $cookie_domain = $appConf->cookie_domain;
            $cookie_path   = $appConf->cookie_path;
            
            setcookie(session_name(), '', time() - 42000, $cookie_path, $cookie_domain);
        }
        session_unset();
        session_destroy();
        $this->_state = 'destroyed';
        return true;
    }
    public function restart()
    {
        $this->destroy();
        if ($this->_state !== 'destroyed') {
            return false;
        }
        $this->_store->register();
        $this->_state = 'restart';
        session_regenerate_id(true);
        $this->_start();
        $this->_state = 'active';
        $this->_validate();
        $this->_setCounter();
        return true;
    }
    public function close()
    {
        session_write_close();
    }
    protected function _setCookieParams()
    {
        $cookie = session_get_cookie_params();
        if ($this->_force_ssl) {
            $cookie['secure'] = true;
        }
        
        $appConf = JAppConf::getInstance();
        
        $cookie_domain = $appConf->cookie_domain;
        if ($cookie_domain != '') {
            $cookie['domain'] = $cookie_domain;
        }
        $cookie_path = $appConf->cookie_path;
        if ($cookie_path != '') {
            $cookie['path'] = $cookie_path;
        }
        session_set_cookie_params($cookie['lifetime'], $cookie['path'], $cookie['domain'], $cookie['secure'], true);
    }
    protected function _createToken($length = 32)
    {
        static $chars = '0123456789abcdef';
        $max   = strlen($chars) - 1;
        $token = '';
        $name  = session_name();
        for ($i = 0; $i < $length; ++$i) {
            $token .= $chars[(rand(0, $max))];
        }
        return md5($token . $name);
    }
    protected function _setCounter()
    {
        $counter = $this->get('session.counter', 0);
        ++$counter;
        $this->set('session.counter', $counter);
        return true;
    }
    protected function _setTimers()
    {
        if (!$this->has('session.timer.start')) {
            $start = time();
            $this->set('session.timer.start', $start);
            $this->set('session.timer.last', $start);
            $this->set('session.timer.now', $start);
        }
        $this->set('session.timer.last', $this->get('session.timer.now'));
        $this->set('session.timer.now', time());
        return true;
    }
    protected function _setOptions(array $options)
    {
        if (isset($options['name'])) {
            session_name(md5($options['name']));
        }
        if (isset($options['id'])) {
            session_id($options['id']);
        }
        if (isset($options['expire'])) {
            $this->_expire = $options['expire'];
        }
        if (isset($options['security'])) {
            $this->_security = explode(',', $options['security']);
        }
        if (isset($options['force_ssl'])) {
            $this->_force_ssl = (bool) $options['force_ssl'];
        }
        ini_set('session.gc_maxlifetime', $this->_expire);
        return true;
    }
    protected function _validate($restart = false)
    {
        if ($restart) {
            $this->_state = 'active';
            $this->set('session.client.address', null);
            $this->set('session.client.forwarded', null);
            $this->set('session.client.browser', null);
            $this->set('session.token', null);
        }
        if ($this->_expire) {
            $curTime = $this->get('session.timer.now', 0);
            $maxTime = $this->get('session.timer.last', 0) + $this->_expire;
            if ($maxTime < $curTime) {
                $this->_state = 'expired';
                return false;
            }
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->set('session.client.forwarded', $_SERVER['HTTP_X_FORWARDED_FOR']);
        }
        if (in_array('fix_adress', $this->_security) && isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $this->get('session.client.address');
            if ($ip === null) {
                $this->set('session.client.address', $_SERVER['REMOTE_ADDR']);
            } elseif ($_SERVER['REMOTE_ADDR'] !== $ip) {
                $this->_state = 'error';
                return false;
            }
        }
        if (in_array('fix_browser', $this->_security) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $browser = $this->get('session.client.browser');
            if ($browser === null) {
                $this->set('session.client.browser', $_SERVER['HTTP_USER_AGENT']);
            } elseif ($_SERVER['HTTP_USER_AGENT'] !== $browser) {
            }
        }
        return true;
    }
}