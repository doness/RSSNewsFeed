<?php
function smarty_modifier_get_datetime($timestamp,$is_time) {
if (date('a') == 'am') {
$a = 'ص';
} else {
$a = 'م';
}
$date = date('Y-n-j',$timestamp);
$time = date('h:i',$timestamp);
if ($is_time == 1) {
return $date.' '.$time.' '.$a;
} else {
return $date;
}
}
?>
