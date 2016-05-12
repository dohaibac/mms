<?php
 defined('LIBS_PATH') or die; class JCryptCipher3Des extends JCryptCipherMcrypt { protected $type = MCRYPT_3DES; protected $mode = MCRYPT_MODE_CBC; protected $keyType = '3des'; }