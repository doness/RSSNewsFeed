<?php
function smarty_modifier_news_in_category($id,$number) {
global $mysqli;
$sql = "SELECT * FROM news WHERE category_id='$id' AND published='1' ORDER BY id DESC LIMIT $number";
$query = $mysqli->query($sql);
if ($query->num_rows == 0) {
return 0;	
} else {
while ($row = $query->fetch_assoc()) {
$news[] = $row;
}
return $news;
}
}
?>
