<?php
 defined('LIBS_PATH') or die; class JCryptCipherBlowfish extends JCryptCipherMcrypt { protected $type = MCRYPT_BLOWFISH; protected $mode = MCRYPT_MODE_CBC; protected $keyType = 'blowfish'; }