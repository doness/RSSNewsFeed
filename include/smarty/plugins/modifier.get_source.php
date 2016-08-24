<?php
function smarty_modifier_get_source($id)
{
if ($id == 0) {
return 'private';
} else {
global $mysqli;
$sql = "SELECT title FROM sources WHERE id='$id' LIMIT 1";
$query = $mysqli->query($sql);
$row = $query->fetch_assoc();
return $row['title'];
}
}
?>