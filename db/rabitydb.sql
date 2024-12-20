-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 04:22 AM
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
-- Database: `rabitydb`
--

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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `size`) VALUES
(105, 14, 35, 1, '2024-12-20 03:14:35', '4Y');

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
(5, 14, 'Nguyễn Đình Tuấn', '12345', 'Thái Bình', 'bank_transfer', 'express', 'VCB', 59000.00, 50000.00, 'Đã nhận', '2024-12-19 21:13:07');

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
(34, '002', 'Đầm váy voan dài tay bé gái Rabity x ELLE Kids - designed in Paris', 'dsc09403_copy_358b2ff0fb154ed0a4277de72c7940bf.webp', 'Sản phẩm đến từ BST hợp tác quốc tế được thiết kế tại Paris​ với bản quyền từ ELLE – biểu tượng thời trang nước Pháp với phong cách thời thượng, thanh lịch, tinh tế với những kiểu dáng đang thịnh hành tại Paris.​ Chất liệu cao cấp được may đo tỉ mỉ từng đường kim mũi chỉ.​​ ', 399000.00, '2024-12-20 02:59:38', 10, 100, 300000.00, NULL, 0),
(35, '001', 'Áo thun ngắn tay bé trai Rabity x ELLE Kids - designed in Paris', 'dsc09761_copy_63b38c87c3f34b65a51e8663c5f602be.webp', 'Sản phẩm đến từ BST hợp tác quốc tế được thiết kế tại Paris​ với bản quyền từ ELLE – biểu tượng thời trang nước Pháp với phong cách thời thượng, thanh lịch, tinh tế với những kiểu dáng đang thịnh hành tại Paris.​ Chất liệu cao cấp được may đo tỉ mỉ từng đường kim mũi chỉ.​​', 189000.00, '2024-12-20 03:06:06', 25, 100, 120000.00, NULL, 0);

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
(87, 35, '28-3_e386421cdb0d465ebf7e220938f841ce.webp');

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
(23, 34, 11),
(24, 34, 3),
(25, 34, 4),
(26, 35, 2),
(27, 35, 3),
(28, 35, 9),
(29, 35, 10);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
