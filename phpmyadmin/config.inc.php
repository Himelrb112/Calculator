<?php
/* Localhost config */
$i = 0;
$i++;
$cfg['Servers'][$i]['host'] = '127.0.0.1';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = '';
$cfg['Servers'][$i]['auth_type'] = 'config';

/* 🔹 Azure MySQL config */
$i++;
$cfg['Servers'][$i]['verbose'] = 'Azure MySQL';   // নামটা এখানে দাও
$cfg['Servers'][$i]['host'] = 'mycalcserver.mysql.database.azure.com';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['user'] = 'himel112@mycalcserver';
$cfg['Servers'][$i]['password'] = 'Bdu#4172';
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['ssl'] = true;
?>
