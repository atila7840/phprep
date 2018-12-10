<?php
include('../wp-load.php');

wp_logout();
wp_set_current_user(0);

wp_redirect(home_url('login'));
exit;

?>