<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.gisaka.net'; 
$config['smtp_user'] = 'gas@gisaka.net'; 
$config['smtp_pass'] = 'Gisaka2022'; 
$config['smtp_port'] = 465; 
$config['smtp_timeout'] = 30; 
$config['smtp_crypto'] = 'ssl'; 
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;
$config['dsn'] = FALSE;