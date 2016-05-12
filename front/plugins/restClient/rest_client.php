<?php
/**
 * The hash class
 * */
class RestClient{
  public $base_url = '';
  public $api_key = '';
  public $secret = '';
  public $timeout = 60;
  public $method = 'GET';
  
  public $expired_time = 0;
  
  public function __construct($base_url, $api_key, $secret, $timeout) {
    include_once __DIR__ . '/httpful.phar';
    
    $this->base_url = $base_url;
    $this->api_key = $api_key;
    $this->secret = $secret;
    $this->timeout = $timeout;
    
    $this->expired_time = time() + $this->timeout;
  }
  
  public function get($request_path, $data) {
    $this->method = 'GET';
    
    $data_keys = $data;
    
    $data_keys['api_key'] = $this->api_key;
    $data_keys['expires'] = $this->expired_time;
    $data_keys['sign'] = generate_signal($this->method, $this->secret, $request_path, $this->expired_time, $data);
    
    $data_string = http_build_query($data_keys);
    $url = $this->base_url . $request_path . '?' . $data_string;
    
    return \Httpful\Request::get($url)->send();
  }
  
  public function post($request_path, $data) {
    $this->method = 'POST';
    
    $url = $this->get_url($request_path, $data);
    
    $data_string = json_encode($data);
    
    return \Httpful\Request::post($url)
      ->sendsJson()
      ->body($data_string)
      ->send();
  }
  
  public function put($request_path, $data) {
    $this->method = 'PUT';
    
    $url = $this->get_url($request_path, $data);
    
    $data_string = json_encode($data);
    
    return \Httpful\Request::put($url)
      ->body($data_string)
      ->send();
  }
  
  public function delete($request_path, $data) {
    $this->method = 'DELETE';
    
    $url = $this->get_url($request_path, $data);
    
    $data_string = json_encode($data);
    
    return \Httpful\Request::delete($url)
      ->body($data_string)
      ->send();
  }
  private function get_url($request_path, $data) {
    $data_keys = array (
      'api_key' => $this->api_key,
      'expires' => $this->expired_time,
      'sign' => generate_signal($this->method, $this->secret, $request_path, $this->expired_time, array(), json_encode($data))
    );
    $data_key_string = http_build_query($data_keys);
    return $this->base_url . $request_path . '?' . $data_key_string;
  }
}
?>