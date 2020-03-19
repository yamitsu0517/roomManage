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


</body>
</html>