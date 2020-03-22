# 部屋管理アプリ


## 目的
社員が部屋を自由に使えることにより、人間力・スキルアップ

## 行えること
1. ログイン機能
2. 日付指定
3. 使う部屋・時間指定  
4. 部屋追加（管理者権限）

## これからの発展（）
1. カレンダーの拡張  
2. 管理者権限の拡張(現時点ではフラグなのでその書き方を変更。ex. 数字増やす, ` 1 1 1` のように書く etc.)
3. SP版の拡張（画面表示分け）

## 環境構築
1. 設定ファイル  
　config/config.php  に開始時間・終了時間が設定されているので、任意の値を設定してください（分は30分単位）
2. データベース
 ```bash
CREATE DATABASE IF NOT EXISTS roomManage;

use roomManage;

drop Table if EXISTS  `Users`;
CREATE TABLE `Users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `email` varchar(356) NOT NULL DEFAULT '' COMMENT 'メール',
  `password` varchar(356) NOT NULL DEFAULT '' COMMENT 'パスワード',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名前',
  `deleted_flg` int(1) DEFAULT NULL COMMENT '削除フラグ',
  `auth` int(1) DEFAULT NULL COMMENT '権限操作',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;


drop Table if EXISTS  `Rooms`;
CREATE TABLE `Rooms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `deleted_flg` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

drop Table if EXISTS  `Reservations`;
CREATE TABLE `Reservations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL COMMENT '開始時間',
  `end_time` datetime NOT NULL COMMENT '終了時間',
  `purpose` varchar(64) NOT NULL COMMENT '目的',
  `kwd` varchar(32) NOT NULL COMMENT '削除キー',
  `deleted_flg` int(1) DEFAULT NULL COMMENT '削除フラグ',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4; 
 ```
