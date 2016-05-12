<?php
defined('LIBS_PATH') or die;
class JDocument
{
    public $title = '';
    public $description = '';
    public $link = '';
    public $base = '';
    public $language = 'vi';
    public $_charset = 'utf-8';
    public $_mime = '';
    public $_namespace = '';
    public $_metaTags = array();
    public $_lineEnd = "\12";
    public $_mdate = '';
    public $params = null;
    public $_file = null;
    protected $_template = '';
    protected $_template_tags = array();
    public static $_buffer = null;
    public $appName = '';
    public function __construct($options = array(), $appName = '')
    {
        $this->appName = $appName;
        if (array_key_exists('lineend', $options)) {
            $this->setLineEnd($options['lineend']);
        }
        if (array_key_exists('charset', $options)) {
            $this->setCharset($options['charset']);
        }
        if (array_key_exists('language', $options)) {
            $this->setLanguage($options['language']);
        }
        if (array_key_exists('link', $options)) {
            $this->setLink($options['link']);
        }
        if (array_key_exists('base', $options)) {
            $this->setBase($options['base']);
        }
    }
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }
    public function getType()
    {
        return $this->_type;
    }
    public function getBuffer()
    {
        return self::$_buffer;
    }
    public function setBuffer($content, $options = array())
    {
        self::$_buffer = $content;
        return $this;
    }
    public function getMetaData($name, $httpEquiv = false)
    {
        $name = strtolower($name);
        if ($name == 'generator') {
            $result = $this->getGenerator();
        } elseif ($name == 'description') {
            $result = $this->getDescription();
        } else {
            if ($httpEquiv == true) {
                $result = @$this->_metaTags['http-equiv'][$name];
            } else {
                $result = @$this->_metaTags['standard'][$name];
            }
        }
        return $result;
    }
    public function setMetaData($name, $content, $http_equiv = false)
    {
        $name = strtolower($name);
        if ($name == 'generator') {
            $this->setGenerator($content);
        } elseif ($name == 'description') {
            $this->setDescription($content);
        } else {
            if ($http_equiv == true) {
                $this->_metaTags['http-equiv'][$name] = $content;
            } else {
                $this->_metaTags['standard'][$name] = $content;
            }
        }
        return $this;
    }
    public function setCharset($type = 'utf-8')
    {
        $this->_charset = $type;
        return $this;
    }
    public function getCharset()
    {
        return $this->_charset;
    }
    public function setLanguage($lang = "en-gb")
    {
        $this->language = strtolower($lang);
        return $this;
    }
    public function getLanguage()
    {
        return $this->language;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setMediaVersion($mediaVersion)
    {
        $this->mediaVersion = strtolower($mediaVersion);
        return $this;
    }
    public function getMediaVersion()
    {
        return $this->mediaVersion;
    }
    public function setBase($base)
    {
        $this->base = $base;
        return $this;
    }
    public function getBase()
    {
        return $this->base;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setLink($url)
    {
        $this->link = $url;
        return $this;
    }
    public function getLink()
    {
        return $this->link;
    }
    public function setGenerator($generator)
    {
        $this->_generator = $generator;
        return $this;
    }
    public function getGenerator()
    {
        return $this->_generator;
    }
    public function setModifiedDate($date)
    {
        $this->_mdate = $date;
        return $this;
    }
    public function getModifiedDate()
    {
        return $this->_mdate;
    }
    public function setMimeEncoding($type = 'text/html', $sync = true)
    {
        $this->_mime = strtolower($type);
        if ($sync) {
            $this->setMetaData('content-type', $type . '; charset=' . $this->_charset, true);
        }
        return $this;
    }
    public function getMimeEncoding()
    {
        return $this->_mime;
    }
    public function setLineEnd($style)
    {
        switch ($style) {
            case 'win':
                $this->_lineEnd = "\15\12";
                break;
            case 'unix':
                $this->_lineEnd = "\12";
                break;
            case 'mac':
                $this->_lineEnd = "\15";
                break;
            default:
                $this->_lineEnd = $style;
        }
        return $this;
    }
    public function _getLineEnd()
    {
        return $this->_lineEnd;
    }
    public function loadRenderer($type)
    {
        $class = 'JDocumentRenderer' . $type;
        if (!class_exists($class)) {
            $path = __DIR__ . '/renderer/' . $type . '.php';
            if (file_exists($path)) {
                require_once $path;
            } else {
                throw new RuntimeException('Unable to load renderer class', 500);
            }
        }
        if (!class_exists($class)) {
            return null;
        }
        $instance = new $class($this);
        return $instance;
    }
    protected function _parseTemplate()
    {
        $matches = array();
        if (preg_match_all('#<jdoc:include\ type="([^"]+)"(.*)\/>#iU', $this->_template, $matches)) {
            $template_tags_first = array();
            $template_tags_last  = array();
            for ($i = count($matches[0]) - 1; $i >= 0; $i--) {
                $type    = $matches[1][$i];
                $attribs = empty($matches[2][$i]) ? array() : JUtility::parseAttributes($matches[2][$i]);
                $name    = isset($attribs['name']) ? $attribs['name'] : null;
                if ($type == 'module' || $type == 'modules') {
                    $template_tags_first[$matches[0][$i]] = array(
                        'type' => $type,
                        'name' => $name,
                        'attribs' => $attribs
                    );
                } else {
                    $template_tags_last[$matches[0][$i]] = array(
                        'type' => $type,
                        'name' => $name,
                        'attribs' => $attribs
                    );
                }
            }
            $template_tags_last   = array_reverse($template_tags_last);
            $this->_template_tags = $template_tags_first + $template_tags_last;
        }
        return $this;
    }
    protected function _renderTemplate()
    {
        $replace = array();
        $with    = array();
        foreach ($this->_template_tags as $jdoc => $args) {
            $replace[] = $jdoc;
            $with[]    = $this->getBuffer($args['type'], $args['name'], $args['attribs']);
        }
        return str_replace($replace, $with, $this->_template);
    }
    protected function _loadTemplate($filename)
    {
        $contents = '';
        if (file_exists($filename)) {
          
            $this->_file = $filename;
            $app         = JBase::getApplication($this->appName);
            ob_start();
            $appConf = $app->appConf;
            require $filename;
            $contents = ob_get_contents();
            ob_end_clean();
        }
        
        return $contents;
    }
    protected function outputfilter_trimwhitespace($source)
    {
        $source = preg_replace('#^\s*//.+$#m', "", $source);
        $source = preg_replace('!/\*.*?\*/!s', '', $source);
        $source = preg_replace('/\n\s*\n/', "\n", $source);
        $source = trim(preg_replace('/((?<!\?>)\n)[\s]+/m', '\1', $source));
        $source = preg_replace("/<!--.*-->/U", "", $source);
        $source = preg_replace(array(
            '/\r/',
            '/\n/'
        ), '', $source);
        return $source;
    }
}