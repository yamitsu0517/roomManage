# 部屋管理アプリ


## 目的
社員が部屋を自由に使えることにより、人間力・スキルアップ

## 行えること
1. ログイン機能
2. 日付指定
3. 使う部屋・時間指定  
4. 部屋追加（管理者権限）

## 行い方
0. 下記テーブルを登録する。
1. XXX/roommanage にアクセスする（roomManage/users/login ）
2. アカウント登録 -> ログイン(最初の登録ユーザの場合管理者権限が付与される)
3. (初期設定)上にあるタブ部屋管理-部屋一覧を選択し、部屋を登録(登録次第、ホームに戻る)
4. 任意の日付を選択(4/14 etc)
5. フォームに記入しボタン押下（登録）


## これからの発展（課題）
1. カレンダーの拡張  
2. 管理者権限の拡張(現時点ではフラグなのでその書き方を変更。ex. 数字増やす, ` 1 1 1` のように書く etc.)
3. SP版の拡張（画面表示分け）
4. CSS の修正
5. 設定ファイルのテーブル化

## データベース(MySQL)
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
