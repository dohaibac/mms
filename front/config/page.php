<?php  

defined('BASEPATH') or die;

/***
 * Danh sach trang co trong he thong, va thong tin module se hien thi trong trang day
 * 
 * $pageConf[page_name] = array ('title', 'required_login' => TRUE | FALSE, 'keywords'=>, 'description'=> ...);
 * 
 * */
$pageConf = array ();

// trang cpanel, kiem tra trang thai xem live or die
$pageConf['cpanel'] = array (
  'title'=> 'page_cpanel_title',
  'keywords' => 'page_cpanel_keywords',
  'description' => 'page_cpanel_description',
  'required_login' =>TRUE
);
$pageConf['cpanel']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'dashboard',
);

// ======= trang login ========================
$pageConf['login'] = array (
  'title'=> 'page_login_title',
  'keywords' => 'page_login_keywords',
  'description' => 'page_login_description',
  'theme_page_name' => 'login'
);

$pageConf['login']['modules'] = array (
  'position-1' => '',
  'position-2' => 'login',
);

// ======== trang register ======================
$pageConf['register'] = array (
  'title'=> 'page_register_title',
  'keywords' => 'page_register_keywords',
  'description' => 'page_register_description',
);

$pageConf['register']['modules'] = array (
  'position-1' => '',
  'position-2' => 'register',
);

// ========= trang forgot password ================
$pageConf['forgot_password'] = array (
  'title'=> 'page_forgot_password_title',
  'keywords' => 'page_forgot_password_keywords',
  'description' => 'page_forgot_password_description',
  'theme_page_name' => 'login'
);

$pageConf['forgot_password']['modules'] = array (
  'position-1' => '',
  'position-2' => 'forgotpassword',
);

// ========= trang profile =========================
$pageConf['profile'] = array (
  'title'=> 'page_profile_title',
  'keywords' => 'page_profile_keywords',
  'description' => 'page_profile_description',
  'required_login' =>TRUE
);

$pageConf['profile']['modules'] = array (
  'position-1' => 'user.profile'
);

// ========= trang services =========================
$pageConf['services'] = array (
  'title'=> 'page_services_title',
  'keywords' => 'page_services_keywords',
  'description' => 'page_services_description',
  'required_login' =>TRUE
);

$pageConf['services']['modules'] = array (
  'position-1' => 'services'
);

// trang user
$pageConf['user'] = array (
  'title'=> 'page_user_title',
  'keywords' => 'page_user_keywords',
  'description' => 'page_user_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['user']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'user.menu',
  'position-3' => 'user',
);

// trang helpguide
$pageConf['helpguide'] = array (
  'title'=> 'page_helpguide_title',
  'keywords' => 'page_helpguide_keywords',
  'description' => 'page_helpguide_description',
  'theme_page_name' => 'main'
);
$pageConf['helpguide']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'usermenu',
  'position-3' => '',
);

// trang getpassword
$pageConf['getpassword'] = array (
  'title'=> 'page_getpassword_title',
  'keywords' => 'page_getpassword_keywords',
  'description' => 'page_getpassword_description',
  'theme_page_name' => 'login'
);
$pageConf['getpassword']['modules'] = array (
  'position-1' => 'loginhead',
  'position-2' => 'getpassword',
);

// trang user-active
$pageConf['useractive'] = array (
  'title'=> 'page_useractive_title',
  'keywords' => 'page_useractive_keywords',
  'description' => 'page_useractive_description',
  'theme_page_name' => 'login'
);
$pageConf['useractive']['modules'] = array (
  'position-1' => 'loginhead',
  'position-2' => 'useractive',
);

// trang quan ly menu

$pageConf['menu'] = array (
  'title'=> 'page_menu_title',
  'keywords' => 'page_menu_keywords',
  'description' => 'page_menu_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['menu']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'menu.menubar',
  'position-3' => 'menu',
);

// trang user system
$pageConf['usersystem'] = array (
  'title'=> 'page_usersystem_title',
  'keywords' => 'page_usersystem_keywords',
  'description' => 'page_usersystem_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['usersystem']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'usersystemmenu,usermenu',
  'position-3' => 'usersystem',
);
// trang user system
$pageConf['system'] = array (
  'title'=> 'page_system_title',
  'keywords' => 'page_system_keywords',
  'description' => 'page_system_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['system']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'system.menu',
  'position-3' => 'system',
);

// trang sponsor
$pageConf['sponsor'] = array (
  'title'=> 'page_sponsor_title',
  'keywords' => 'page_sponsor_keywords',
  'description' => 'page_sponsor_description',
  'required_login' =>TRUE
);
$pageConf['sponsor']['modules'] = array (
  'position-1' => 'head',
  'position-2' => '',
  'position-3' => 'sponsor',
);


// trang sponsor
$pageConf['pd'] = array (
  'title'=> 'page_pd_title',
  'keywords' => 'page_pd_keywords',
  'description' => 'page_pd_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['pd']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'pd.menu,gd.menu',
  'position-3' => 'pd',
);

// trang sponsor
$pageConf['gd'] = array (
  'title'=> 'page_gd_title',
  'keywords' => 'page_gd_keywords',
  'description' => 'page_gd_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['gd']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'pd.menu,gd.menu',
  'position-3' => 'gd',
);


// trang other
$pageConf['other'] = array (
  'title'=> 'page_other_title',
  'keywords' => 'page_other_keywords',
  'description' => 'page_other_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['other']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'other.menu',
  'position-3' => 'other',
);

// trang other
$pageConf['report'] = array (
  'title'=> 'page_report_title',
  'keywords' => 'page_report_keywords',
  'description' => 'page_report_description',
  'theme_page_name' => 'main',
  'required_login' =>TRUE
);
$pageConf['report']['modules'] = array (
  'position-1' => 'head',
  'position-2' => 'report.menu',
  'position-3' => 'report',
);


// trang sponsor
$pageConf['gcm'] = array (
  'title'=> 'page_gcm_title',
  'keywords' => 'page_gcm_keywords',
  'description' => 'page_gcm_description',
  'theme_page_name' => 'gcm'
);
$pageConf['gcm']['modules'] = array (
  'position-1' => '',
  'position-2' => 'gcm',
  'position-3' => '',
);



/* End of file page.php */
/* Location: ./config/page.php */