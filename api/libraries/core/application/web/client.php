<?php
defined('LIBS_PATH') or die;
class JApplicationWebClient
{
    const WINDOWS = 1;
    const WINDOWS_PHONE = 2;
    const WINDOWS_CE = 3;
    const IPHONE = 4;
    const IPAD = 5;
    const IPOD = 6;
    const MAC = 7;
    const BLACKBERRY = 8;
    const ANDROID = 9;
    const LINUX = 10;
    const TRIDENT = 11;
    const WEBKIT = 12;
    const GECKO = 13;
    const PRESTO = 14;
    const KHTML = 15;
    const AMAYA = 16;
    const IE = 17;
    const FIREFOX = 18;
    const CHROME = 19;
    const SAFARI = 20;
    const OPERA = 21;
    const ANDROIDTABLET = 22;
    protected $platform;
    protected $mobile = false;
    protected $engine;
    protected $browser;
    protected $browserVersion;
    protected $languages = array();
    protected $encodings = array();
    protected $userAgent;
    protected $acceptEncoding;
    protected $acceptLanguage;
    protected $robot = false;
    protected $detection = array();
    public function __construct($userAgent = null, $acceptEncoding = null, $acceptLanguage = null)
    {
        if (empty($userAgent) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $this->userAgent = $userAgent;
        }
        if (empty($acceptEncoding) && isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            $this->acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
        } else {
            $this->acceptEncoding = $acceptEncoding;
        }
        if (empty($acceptLanguage) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $this->acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        } else {
            $this->acceptLanguage = $acceptLanguage;
        }
    }
    public function __get($name)
    {
        switch ($name) {
            case 'mobile':
            case 'platform':
                if (empty($this->detection['platform'])) {
                    $this->detectPlatform($this->userAgent);
                }
                break;
            case 'engine':
                if (empty($this->detection['engine'])) {
                    $this->detectEngine($this->userAgent);
                }
                break;
            case 'browser':
            case 'browserVersion':
                if (empty($this->detection['browser'])) {
                    $this->detectBrowser($this->userAgent);
                }
                break;
            case 'languages':
                if (empty($this->detection['acceptLanguage'])) {
                    $this->detectLanguage($this->acceptLanguage);
                }
                break;
            case 'encodings':
                if (empty($this->detection['acceptEncoding'])) {
                    $this->detectEncoding($this->acceptEncoding);
                }
                break;
            case 'robot':
                if (empty($this->detection['robot'])) {
                    $this->detectRobot($this->userAgent);
                }
                break;
        }
        if (isset($this->$name)) {
            return $this->$name;
        }
    }
    protected function detectBrowser($userAgent)
    {
        if ((stripos($userAgent, 'MSIE') !== false) && (stripos($userAgent, 'Opera') === false)) {
            $this->browser  = self::IE;
            $patternBrowser = 'MSIE';
        } elseif ((stripos($userAgent, 'Firefox') !== false) && (stripos($userAgent, 'like Firefox') === false)) {
            $this->browser  = self::FIREFOX;
            $patternBrowser = 'Firefox';
        } elseif (stripos($userAgent, 'Chrome') !== false) {
            $this->browser  = self::CHROME;
            $patternBrowser = 'Chrome';
        } elseif (stripos($userAgent, 'Safari') !== false) {
            $this->browser  = self::SAFARI;
            $patternBrowser = 'Safari';
        } elseif (stripos($userAgent, 'Opera') !== false) {
            $this->browser  = self::OPERA;
            $patternBrowser = 'Opera';
        }
        if ($this->browser) {
            $pattern = '#(?<browser>Version|' . $patternBrowser . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            $matches = array();
            if (preg_match_all($pattern, $userAgent, $matches)) {
                if (count($matches['browser']) == 2) {
                    if (strripos($userAgent, 'Version') < strripos($userAgent, $patternBrowser)) {
                        $this->browserVersion = $matches['version'][0];
                    } else {
                        $this->browserVersion = $matches['version'][1];
                    }
                } elseif (count($matches['browser']) > 2) {
                    $key = array_search('Version', $matches['browser']);
                    if ($key) {
                        $this->browserVersion = $matches['version'][$key];
                    }
                } else {
                    $this->browserVersion = $matches['version'][0];
                }
            }
        }
        $this->detection['browser'] = true;
    }
    protected function detectEncoding($acceptEncoding)
    {
        $this->encodings                   = array_map('trim', (array) explode(',', $acceptEncoding));
        $this->detection['acceptEncoding'] = true;
    }
    protected function detectEngine($userAgent)
    {
        if (stripos($userAgent, 'MSIE') !== false || stripos($userAgent, 'Trident') !== false) {
            $this->engine = self::TRIDENT;
        } elseif (stripos($userAgent, 'AppleWebKit') !== false || stripos($userAgent, 'blackberry') !== false) {
            $this->engine = self::WEBKIT;
        } elseif (stripos($userAgent, 'Gecko') !== false && stripos($userAgent, 'like Gecko') === false) {
            $this->engine = self::GECKO;
        } elseif (stripos($userAgent, 'Opera') !== false || stripos($userAgent, 'Presto') !== false) {
            $this->engine = self::PRESTO;
        } elseif (stripos($userAgent, 'KHTML') !== false) {
            $this->engine = self::KHTML;
        } elseif (stripos($userAgent, 'Amaya') !== false) {
            $this->engine = self::AMAYA;
        }
        $this->detection['engine'] = true;
    }
    protected function detectLanguage($acceptLanguage)
    {
        $this->languages                   = array_map('trim', (array) explode(',', $acceptLanguage));
        $this->detection['acceptLanguage'] = true;
    }
    protected function detectPlatform($userAgent)
    {
        if (stripos($userAgent, 'Windows') !== false) {
            $this->platform = self::WINDOWS;
            if (stripos($userAgent, 'Windows Phone') !== false) {
                $this->mobile   = true;
                $this->platform = self::WINDOWS_PHONE;
            } elseif (stripos($userAgent, 'Windows CE') !== false) {
                $this->mobile   = true;
                $this->platform = self::WINDOWS_CE;
            }
        } elseif (stripos($userAgent, 'iPhone') !== false) {
            $this->mobile   = true;
            $this->platform = self::IPHONE;
            if (stripos($userAgent, 'iPad') !== false) {
                $this->platform = self::IPAD;
            } elseif (stripos($userAgent, 'iPod') !== false) {
                $this->platform = self::IPOD;
            }
        } elseif (stripos($userAgent, 'iPad') !== false) {
            $this->mobile   = true;
            $this->platform = self::IPAD;
        } elseif (stripos($userAgent, 'iPod') !== false) {
            $this->mobile   = true;
            $this->platform = self::IPOD;
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $this->platform = self::MAC;
        } elseif (stripos($userAgent, 'Blackberry') !== false) {
            $this->mobile   = true;
            $this->platform = self::BLACKBERRY;
        } elseif (stripos($userAgent, 'Android') !== false) {
            $this->mobile   = true;
            $this->platform = self::ANDROID;
            if (stripos($userAgent, 'Android 3') !== false || stripos($userAgent, 'Tablet') !== false || stripos($userAgent, 'Mobile') === false || stripos($userAgent, 'Silk') !== false) {
                $this->platform = self::ANDROIDTABLET;
            }
        } elseif (stripos($userAgent, 'Linux') !== false) {
            $this->platform = self::LINUX;
        }
        $this->detection['platform'] = true;
    }
    protected function detectRobot($userAgent)
    {
        if (preg_match('/http|bot|robot|spider|crawler|curl|^$/i', $userAgent)) {
            $this->robot = true;
        } else {
            $this->robot = false;
        }
        $this->detection['robot'] = true;
    }
}