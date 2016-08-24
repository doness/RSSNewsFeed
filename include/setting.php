<?php
// fetch the setting row
$setting_query = "SELECT * FROM setting LIMIT 1";
$setting_result = $mysqli->query($setting_query);
if (@$setting_result->num_rows > 0) {
$setting_row = $setting_result->fetch_assoc();
$general_setting = unserialize($setting_row['general']);
$theme_setting = unserialize($setting_row['theme']);
}
