<?php

$segment = $this->uri->segment('1'); 

if($segment == null){
    
    require_once('header-login.php');

} else if($segment == 'widget') {
    require_once('header-widget.php');
}else {
    require_once('header-dashboard.php');
    require_once('sidebar-dashboard.php');
}

if (isset($content)) {
    $this->load->view($content);
}


if($segment == null){

    require_once('footer-login.php');

} else if($segment == 'widget') {
    require_once('footer-widget.php');
} else {
    require_once('footer-dashboard.php');
}
