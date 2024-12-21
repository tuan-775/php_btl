-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 03:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

--
-- Dumping data for table `pma__designer_settings`
--

INSERT INTO `pma__designer_settings` (`username`, `settings_data`) VALUES
('root', '{\"relation_lines\":\"true\",\"snap_to_grid\":\"off\",\"angular_direct\":\"direct\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"rabitydb\",\"table\":\"news\"},{\"db\":\"rabitydb\",\"table\":\"product_reviews\"},{\"db\":\"rabitydb\",\"table\":\"feedbacks\"},{\"db\":\"rabitydb\",\"table\":\"order_items\"},{\"db\":\"rabitydb\",\"table\":\"product_subcategories\"},{\"db\":\"rabitydb\",\"table\":\"subcategories\"},{\"db\":\"rabitydb\",\"table\":\"categories\"},{\"db\":\"rabitydb\",\"table\":\"user_profiles\"},{\"db\":\"rabitydb\",\"table\":\"users\"},{\"db\":\"rabitydb\",\"table\":\"security_questions\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-12-20 15:29:45', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `rabitydb`
--
CREATE DATABASE IF NOT EXISTS `rabitydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `rabitydb`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `size` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Bé gái'),
(2, 'Bé trai'),
(3, 'Bộ sưu tập'),
(4, 'New_arrival'),
(5, 'Sale');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','resolved','deleted') DEFAULT 'pending',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) NOT NULL DEFAULT 'Khác'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `created_at`, `image`, `post_date`, `category`) VALUES
(3, 'Top 5 địa điểm bán áo dài trẻ em đẹp nhất', 'Áo dài trẻ em không chỉ là trang phục truyền thống mà còn giúp bé thêm phần rạng rỡ trong các dịp lễ hội. Từ các mẫu áo dài cách tân trẻ em hiện đại đến áo dài trẻ em cao cấp mang vẻ đẹp truyền thống, việc chọn áo dài trẻ em chất lượng luôn là ưu tiên hàng đầu của các bậc phụ huynh. Nếu bạn đang tìm kiếm cửa hàng bán áo dài trẻ em uy tín hoặc muốn biết nơi mua áo dài cho bé trai và bé gái với đa dạng mẫu mã, bài viết này sẽ gợi ý những địa điểm tốt nhất để bạn dễ dàng lựa chọn.\r\n\r\n1. Áo dài trẻ em tại Rabity Kids Fashion\r\nRabity Kids Fashion từ lâu đã trở thành cái tên quen thuộc với ba mẹ đang tìm kiếm áo dài trẻ em đẹp và chất lượng. Với hệ thống trải dài khắp cả nước, Rabity sở hữu hơn 50 cửa hàng, trong đó có khoảng 20 shop bán áo dài trẻ em tại TP.HCM. Rabity có 2 cửa hàng flagship tọa lạc tại các tuyến phố trung tâm là Nguyễn Đình Chiểu và Hai Bà Trưng.\r\n\r\nNgoài ra, Rabity còn mở rộng bán hàng trên các kênh Online như website rabity.vn, Fanpage Rabity Kids Fashion và các sàn thương mại điện tử như Shopee, Tik Tok Shop, với nhiều ưu đãi siêu tốt. Đây là địa chỉ đáng tin cậy để phụ huynh dễ dàng mua áo dài cho bé trai hoặc bé gái với nhiều ưu đãi hấp dẫn.\r\n\r\nRabity luôn cung cấp các mẫu áo dài trẻ em cao cấp, sử dụng chất liệu đạt tiêu chuẩn quốc tế. \r\n\r\nCác thiết kế áo dài trẻ em của Rabity không chỉ mang vẻ đẹp thời thượng mà còn đảm bảo sự thoải mái tối đa cho bé khi vận động. Những mẫu áo dài trẻ em Tết tại đây được cập nhật thường xuyên, phù hợp xu hướng mới nhất, giúp bé thêm phần tự tin và nổi bật trong những ngày lễ hội.\r\n\r\nBa mẹ có thể dễ dàng tìm kiếm địa chỉ bán áo dài trẻ em gần nhất bằng cách truy cập danh sách cửa hàng trên website chính thức.\r\n\r\nChế độ đổi trả hàng cũng rất tuyệt vời và là điểm cộng lớn cho ba mẹ khi mua áo dài trẻ em ở đây, vì có thể yên tâm đổi trả hàng khi hàng lỗi hoặc không vừa size.\r\n\r\nNếu bạn đang tìm kiếm thời trang áo dài trẻ em ngày Tết hoặc bất kỳ dịp đặc biệt nào, Rabity là nơi mang đến những sản phẩm chất lượng, đảm bảo sự hài lòng cho cả bé và ba mẹ.\r\n\r\n', '2024-12-18 17:30:38', 'top_5_dia_diem_ban_ao_dai_tre_em_dep_nhat_1296689f57ae4b6dae3dfb5233d29979.webp', '2024-12-18 17:30:38', 'Mới');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `shipping_method` varchar(50) NOT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Chờ xử lý',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `user_name`, `phone`, `address`, `payment_method`, `shipping_method`, `bank`, `total_price`, `shipping_cost`, `status`, `created_at`) VALUES
(4, 13, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 'bank_transfer', 'standard', 'VCB', 39000.00, 30000.00, 'Chờ xử lý', '2024-12-19 21:12:09'),
(5, 14, 'Nguyễn Đình Tuấn', '12345', 'Thái Bình', 'bank_transfer', 'express', 'VCB', 59000.00, 50000.00, 'Đã nhận', '2024-12-19 21:13:07'),
(6, 14, 'Nguyễn Đình Tuấn', '12345', 'Thái Bình', 'COD', 'standard', '', 672600.00, 30000.00, 'Đã nhận', '2024-12-20 04:02:07'),
(7, 14, 'Nguyễn Đình Tuấn', '12345', 'Thái Bình', 'bank_transfer', 'express', 'MB', 268180.00, 50000.00, 'Chờ xử lý', '2024-12-20 19:53:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(9, 6, 35, 'Áo thun ngắn tay bé trai Rabity x ELLE Kids - designed in Paris', 141750.00, 2),
(10, 6, 34, 'Đầm váy voan dài tay bé gái Rabity x ELLE Kids - designed in Paris', 359100.00, 1),
(11, 7, 43, '[Độc quyền Online] Quần short thun bé trai', 99500.00, 1),
(12, 7, 42, '[Độc quyền Online] Quần legging dài thun bé gái Rabity', 118680.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sale_percentage` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT 50,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sold_quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `name`, `image`, `description`, `price`, `created_at`, `sale_percentage`, `stock`, `cost_price`, `sale_price`, `sold_quantity`) VALUES
(34, '002', 'Đầm váy voan dài tay bé gái Rabity x ELLE Kids - designed in Paris', 'dsc09403_copy_358b2ff0fb154ed0a4277de72c7940bf.webp', 'Sản phẩm đến từ BST hợp tác quốc tế được thiết kế tại Paris​ với bản quyền từ ELLE – biểu tượng thời trang nước Pháp với phong cách thời thượng, thanh lịch, tinh tế với những kiểu dáng đang thịnh hành tại Paris.​ Chất liệu cao cấp được may đo tỉ mỉ từng đường kim mũi chỉ.​​ ', 399000.00, '2024-12-20 02:59:38', 10, 99, 300000.00, NULL, 1),
(35, '001', 'Áo thun ngắn tay bé trai Rabity x ELLE Kids - designed in Paris', 'dsc09761_copy_63b38c87c3f34b65a51e8663c5f602be.webp', 'Sản phẩm đến từ BST hợp tác quốc tế được thiết kế tại Paris​ với bản quyền từ ELLE – biểu tượng thời trang nước Pháp với phong cách thời thượng, thanh lịch, tinh tế với những kiểu dáng đang thịnh hành tại Paris.​ Chất liệu cao cấp được may đo tỉ mỉ từng đường kim mũi chỉ.​​', 189000.00, '2024-12-20 03:06:06', 25, 98, 120000.00, NULL, 2),
(36, '003', '[Độc quyền Online] Đầm váy thun mèo xinh ngắn tay bé gái Rabity', 'btt_9061_5da6b29e7d0d474b9045e4cda94b4d08.webp', 'Đầm váy là là một outfits không thể thiếu trong tủ đồ của các cô công chúa nhỏ giúp ba mẹ tiết kiệm thời gian trong việc lựa chọn cho bé mỗi ngày mà bé có thể mặc trong nhiều dịp khác nhau như như đi chơi, đi học, đi tiệc,...\r\n\r\n1. Đặc điểm nổi bật Đầm váy thun mèo xinh ngắn tay bé gái Rabity 950.049\r\nNhóm sản phẩm: Đầm váy bé gái, Đầm váy ngắn tay bé gái\r\nChất liệu: 95% cotton 5% spandex an toàn và thoáng mát cho da của bé\r\nSize: Phù hợp với bé gái cân nặng từ 14 - 31kg, từ 4 - 10 tuổi\r\nHình in mèo sắc nét, đáng yêu luôn được các bé gái yêu thích.\r\n2. Chất liệu Đầm váy thun mèo xinh ngắn tay bé gái Rabity 950.049\r\nĐầm váy thun ngắn tay bé gái kiểu dáng điệu đà, màu sắc hồng, xanh đáng yêu cho các bé có thể mặc đi học, đi tiệc hoặc đi chơi cuối tuần. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 199000.00, '2024-12-20 18:59:12', 30, 100, 100000.00, NULL, 0),
(37, '004', 'Đồ bộ thun Spider-Man dài tay bé trai Rabity', 'dsc01123_copy_55756ae2c80d42388b88931bb8bd19e2.webp', 'Thời tiết thay đổi liên tục, những ngày lạnh hay nhiệt độ thấp vào ban đêm, đồ bộ dài tay cho bé là cứu tinh lúc này. Chất nỉ được dệt từ sợi cotton co giãn thoải mái, bé mặc thích thú cả ngày.\r\n\r\n1. Đặc điểm nổi bật Đồ bộ thun Spider-Man dài tay bé trai Rabity 561.001\r\nChất liệu: Với thiết kế 95% vải cotton và 5% vải spandex nhẹ thoáng, êm mịn và an toàn cho làn da bé.\r\nĐộ tuổi, cân nặng: phù hợp cho bé từ 4 - 8 tuổi, từ 14 - 25kg.\r\nLoại sản phẩm: Đồ bộ bé trai, đồ bộ dài tay bé trai\r\nÁo tay dài quần dài, có bo tay và bo chân, họa tiết Spider-Man bản quyền Marvel.\r\n2. Thông tin chi tiết Đồ bộ thun Spider-Man dài tay bé trai Rabity 561.001\r\nBộ thun dài tay bé trai form vừa vặn thoải mái. Kiểu dáng dễ phối nhiều outfit cho bé diện đi học hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 329000.00, '2024-12-20 19:03:14', 8, 100, 250000.00, NULL, 0),
(38, '006', '[Độc quyền Online] Áo thun ngắn tay Spider-Man bé trai Rabity', '500065240-0_5138a384cb6d48729794af1f2ffd907c.webp', 'Áo thun tay ngắn bé trai thoải mái dễ phối đồ cho các bé có thể mặc ở nhà, đi chơi, kiểu dáng đơn giản, dễ dàng cho bé diện đồ đi học, xuống phố cuối tuần.\r\n\r\n1. Thông tin Áo thun ngắn tay Spider-Man bé trai Rabity 500.065\r\nChất liệu: Với thiết kế 95% vải cotton và 5% spandex, an toàn và thoáng mát cho da\r\nĐộ tuổi, cân nặng: phù hợp cho bé từ 4 - 12 tuổi, từ 14 - 35kg\r\nLoại sản phẩm: Áo bé trai, áo thun ngắn tay bé trai \r\nHọa tiết Spider-man bản quyền Disney, hình in có chiều sâu và sắc nét.\r\n \r\n\r\n2. Thông tin chi tiết Áo thun ngắn tay Spider-Man bé trai Rabity 500.065\r\nÁo thun bé trai ngắn tay Spider-man bản quyền Disney mang lại cảm giác thoải mái, dễ chịu cho bé khi tham gia các hoạt động học tập, vui chơi suốt ngày dài, Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 169000.00, '2024-12-20 19:06:05', 8, 100, 120000.00, NULL, 0),
(39, '005', 'Áo thun ngắn tay bé gái', '8_copy_f228e4a83e964a92ac3268992790fdf9.webp', 'Áo thun là một outfits tiện lợi cho mẹ và bé, với kiểu dáng áo thun cá tính, năng động sẽ giúp bé thoải mái vận động. Ba mẹ có thể phối cho bé áo thun với những quần khác nhau như quần nỉ, quần dài, quần thun,... cho bé mặc nhiều dịp đi học, đi chơi, đi học, đi tiệc,...\r\n\r\n1. Đặc điểm nổi bật Áo thun ngắn tay bé gái 900.076\r\n- Chất liệu 100% vải cotton xước thông thoáng, mát mẻ và an toàn cho làn da của bé Cotton\r\n\r\n- Loại sản phẩm: Áo bé gái, Áo thun bé gái\r\n\r\n- Phù hợp với bé gái cân nặng từ 11 - 35kg, từ 2 - 12 tuổi\r\n\r\n- Áo thun ngắn tay in hình trái dưa hấu dễ thương, năng động và sắc nét.\r\n\r\n2. Thông tin chi tiết Áo thun ngắn tay bé gái 900.076\r\nÁo thun ngắn tay bé gái form vừa vặn thoải mái. Kiểu dáng dễ phối nhiều outfit lịch sự cho bé diện đi học, đi tiệc hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.\r\n\r\n', 199000.00, '2024-12-20 19:10:04', 50, 100, 100000.00, NULL, 0),
(40, '007', 'Đồ bộ thun ngắn tay Kuromi bé gái Rabity', '960020241-1_8897662d408340e6b8c6c0cc6ebf5788.jpg', 'Đồ bộ thun bé gái có kiểu dáng thời trang, cá tính, tính ứng dụng cao ngoài mặc ở nhà thì ba mẹ có thể cho bé mặc vào nhiều dịp khác như đi học, đi chơi, xuống phố,...\r\n\r\n\r\n1. Đặc điểm nổi bật Bộ thun ngắn tay Kuromi bé gái Rabity 960.020\r\n- Nhóm sản phẩm: Đồ bộ ngắn tay bé gái, Đồ bộ bé gái\r\n\r\n- Chất liệu 95% cotton và 5% spandex thoáng mát, co giãn và an toàn cho làn da của bé\r\n\r\n- Phù hợp với bé gái cân nặng từ 14 - 40kg, từ 4 - 14 tuổi\r\n\r\n- Đồ bộ thun ngắn tay in hình Kuromi, hình in to sắc nét, đáng yêu và màu sắc hài hòa\r\n\r\n \r\n\r\n2. Thông tin chi tiết Bộ thun ngắn tay Kuromi bé gái Rabity 960.020\r\nBộ thun bé gái ngắn tay Kuromi đáng yêu, năng động. Kiểu dáng dễ phối nhiều outfits khác nhau cho bé diện đi học, đi tiệc hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 299000.00, '2024-12-20 19:23:41', 8, 100, 220000.00, NULL, 0),
(41, '008', 'Mũ lưỡi trai bé trai/bé gái Rabity', '971003243-2_be1a3e5d41dd466cae160ca4eca80176.webp', 'Freesize', 169000.00, '2024-12-20 19:28:18', 0, 100, 100000.00, NULL, 0),
(42, '009', '[Độc quyền Online] Quần legging dài thun bé gái Rabity', '943003-2_6684030caa4642878a8c9e7342dda174.webp', 'Quần dài legging là một kiểu quần rất tiện lợi nên thường được ba mẹ lựa chọn khi mua sắm quần áo cho bé gái, với những chiếc quần legging bạn có thể phối với đa dạng mẫu áo khác nhau như áo thun tay ngắn, áo sát nách, áo sơ mi,... để mặc đi học, đi chơi hoặc đi tiệc.\r\n\r\n1. Đặc điểm nổi bật Quần legging dài thun bé gái Rabity 943.003\r\nNhóm sản phẩm: Quần bé gái, Quần dài bé gái\r\nChất liệu: 95% cotton 5% spandex thấm hút mồ hôi, an toàn và thoáng mát cho da của bé\r\nSize: Phù hợp với bé gái cân nặng từ 11 - 35kg, từ 2 - 12 tuổi\r\n2. Chất liệu Quần legging dài thun bé gái Rabity 943.003\r\nQuần dài legging bé gái kiểu dáng sành điệu, màu sắc dễ phối đồ đa dạng outfits cho các bé có thể mặc đi học hoặc đi chơi cuối tuần. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 129000.00, '2024-12-20 19:31:09', 8, 99, 80000.00, NULL, 1),
(43, '010', '[Độc quyền Online] Quần short thun bé trai', '933009240-0_3d42c0eb1e6a49f3b874fa561ccc6b39.webp', 'Nội dung đang được cập nhật', 199000.00, '2024-12-20 19:33:31', 50, 99, 50000.00, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(80, 34, '17_4_e501794695144cf097c7c90e5fd8e2a9.webp'),
(81, 34, '17_copy_741005b7ddc744fd854c3f59c9625eae.webp'),
(82, 34, '17-2_bb86c1368ce94f7f8cb5dac352eed20a.webp'),
(83, 34, '17-3_1ce6f431a8d9478fba855f6994b9d91d_medium.webp'),
(84, 35, '28_4_dbab82b738bc4ecba5afa811da751ddc.jpg'),
(85, 35, '28_copy_7ee9076bfb354d5d8443dc095429d75a.webp'),
(86, 35, '28-2_b9277719f8c64f91988ac4c7724fc424.webp'),
(87, 35, '28-3_e386421cdb0d465ebf7e220938f841ce.webp'),
(88, 36, '950049241-3_d1f2b2547dde45d3bd353f94153a8776.webp'),
(89, 36, 'btt_9043_155071d2f8df441688cd7198b268db88.webp'),
(90, 36, 'btt_9069_fbc2f43a75c94bfda66f247a00e21013 (1).webp'),
(91, 36, 'btt_9069_fbc2f43a75c94bfda66f247a00e21013.webp'),
(92, 37, '561001240-3_d0cabd4ade3e44348b7face22fd02285.webp'),
(93, 37, 'dsc01123_copy_55756ae2c80d42388b88931bb8bd19e2.webp'),
(94, 37, 'dsc01135_copy_42352c02fb81467c92f9fe4f67be67f5.webp'),
(95, 38, '500065240-1_a9d9f0364505404cadac56d7b23be1d9.webp'),
(96, 38, '500065240-3_e602eb02de224e16ae331e3ea245ad45.webp'),
(97, 38, 'spider_caa0eb8d0477453888fb710d2843faa7.webp'),
(98, 39, '7_copy_1c5f5e4c07aa4331864d1e27423e2230.webp'),
(99, 39, '8_1_03cede1fa1f74475be214d7682e870f2.jpg'),
(100, 39, '8_2_c8735a58555143f694c7886a8972ea18.jpg'),
(101, 40, '960020241-0_a1610a8aa633461282b864c72afdef6f.webp'),
(102, 40, '960020241-1_0393c37c6e6b4566b117278247c1f62f.webp'),
(103, 40, '960020241-5_a1e3cd15c1dd408ba104ff0780866ec6.webp'),
(104, 40, '960020241-6_bb7bc0fa30c0418c847686767fa13881.webp'),
(105, 41, '971003243-0_ae199332f7624a4e93eb87fde0bbc9ca.webp'),
(106, 41, '971003243-4_f3a24a3762f247e4827f3d2b34eab5ce.webp'),
(107, 41, '971003243-7_398d665cef9c4c159593c48c669d2029.webp'),
(108, 41, '971003243-8_55243bc0825645d8b11bb931a100f408.webp'),
(109, 42, '943003-1_50ff2fd789224d68bfbd5b674735ab3c.webp'),
(110, 42, '943003-3_0927d31dd9e8414484f83e7a45fc3391.webp'),
(111, 43, '933009240-1_f937976f8e844ce6bcb719b6b42fbb12.webp'),
(112, 43, '933009240-6_a463f931f34942c2838b3600b038ddfa.webp'),
(113, 43, 'dsc00149_copy_d666e11a00f14863adabb6ea608de4fc.webp'),
(114, 43, 'dsc00178_copy_8945c5dd7d47407a8bc7f6ac2b4e0b3c.webp');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `order_id`, `product_id`, `user_id`, `rating`, `review`, `created_at`) VALUES
(6, 6, 35, 14, 1, '123', '2024-12-20 04:03:14'),
(7, 6, 34, 14, 1, '123', '2024-12-20 04:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategories`
--

CREATE TABLE `product_subcategories` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_subcategories`
--

INSERT INTO `product_subcategories` (`id`, `product_id`, `subcategory_id`) VALUES
(35, 36, 11),
(36, 36, 3),
(37, 36, 4),
(38, 36, 14),
(39, 35, 2),
(40, 35, 3),
(41, 35, 9),
(42, 35, 10),
(43, 37, 21),
(44, 37, 22),
(45, 37, 9),
(46, 37, 19),
(47, 37, 10),
(52, 39, 1),
(53, 39, 17),
(54, 39, 4),
(55, 39, 14),
(56, 34, 11),
(57, 34, 3),
(58, 34, 4),
(63, 40, 20),
(64, 40, 17),
(65, 40, 4),
(66, 38, 2),
(67, 38, 22),
(68, 38, 9),
(69, 38, 19),
(70, 41, 15),
(71, 41, 16),
(72, 41, 8),
(73, 42, 6),
(74, 42, 12),
(75, 42, 19),
(76, 43, 7),
(77, 43, 9),
(78, 43, 10);

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE `security_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `security_questions`
--

INSERT INTO `security_questions` (`id`, `user_id`, `question`, `answer`) VALUES
(3, 13, 'Tên tôi là gì?', '$2y$10$EtOIYMA8by4ychNE6ML5BOsbHKtEOGs02tXxCfn1WhCYzVYXko8GC'),
(4, 14, '123?', '$2y$10$QFMXcak/RepLQpA.eUEgaefwpuYvY.W5fYyGFloVaDz74.Yp9JTkq'),
(5, 15, '1234?', '$2y$10$mqdcR2nnop30BfUwEJJepOZoyJKSde9rRus3XEwzJzFYR9nOuTgVO');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`) VALUES
(1, 'Áo', 1),
(2, 'Áo', 2),
(3, 'BST ELLE Kids x Rabity', 3),
(4, 'New Arrival Bé gái', 4),
(6, 'Quần', 1),
(7, 'Quần', 2),
(8, 'BST Đồ Đi Chơi Noel', 3),
(9, 'New Arrival Bé trai', 4),
(10, 'Sale bé trai', 5),
(11, 'Đầm váy', 1),
(12, 'BST Thu Đông 2024', 3),
(14, 'Sale bé gái', 5),
(15, 'Phụ kiện', 1),
(16, 'Phụ kiện', 2),
(17, 'BST Đồ Bộ Mặc Nhà', 3),
(19, 'Flashsale đồ Tết mới', 5),
(20, 'Đồ bộ', 1),
(21, 'Đồ bộ', 2),
(22, 'BST Disney - Friends', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(13, 'Nguyễn Đình Tuấn', 'admin', 'tuan1@zz.zz', '$2y$10$7H9i7CLqWwPSzoY4Rge82.K6nOTdm.g3mCuyCwz8lSAVyIcxCOJ6a', 'admin', '2024-12-17 11:55:18'),
(14, 'abc', 'tuan1', 'Farmx12@zz.zz', '$2y$10$TZ3BN9EXxP7S1viGpjLT0ei5vLGaIYU41buu0Y0d2h8axWMdcqHOW', 'user', '2024-12-17 13:22:03'),
(15, 'asd', 'tuan2', '123@zz.zz', '$2y$10$E4dvutvkMXyP2oxBQ/UeZO.QNBV1bWkgj88LZ8tWNf8cb4m7Whoh2', 'user', '2024-12-17 14:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `gender`, `birthdate`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(12, 14, 'Nữ', '0000-00-00', '', '', '2024-12-17 13:50:28', '2024-12-17 13:51:24'),
(13, 14, 'Nữ', '0000-00-00', '', '', '2024-12-17 13:50:52', '2024-12-17 13:51:24'),
(14, 14, '', '0000-00-00', '', '', '2024-12-17 13:51:45', '2024-12-17 13:51:45'),
(15, 15, 'Nữ', '2222-02-22', '', '', '2024-12-17 14:09:19', '2024-12-17 14:15:20'),
(16, 15, 'Nữ', '2222-02-22', '', '', '2024-12-17 14:11:43', '2024-12-17 14:15:20'),
(17, 15, 'Nữ', '2222-02-22', '', '', '2024-12-17 14:12:59', '2024-12-17 14:15:20'),
(18, 15, 'Nam', '2222-02-22', '', '', '2024-12-17 14:15:38', '2024-12-17 14:15:38'),
(19, 15, 'Nam', '1111-11-11', '', '', '2024-12-17 14:25:27', '2024-12-17 14:25:27'),
(20, 15, 'Nữ', '2222-02-22', '', '', '2024-12-17 14:27:58', '2024-12-17 14:27:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_orders` (`order_id`),
  ADD KEY `fk_reviews_products` (`product_id`),
  ADD KEY `fk_reviews_users` (`user_id`);

--
-- Indexes for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CategoryID` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `fk_reviews_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD CONSTRAINT `product_subcategories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_subcategories_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD CONSTRAINT `security_questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
