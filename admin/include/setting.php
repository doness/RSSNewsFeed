<?php
$setting_query = "SELECT * FROM setting LIMIT 1";
$setting_result = $mysqli->query($setting_query);
$setting_row = $setting_result->fetch_assoc();
$general_setting = unserialize($setting_row['general']);
