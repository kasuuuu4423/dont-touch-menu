<?php
$zip = new ZipArchive;
$path = './';
$res = $zip->open('./phpMyAdmin.zip');
echo $path;
$zip->extractTo($path);
$zip->close();