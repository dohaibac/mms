<?php
defined('BASEPATH') or die;

class CaptchaController extends JControllerForm 
{
  public function index() {
    $width  = $this->getSafe('w', 130);
    $height = $this->getSafe('h', 40);
    $length = $this->getSafe('l', 6);
    $captcha_name = $this->getSafe('n', 'captcha');
    
    JBASE::getSession()->clear($captcha_name);
    
    $img  = imagecreate($width, $height);
  
    $color_white = imagecolorallocate($img, 255, 255, 255);
    $color_gray  = imagecolorallocate($img, 192, 192, 192);
    $color_red   = imagecolorallocate($img, 255, 0, 0); 
  
    $color_blue  = imagecolorallocate($img, 4, 87, 196); 
  
    srand((double)microtime()*10000);
   
    $background_color = imagecolorallocate($img, 243, 243, 243);  
    imagefilledrectangle($img,0,0,200,50, $background_color);
    
    for($i=0;$i<5; $i++) {
        imageline($img, 0, rand()%50, 200, rand()%50, $color_gray);
    }
    
    $pixel_color = imagecolorallocate($img, 0,0,255);
    for($i=0;$i<100;$i++) {
        imagesetpixel($img, rand()%200,rand()%50, $pixel_color);
    }  
    
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $len = strlen($letters);
    $letter = $letters[rand(0, $len-1)];
  
    $word = '';
    $fonts = array(
      //PATH_PLUGINS . '/captcha/fonts/AntykwaBold.ttf',
      //PATH_PLUGINS . '/captcha/fonts/Ding-DongDaddyO.ttf',
      //PATH_PLUGINS . '/captcha/fonts/Duality.ttf',
      //PATH_PLUGINS . '/captcha/fonts/Heineken.ttf',
      //PATH_PLUGINS . '/captcha/fonts/Jura.ttf',
      //PATH_PLUGINS . '/captcha/fonts/StayPuft.ttf',
      PATH_PLUGINS . '/captcha/fonts/VeraSansBold.ttf',
      PATH_PLUGINS . '/captcha/fonts/TimesNewRomanBold.ttf'
    );
    
    $index = rand (0 , count($fonts) - 1);
  
    for ($i = 0; $i< $length; $i++) {
      $letter = $letters[rand(0, $len-1)];
      // Add some shadow to the text
      imagettftext($img, 18, 0, 5+($i*20), 29, $color_gray, $fonts[$index], $letter);
      // Add the text
      imagettftext($img, 18, 0, 5+($i*20), 30, $color_blue, $fonts[$index], $letter);
      
      $word.=$letter;
    }
    
    JBASE::getSession()->set($captcha_name, $word);
    
    header("Content-Type: image/png");
    
    imagepng($img);
    imagedestroy($img);
  }
}
?>