<?php
function smarty_modifier_get_since($date) {
$ti = time();
$oneday = $ti - 2592000;
if ($date > $oneday) {
$stf = 0;
$cur_time = time();
$diff = $cur_time - $date;
$phrase = array('second','minute','hour','day','week','month','year');
$length = array(1,60,3600,86400,604800,2630880,31570560);
for($i = sizeof($length)-1; ($i >= 0)&&(($no = $diff/$length[$i])<=1); $i--); 
if($i < 0) $i = 0; $_time = $cur_time -($diff%$length[$i]);
$no = floor($no); if($no <> 1) $phrase[$i] .=''; $value=sprintf("%d %s",$no,$phrase[$i]);
if(($stf == 1)&&($i >= 1)&&(($cur_tm-$_time) > 0)) $value .= time_ago($_time);
$val = explode(' ',$value);
if ($val[0] == 1) {
return $value.' ago';
} else {
return $value.'s ago';
}
} else {
return date('j-n-Y',$date);
}
}
?>
