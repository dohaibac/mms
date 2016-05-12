<?php
defined('LIBS_PATH') or die;
class JDatabaseDriverSimulator extends JDatabaseDriver
{
    public $name = 'mysqli';
    protected $nameQuote = '`';
    protected $nullDate = '0000-00-00 00:00:00';
    protected static $dbMinimum = '5.0.4';
    
    public function __construct($options)
    {
        $options['host']     = (isset($options['host'])) ? $options['host'] : 'localhost';
        $options['user']     = (isset($options['user'])) ? $options['user'] : 'root';
        $options['password'] = (isset($options['password'])) ? $options['password'] : '';
        $options['database'] = (isset($options['database'])) ? $options['database'] : '';
        $options['select']   = (isset($options['select'])) ? (bool) $options['select'] : true;
        $options['port']     = null;
        $options['socket']   = null;
        parent::__construct($options);
    }
    public function __destruct()
    {
        $this->disconnect();
    }
    public function connect()
    {
        return;
    }
    public function disconnect()
    {
        return;
    }
    
    public function connected()
    {
        return false;
    }
    public function dropTable($Vdwjpapdeue4, $Vzap2aandp1y = true)
    {
        return $this;
    }
    public function getAffectedRows()
    {
        return $this;
    }
    public function getCollation()
    {
        return null;
    }
    public function getNumRows($Vbu5ksgeommx = null)
    {
        return $this;
    }
    public function getTableCreate($Vxoikzrceodo)
    {
       return $this;
    }
    public function getTableColumns($V0suxbdnjztb, $Vqtcl5j33wzc = true)
    {
       return $this;
    }
    public function getTableKeys($V0suxbdnjztb)
    {
        return $this;
    }
    public function getTableList()
    {
        return $this;
    }
    public function getVersion()
    {
       return '';
    }
    public function insertid()
    {
       return 0;
    }
    public function lockTable($V0suxbdnjztb)
    {
        return $this;
    }
    public function execute()
    {
       return $this;
    }
    public function renameTable($V34ztimsvp1o, $Vvvcpwk0hs43, $Vmktchefqdpl = null, $Vk2djcricvoe = null)
    {
        return $this;
    }
    public function select($Vlp5p4t3bdle)
    { 
        return true;
    }
    public function setUTF()
    {
       return false;
    }
    public function transactionCommit($Vzk2fv1ypuh2 = false)
    {
       return false;
    }
    public function transactionRollback($Vzk2fv1ypuh2 = false)
    {
        return false;
    }
    public function transactionStart($Vrjnei4ewfv2 = false)
    {
       return false;
    }
    protected function fetchArray($Vbu5ksgeommx = null)
    {
       return false;
    }
    protected function fetchAssoc($Vbu5ksgeommx = null)
    {
       return false;
    }
    protected function fetchObject($Vbu5ksgeommx = null, $Vw15fozgj02a = 'stdClass')
    {
        return false;
    }
    protected function freeResult($Vbu5ksgeommx = null)
    {
       return false;
    }
    public function unlockTables()
    {
      return false;
    }
    private function hasProfiling()
    {
       return false;
    }
    public static function isSupported()
    {
        return true;
    }
    
    public function escape($V54emogrpj1r, $Vzmsknbfooys = false)
    {
        $Vanv2qkbf2be = @mysql_escape_string($V54emogrpj1r);
        if ($Vzmsknbfooys) {
            $Vanv2qkbf2be = addcslashes($Vanv2qkbf2be, '%_');
        }
        return $Vanv2qkbf2be;
    }
}