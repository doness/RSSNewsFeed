<?php
function smarty_modifier_html_decode($string) {
       return htmlspecialchars_decode($string, ENT_QUOTES);
}

?>