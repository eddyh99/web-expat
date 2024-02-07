<?php
require_once('header-dashboard.php');

require_once('sidebar-dashboard.php');

if (isset($content)) {
    $this->load->view($content);
}

require_once('footer-dashboard.php');
