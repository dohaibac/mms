<?php
 defined('LIBS_PATH') or die; class JCryptCipherRijndael256 extends JCryptCipherMcrypt { protected $type = MCRYPT_RIJNDAEL_256; protected $mode = MCRYPT_MODE_CBC; protected $keyType = 'rijndael256'; }