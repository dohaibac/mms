<?php 
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
   400 => array('400 Bad Request', 'The request cannot be fulfilled due to bad syntax.'),
   403 => array('403 Forbidden', 'The server has refused to fulfil your request.'),
   404 => array('404 Not Found', 'Không tìm thấy trang đã yêu cầu.'),
   405 => array('405 Method Not Allowed', 'The method specified in the request is not allowed for the specified resource.'),
   408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
   418 => array('418 DDOS request', 'Bạn đang tải trang quá nhanh. Mời bạn chờ một lúc trước khi tải lại.'),
   500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
   502 => array('502 Bad Gateway', 'The server received an invalid response while trying to carry out the request.'),
   504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);
$title = $codes[$status][0];
$message = $codes[$status][1];
if ($title == false || strlen($status) != 3) {
  $message = 'Please supply a valid HTTP status code.';
}
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html" charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?php echo $title; ?></title>
</head>
<body>
<p><?php echo $message; ?></p><a href="/">Trang chủ</a>
</body>
</html>