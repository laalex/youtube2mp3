<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Email configuration
 */
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'alambadev@gmail.com';
$config['smtp_pass'] = '<Androidsdk_93_1>';
$config['charset']    = 'utf-8';
$config['newline']    = "\r\n";
$config['mailtype'] = 'html'; // or html
$config['validation'] = TRUE; // bool whether to validate email or not