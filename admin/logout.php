<?php
session_start();
if (isset($_SESSION['rss_script_admin'])) {
unset($_SESSION['rss_script_admin']);
session_destroy();
echo "<meta http-equiv='refresh' content='0;URL=login.php'>";
}
?>