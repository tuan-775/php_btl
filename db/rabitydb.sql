-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 05:47 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(5, 1, 4, 1, '2024-11-24 16:52:57'),
(6, 1, 6, 1, '2024-11-24 16:57:27'),
(9, 0, 5, 1, '2024-11-24 17:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_name`, `phone`, `address`, `product_id`, `product_name`, `price`, `quantity`, `created_at`) VALUES
(1, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 4, 'Chia sẻ Áo thun ngắn tay bé gái', 1510325.00, 1, '2024-11-24 16:51:38'),
(2, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 5, 'Đồ bộ thun tăm dài tay bé gái Rabity', 99999999.99, 1, '2024-11-24 17:55:23'),
(3, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 6, 'Mũ lưỡi trai bé trai', 99999999.99, 1, '2024-11-24 17:55:59');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `category`, `category_name`, `name`, `image`, `description`, `price`, `created_at`) VALUES
(1, '001', 'Bé trai', 'Áo', 'Áo thun tay dài', '../uploads/Screenshot 2024-11-23 182543.png', 'Nội dung đang được cập nhật', 10000000.00, '2024-11-24 14:56:38'),
(2, '002', 'Bé trai', 'Đồ bộ', 'Bộ đồ thun ngắn tay', '../uploads/Screenshot 2024-11-23 182601.png', 'Mô tả sản phẩm\r\nĐồ bộ thun bé trai sẽ là outfits tiện lợi cho mẹ và bé, với kiểu dáng áo thun, quần short cá tính, năng động giúp bé thoải mái vận động. Với những mẫu đồ bộ tính dụng cao bé có thể mặc mặc ở nhà, đi học, đi chơi,... \r\n\r\n1. Thông tin Bộ thun ngắn tay Mickey bé trai Rabity 560.001\r\n- Chất liệu 95% vải cotton và 5% spandex thoáng mát, co giãn và an toàn cho làn da của bé\r\n\r\n- Loại sản phẩm: Đồ bộ bé trai\r\n\r\n- Phù hợp với bé trai cân nặng từ 11-21kg, từ 2-6 tuổi\r\n\r\n- Bộ thun ngắn tay in hình Mickey bản quyền Disney, hình in sắc nét và màu sắc hài hòa\r\n\r\n \r\n\r\n2. Thông tin chi tiết Bộ thun ngắn tay Mickey bé trai Rabity 560.001\r\nBộ thun ngắn tay bé trai form vừa vặn thoải mái. Kiểu dáng dễ phối nhiều outfit lịch sự cho bé diện đi học, đi tiệc hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 120000.00, '2024-11-24 15:11:40'),
(3, '003', 'Bé gái', 'Đầm váy', 'Đầm váy thô cổ sen ngắn tay bé gái', '../uploads/Screenshot 2024-11-23 183607.png', 'Đầm váy thô cổ sen ngắn tay bé gái Rabity 93113\r\n1. Thông tin Đầm váy thô cổ sen ngắn tay bé gái Rabity 93113\r\n- Chất liệu 100% thoáng mát, mềm mịn dễ chịu\r\n\r\n- Loại sản phẩm: Đầm váy bé gái\r\n\r\n- Phù hợp với bé gái cân nặng từ 11-30kg, từ 2-10 tuổi\r\n\r\n- Đầm thô ngắn tay họa tiết hoa đáng yêu, màu sắc nổi bật, thời trang cho bé diện thật nổi bật.', 1500000.00, '2024-11-24 15:13:08'),
(4, '004', 'Bé gái', 'Áo', 'Chia sẻ Áo thun ngắn tay bé gái', '../uploads/Screenshot 2024-11-24 221346.png', 'Áo thun là một outfits tiện lợi cho mẹ và bé, với kiểu dáng áo thun cá tính, năng động sẽ giúp bé thoải mái vận động. Ba mẹ có thể phối cho bé áo thun với những quần khác nhau như quần nỉ, quần dài, quần thun,... cho bé mặc nhiều dịp đi học, đi chơi, đi học, đi tiệc,...\r\n\r\n1. Đặc điểm nổi bật Áo thun ngắn tay bé gái 900.076\r\n- Chất liệu 100% vải cotton xước thông thoáng, mát mẻ và an toàn cho làn da của bé Cotton\r\n\r\n- Loại sản phẩm: Áo bé gái, Áo thun bé gái\r\n\r\n- Phù hợp với bé gái cân nặng từ 11 - 35kg, từ 2 - 12 tuổi\r\n\r\n- Áo thun ngắn tay in hình trái dưa hấu dễ thương, năng động và sắc nét.\r\n\r\n2. Thông tin chi tiết Áo thun ngắn tay bé gái 900.076\r\nÁo thun ngắn tay bé gái form vừa vặn thoải mái. Kiểu dáng dễ phối nhiều outfit lịch sự cho bé diện đi học, đi tiệc hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 1510325.00, '2024-11-24 15:14:17'),
(5, '005', 'Bé gái', 'Đồ bộ', 'Đồ bộ thun tăm dài tay bé gái Rabity', '../uploads/Screenshot 2024-11-24 221446.png', 'Thời tiết thay đổi liên tục, những ngày lạnh hay nhiệt độ thấp vào ban đêm, đồ bộ dài tay cho bé là cứu tinh lúc này. Chất thun tăm được dệt từ sợi cotton co giãn thoải mái, bé mặc thích thú cả ngày.\r\n\r\n1. Đặc điểm nổi bật Đồ bộ thun tăm dài tay bé gái Rabity 961.001\r\nChất liệu: Với thiết kế 100% vải cotton nhẹ thoáng, êm mịn và an toàn cho làn da bé.\r\nĐộ tuổi, cân nặng: phù hợp cho bé từ 2 - 6 tuổi, từ 11-21kg.\r\nLoại sản phẩm: Đồ bộ bé gái, đồ bộ dài tay bé gái.\r\nÁo tay dài quần dài, họa tiết bông hoa nhỏ xinh xắn.\r\n2. Thông tin chi tiết Đồ bộ thun tăm dài tay bé gái Rabity 961.001\r\nBộ thun tăm dài tay bé gái kiểu dáng điệu đà, màu sắc hồng nhạt, vàng nhạt dịu dàng cho các bé gái. Sản phẩm thích hợp cho bé mặc trong mùa thu đông hoặc khi thời tiết lạnh, mang đến cảm giác ấm áp và thoải mái khi mặc.', 99999999.99, '2024-11-24 15:15:08'),
(6, '006', 'Bé trai', 'Phụ kiện', 'Mũ lưỡi trai bé trai', '../uploads/Screenshot 2024-11-24 221544.png', 'Freesize', 99999999.99, '2024-11-24 15:16:11'),
(7, '007', 'Bé gái', 'Áo', 'Áo thun dài tay bé gái Rabity', '../uploads/Screenshot 2024-11-26 125423.png', 'Nội dung đang được cập nhật', 123123.00, '2024-11-26 05:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'tuan1', 'xmeosadx@gmail.com', '$2y$10$wBv9.3dOkSV/sjzfc8uHFuSNVQe5ymYcEqHC57O7miQtAa43YqAmi', 'user', '2024-11-24 13:34:32'),
(2, 'admin', 'xmeo2612x@gmail.com', '$2y$10$.STfEayHecZFksdKU.OAIup92zbneMWwJ1goW.r0DetqvFxLVJ1fG', 'admin', '2024-11-24 13:56:47');

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
