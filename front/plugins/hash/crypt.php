<?php
/**
 * The hash class
 * */
class HashPassword{
  /**
   * Generate hash
   * */
  public function generateHash($password) {
      if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
          $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
          return crypt($password, $salt);
      }
  }
  /**
   * verify password
   * */
  public function verify($password, $hashedPassword) {
      return crypt($password, $hashedPassword) == $hashedPassword;
  }
}
?>