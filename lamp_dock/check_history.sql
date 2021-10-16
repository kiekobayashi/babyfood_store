-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 10 月 16 日 13:34
-- サーバのバージョン： 5.7.35
-- PHP のバージョン: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `img`, `status`, `stock`, `age`, `comment`, `createdate`, `updatedate`) VALUES
(9, 'りんごとバナナ', 300, 'b289cac09d8915a61de9401249ec0db1ef49eea7.jpg', 1, 49, 0, 'りんご：青森県産　バナナ：岡山県産', '2021-07-29 14:05:45', '2021-10-16 15:15:29'),
(10, 'りんごとブルーベリー', 300, '5b9cddc113a30bfa3270fb304a1d2218c80afa1d.jpg', 0, 38, 0, 'りんご：青森県産　ブルーベリー：愛媛県産', '2021-07-29 14:06:20', '2021-07-29 22:58:36'),
(11, 'りんごとブルーベリー', 320, '3b6d344b489682fb8ebfaacee37624ea61b36d60.jpg', 1, 17, 2, 'りんご：青森県産　ブルーベリー：愛媛県産', '2021-07-29 14:06:54', '2021-10-16 15:44:21'),
(12, 'バナナと紫芋とベリー', 310, 'b02a09f9d7446288607db9bb2b747a0eaa2ab967.jpg', 1, 9, 1, 'バナナ：岡山県産　紫芋：沖縄県産　ブルーベリー：愛媛県産', '2021-07-29 14:08:17', '2021-10-16 15:44:21'),
(13, 'バナナとりんごとキャベツ', 300, 'e64bd9f146d990292562f391d6a29ff9a36d70cd.jpg', 1, 50, 0, 'バナナ：岡山県産　りんご：青森県産　キャベツ：群馬県産', '2021-07-29 14:09:31', '2021-07-29 14:23:04'),
(14, '根菜と穀物', 350, '911ac7b407e272946efa62395e8c23a8034172d3.jpg', 1, 4, 1, '根菜：大阪県産ほか　穀物：北海道産', '2021-07-29 14:11:07', '2021-07-29 22:30:28'),
(15, 'バナナとベリーのスナック', 200, 'd9851b35d229eec94de4323155182ede11480bc3.jpg', 1, 8, 2, 'バナナ：岡山県産　ブルーベリー：愛媛県産', '2021-07-29 14:12:11', '2021-10-16 15:50:48'),
(16, 'トマトとベリーとマンゴー', 320, '8073543172c1ef81ba67619423c2b49ee2dc4600.jpg', 1, 0, 2, 'トマト：北海道産　ブルーベリー：愛媛県産　マンゴー：宮崎県産', '2021-07-29 14:13:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `created`) VALUES
(1, 4, '2021-10-16 15:10:39'),
(2, 4, '2021-10-16 15:15:29'),
(3, 4, '2021-10-16 15:15:29'),
(4, 4, '2021-10-16 15:44:21'),
(5, 4, '2021-10-16 15:44:21'),
(6, 3, '2021-10-16 15:50:48'),
(7, 3, '2021-10-16 15:50:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `item_id`, `price`, `amount`) VALUES
(1, 1, 11, 320, 5),
(2, 2, 12, 310, 1),
(3, 2, 9, 300, 1),
(4, 3, 12, 310, 1),
(5, 3, 9, 300, 1),
(6, 4, 12, 310, 5),
(7, 4, 11, 320, 3),
(8, 5, 12, 310, 5),
(9, 5, 11, 320, 3),
(10, 6, 15, 200, 10),
(11, 7, 15, 200, 10);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `type` int(11) NOT NULL,
  `password` varchar(20) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `type`, `password`, `createdate`, `updatedate`) VALUES
(1, 'testtest', 2, 'testtest', '2021-07-09 10:07:18', '2021-10-12 14:27:26'),
(2, '123456', 2, '123456', '2021-07-11 22:35:31', '2021-10-12 14:27:29'),
(3, 'test01', 2, 'test01', '2021-07-16 22:20:04', '2021-10-12 14:27:32'),
(4, 'test123', 2, 'test123', '2021-07-29 14:30:51', '2021-10-12 14:27:36'),
(5, 'aaaaaa', 2, 'aaaaaa', '2021-07-29 22:09:28', '2021-10-12 14:27:38'),
(7, 'admin', 1, 'admin', '2021-10-09 22:25:13', '2021-10-12 14:28:02');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- テーブルのインデックス `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;