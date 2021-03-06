<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
 
 * 
    pre_system
   
    pre_controller
   
    post_controller_constructor
   
    post_controller
   
    display_override
   
    cache_override
   
    post_system
   
 * 
*/




$hook['post_controller_constructor'] = array(
	'class'    => 'Header_init',
	'function' => 'inits',
	'filename' => 'Header_init.php',
	'filepath' => 'hooks'
);