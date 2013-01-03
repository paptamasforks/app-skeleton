<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $title; ?></title>
    <?= Kohana::$config->load('static')->get('css').PHP_EOL; ?>
    <?= Kohana::$config->load('static')->get('javascript').PHP_EOL; ?>
</head>
<body>
    <header></header>
    <div id="content">
        <?= $content; ?>
    </div>
    <footer></footer>
</body>
</html>