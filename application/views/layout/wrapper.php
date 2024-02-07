<?php
require_once('header-login.php');
if (isset($content)) {
    $this->load->view($content);
}
require_once('footer-login.php');
