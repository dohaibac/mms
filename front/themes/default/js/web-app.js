function generate_url (ctrl, task) {
  return '/?' + appConf['ctrl'] + '=' + ctrl + '&' + appConf['task'] + '=' + task;
}
function calcTime(offset) {
  var today = new Date();  
  var localoffset = -(today.getTimezoneOffset()/60);
  var destoffset = offset; 
  
  var offset = destoffset-localoffset;
  var d = new Date( new Date().getTime() + offset * 3600 * 1000);
  
  return d;
};

$(document).ready(function() {
  var pathname = window.location.href;
  
  $('.main-menu li a').each(function(index) {
    if (this.href.trim() == pathname) {
      $(this).addClass("active");
    }
  });
  $('#sidebar ul li a').each(function(index) {
    if (this.href.trim() == pathname) {
      $(this).addClass("active");
    }
  });
  
  // init recaptcha
  $('.recaptcha').click (function() {
    var milliseconds = new Date().getTime();
    $(this).prev().attr('src', '/captcha?t=' + milliseconds);
  });
  
  var scopeNoty = angular.element($('#NotyCtrl')).scope();
  
});

function check_ajax_required_login(data) {
  if (data && data.login_url) {
    window.location.href = data.login_url;
  }
}

function confirm_del() {
  return confirm('Bạn có chắc chắn muốn xóa không?');
}
function confirm_delcate() {
  return confirm('Bạn có chắc chắn muốn xóa danh mục này?');
}
