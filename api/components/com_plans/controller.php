<?php
defined('BASEPATH') or die;

class PlansController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/plans.php';
    
    $this->plans_model =  new PlansModel($this->app);
  }
   
  /***
   * Common function
   * 
   * detect insert, update, delete
   * 
   * */
  public function index () {
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    
    switch ($method) {
      case 'GET':
        $this->view();
        break;
      case 'POST':
        $this->insert();
        break;
      case 'PUT':
        $this->update();
        break;
      case 'DELETE':
        $this->delete();
        break;
      default:
        break;
    }
  }
  
  /***
   *  View a plan
   * */
  public function view() {

  }
  
  /***
   * Insert plans
   * */
  public function insert() {

  }
  
  /***
   * delete plan
   * */
  public function delete() {

  }
  
  /***
   * Lay danh sach user group theo paging
   * 
   * */
  public function get_provinces() {
    try {
      
      $db = $this->app->getDbo();
      
      $provinces = $this->plans_model->provinces();

      $ret = array (
        'provinces' => $provinces,
      );

      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('provinces_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'provinces_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>
