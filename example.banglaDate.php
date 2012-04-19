<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php
include_once 'class.banglaDate.php';
$bn = new BanglaDate(time());
print_r($bn->get_date());

echo '<br>';
$bn->set_time(time(), 0);
print_r($bn->get_date());

echo '<br>';
$bn->set_time(strtotime('18-03-1988'), 0);
print_r($bn->get_date());

echo '<br>';
$bn->set_time(strtotime('18-03-1988'), 6);
print_r($bn->get_date());