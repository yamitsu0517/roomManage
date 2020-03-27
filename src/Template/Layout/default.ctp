<?php

$this->prepend('css', $this->Html->css(['style.css']));
?>
<!DOCTYPE html>
<html>
<head>
<?= $this->Html->charset() ?>
<?= $this->Html->meta('icon') ?>
<title><?= $this->fetch('title') ?></title>
<?= $this->fetch('css')?>
</head>
<body>
<?= $this->element('menu/' . $menu)?>
<?= $this->element('content')?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'); ?>
<?= $this->Html->script('style.js') ?>
<?= $this->Html->script('user_edit.js')?>
<?= $this->Html->script('getUserData.js')?>
<!-- SP 用画面調整 -->
<!--<meta name="viewport" content="width=device-width,initial-scale=1">-->
<meta name="viewport" content="width=360,initial-scale=1">
</body>
</html>