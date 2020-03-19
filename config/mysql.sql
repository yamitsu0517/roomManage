CREATE DATABASE [IF NOT EXISTS] roomManage;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNI` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

drop Table if EXISTS  `Reservations`;
CREATE TABLE `Reservations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL COMMENT '開始時間',
  `end_time` datetime NOT NULL COMMENT '終了時間',
  `purpose` varchar(64) DEFAULT NULL COMMENT '目的',
  `kwd` varchar(32) DEFAULT NULL COMMENT '削除キー',
  `deleted_flg` int(1) DEFAULT NULL COMMENT '削除フラグ',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;