<?php
// 简单的 PHP 测试文件
header('Content-Type: text/plain');
echo "Hello, this is a PHP test file!";
echo "当前字符集：" . mb_internal_encoding() . "\n";
echo "当前语言：" . getenv('LANG') . "\n";
?>