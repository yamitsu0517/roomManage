<?php
// 値を設定するフォルダ

$hours_st = '09:00'; //設定開始時間('hh:nn'で指定)
$hours_end = '21:00'; //設定終了時間('hh:nn'で指定)
$hours_margin = 30; //間隔を指定(分)
$chapters = array('会議室A', '会議室B', '会議室C', '会議室D'); //項目名を配列で定義
$tbl_flg = false; //時間を横軸 → true, 縦軸 → falseにする
$master_key = 'special';