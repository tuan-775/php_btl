-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 14, 2024 lúc 06:33 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `rabitydb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
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
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `size`) VALUES
(9, 0, 5, 1, '2024-11-24 17:57:28', NULL),
(89, 5, 2, 1, '2024-12-14 10:27:35', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
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
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(20) NOT NULL,
  `shipping_method` varchar(50) DEFAULT NULL,
  `shipping_cost` float DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_name`, `phone`, `address`, `product_id`, `product_name`, `price`, `quantity`, `total_price`, `created_at`, `payment_method`, `shipping_method`, `shipping_cost`, `bank`, `user_id`) VALUES
(1, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 4, 'Chia sẻ Áo thun ngắn tay bé gái', 1510325.00, 1, NULL, '2024-11-24 16:51:38', '', NULL, NULL, NULL, 1),
(2, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 5, 'Đồ bộ thun tăm dài tay bé gái Rabity', 99999999.99, 1, NULL, '2024-11-24 17:55:23', '', NULL, NULL, NULL, 1),
(3, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 6, 'Mũ lưỡi trai bé trai', 99999999.99, 1, NULL, '2024-11-24 17:55:59', '', NULL, NULL, NULL, 1),
(4, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 4, 'Chia sẻ Áo thun ngắn tay bé gái', 1510325.00, 1, NULL, '2024-11-26 16:54:54', '', NULL, NULL, NULL, 1),
(5, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 6, 'Mũ lưỡi trai bé trai', 99999999.99, 1, NULL, '2024-11-26 16:54:54', '', NULL, NULL, NULL, 1),
(6, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-03 17:59:47', '', NULL, NULL, NULL, 1),
(7, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:12:21', 'cash', NULL, NULL, NULL, 1),
(8, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:12:45', 'qr', NULL, NULL, NULL, 1),
(9, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:13:27', 'qr', NULL, NULL, NULL, 1),
(10, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:18:30', 'qr', NULL, NULL, NULL, 1),
(11, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:26:12', 'qr', NULL, NULL, NULL, 1),
(12, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:32:02', 'qr', NULL, NULL, NULL, 1),
(13, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 3, 'Đầm váy thô cổ sen ngắn tay bé gái', 1500000.00, 1, NULL, '2024-12-05 05:35:23', 'qr', NULL, NULL, NULL, 1),
(14, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:35:45', 'qr', NULL, NULL, NULL, 1),
(15, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:39:12', 'qr', NULL, NULL, NULL, 1),
(16, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:40:39', 'cash', NULL, NULL, NULL, 1),
(17, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:41:00', 'qr', NULL, NULL, NULL, 1),
(18, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:44:26', 'qr', NULL, NULL, NULL, 1),
(19, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:45:25', 'qr', NULL, NULL, NULL, 1),
(20, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:49:42', 'qr', NULL, NULL, NULL, 1),
(21, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 05:50:30', 'qr', NULL, NULL, NULL, 1),
(22, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 3, 'Đầm váy thô cổ sen ngắn tay bé gái', 1500000.00, 1, NULL, '2024-12-05 06:36:24', 'qr', NULL, NULL, NULL, 1),
(23, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 2, NULL, '2024-12-05 06:36:24', 'qr', NULL, NULL, NULL, 1),
(24, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 111111.00, 1, NULL, '2024-12-05 07:08:51', 'cash', NULL, NULL, NULL, 1),
(25, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 111111.00, 5, NULL, '2024-12-05 07:10:28', 'cash', NULL, NULL, NULL, 1),
(26, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 111111.00, 1, 111111.00, '2024-12-05 07:15:31', 'cash', NULL, NULL, NULL, 1),
(27, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 100000.00, 1, 100000.00, '2024-12-05 08:58:59', 'cash', 'postal', 30000, NULL, 1),
(28, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 100000.00, 1, 90000.00, '2024-12-05 09:32:41', 'cash', NULL, NULL, NULL, 1),
(29, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 100000.00, 1, 90000.00, '2024-12-05 09:33:07', 'cash', NULL, NULL, NULL, 1),
(30, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 100000.00, 1, 90000.00, '2024-12-05 09:37:23', 'cash', NULL, NULL, NULL, 1),
(31, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 6, 'Mũ lưỡi trai bé trai', 99999999.99, 1, 99999999.99, '2024-12-05 09:38:32', 'qr', NULL, NULL, NULL, 1),
(32, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 4, 'Chia sẻ Áo thun ngắn tay bé gái', 1510325.00, 1, 1510325.00, '2024-12-05 09:39:30', 'qr', NULL, NULL, NULL, 1),
(33, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 9, 'quần', 100000.00, 1, 90000.00, '2024-12-05 17:26:38', 'qr', NULL, NULL, NULL, 1),
(34, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-05 17:29:14', '', NULL, NULL, NULL, 1),
(35, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, 90000.00, '2024-12-05 17:32:21', 'cash', NULL, NULL, NULL, 1),
(36, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 10, 'Quần nỉ dài bé trai', 100000.00, 1, 95000.00, '2024-12-05 17:32:21', 'cash', NULL, NULL, NULL, 1),
(37, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 2, NULL, '2024-12-09 16:19:40', '', NULL, NULL, NULL, 1),
(38, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 2, NULL, '2024-12-10 07:07:43', 'Bank Transfer', 'Standard', 20000, 'MBBank', 1),
(39, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 10, 'Quần nỉ dài bé trai', 100000.00, 1, NULL, '2024-12-10 07:11:51', 'COD', 'Standard', 20000, '', 1),
(40, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 10, 'Quần nỉ dài bé trai', 100000.00, 1, NULL, '2024-12-10 07:13:50', 'Bank Transfer', 'Standard', 20000, 'MBBank', 1),
(41, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 6, 'Mũ lưỡi trai bé trai', 99999999.99, 1, NULL, '2024-12-10 07:15:58', 'Bank Transfer', 'Standard', 20000, 'Vietcombank', 1),
(42, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-11 17:55:07', '', NULL, NULL, NULL, 1),
(43, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 1, NULL, '2024-12-12 10:08:46', '', NULL, NULL, NULL, 1),
(44, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, NULL, '2024-12-12 14:48:52', '', NULL, NULL, NULL, 1),
(45, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 5, NULL, '2024-12-12 15:44:05', '', NULL, NULL, NULL, 1),
(46, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, NULL, '2024-12-12 15:48:39', '', NULL, NULL, NULL, 1),
(47, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, NULL, '2024-12-13 05:44:36', 'bank_transfer', 'express', NULL, 'MB', 1),
(48, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, 150000.00, '2024-12-13 05:59:26', 'bank_transfer', 'express', 50000, 'MB', 1),
(49, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, 130000.00, '2024-12-13 06:06:42', 'bank_transfer', 'standard', 30000, 'MB', 1),
(50, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, 130000.00, '2024-12-13 06:08:24', 'bank_transfer', 'standard', 30000, 'VCB', 1),
(51, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, 130000.00, '2024-12-13 06:12:34', 'bank_transfer', 'standard', 30000, 'VCB', 1),
(52, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, 130000.00, '2024-12-13 06:13:12', 'bank_transfer', 'standard', 30000, 'MB', 1),
(53, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 2, 250000.00, '2024-12-13 06:23:24', 'bank_transfer', 'express', 50000, 'MB', 1),
(54, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 1, 130000.00, '2024-12-13 06:25:50', 'bank_transfer', 'standard', 30000, 'VCB', 1),
(55, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 1, 'Áo thun tay dài', 100000.00, 2, 250000.00, '2024-12-13 07:38:47', 'bank_transfer', 'express', 50000, 'VCB', 1),
(61, 'Nguyễn Đình Tuấn', '0836 998 775', '11111', 2, 'Bộ đồ thun ngắn tay', 120000.00, 1, 150000.00, '2024-12-13 07:58:23', 'bank_transfer', 'standard', 30000, 'MB', 3),
(62, 'test1', '0369585104', 'Hà Nội', 7, 'Áo thun dài tay bé gái Rabity', 123123.00, 10, 1281230.00, '2024-12-13 16:16:18', 'bank_transfer', 'express', 50000, 'Agribank', 1),
(63, 'tuan test', '0123456789', 'Hà Nội', 6, 'Mũ lưỡi trai bé trai', 99999999.99, 10, 99999999.99, '2024-12-13 18:20:53', 'bank_transfer', 'standard', 30000, 'MB', 1),
(64, 'tuan test', '0123456789', 'Hà Nội', 2, 'Bộ đồ thun ngắn tay', 120000.00, 8, 1010000.00, '2024-12-14 10:27:18', 'COD', 'express', 50000, '', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sale_percentage` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT 50,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sold_quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_code`, `category`, `category_name`, `name`, `image`, `description`, `price`, `created_at`, `sale_percentage`, `stock`, `cost_price`, `sale_price`, `sold_quantity`) VALUES
(1, '001', 'Bé trai,BST Đồ Bộ Mặc Nhà', 'Áo', 'Áo thun tay dài', 'Screenshot 2024-12-12 211557.png', 'Nội dung đang được cập nhật', 100000.00, '2024-11-24 14:56:38', -10, 32, 10000.00, NULL, 17),
(2, '002', 'Bé trai', 'Đồ bộ', 'Bộ đồ thun ngắn tay', '../uploads/Screenshot 2024-11-23 182601.png', 'Mô tả sản phẩm\r\nĐồ bộ thun bé trai sẽ là outfits tiện lợi cho mẹ và bé, với kiểu dáng áo thun, quần short cá tính, năng động giúp bé thoải mái vận động. Với những mẫu đồ bộ tính dụng cao bé có thể mặc mặc ở nhà, đi học, đi chơi,... \r\n\r\n1. Thông tin Bộ thun ngắn tay Mickey bé trai Rabity 560.001\r\n- Chất liệu 95% vải cotton và 5% spandex thoáng mát, co giãn và an toàn cho làn da của bé\r\n\r\n- Loại sản phẩm: Đồ bộ bé trai\r\n\r\n- Phù hợp với bé trai cân nặng từ 11-21kg, từ 2-6 tuổi\r\n\r\n- Bộ thun ngắn tay in hình Mickey bản quyền Disney, hình in sắc nét và màu sắc hài hòa\r\n\r\n \r\n\r\n2. Thông tin chi tiết Bộ thun ngắn tay Mickey bé trai Rabity 560.001\r\nBộ thun ngắn tay bé trai form vừa vặn thoải mái. Kiểu dáng dễ phối nhiều outfit lịch sự cho bé diện đi học, đi tiệc hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 120000.00, '2024-11-24 15:11:40', 0, 41, NULL, NULL, 9),
(3, '003', 'Bé gái', 'Đầm váy', 'Đầm váy thô cổ sen ngắn tay bé gái', '../uploads/Screenshot 2024-11-23 183607.png', 'Đầm váy thô cổ sen ngắn tay bé gái Rabity 93113\r\n1. Thông tin Đầm váy thô cổ sen ngắn tay bé gái Rabity 93113\r\n- Chất liệu 100% thoáng mát, mềm mịn dễ chịu\r\n\r\n- Loại sản phẩm: Đầm váy bé gái\r\n\r\n- Phù hợp với bé gái cân nặng từ 11-30kg, từ 2-10 tuổi\r\n\r\n- Đầm thô ngắn tay họa tiết hoa đáng yêu, màu sắc nổi bật, thời trang cho bé diện thật nổi bật.', 1500000.00, '2024-11-24 15:13:08', 50, 50, NULL, NULL, 0),
(4, '004', 'Bé gái', 'Áo', 'Chia sẻ Áo thun ngắn tay bé gái', '../uploads/Screenshot 2024-11-24 221346.png', 'Áo thun là một outfits tiện lợi cho mẹ và bé, với kiểu dáng áo thun cá tính, năng động sẽ giúp bé thoải mái vận động. Ba mẹ có thể phối cho bé áo thun với những quần khác nhau như quần nỉ, quần dài, quần thun,... cho bé mặc nhiều dịp đi học, đi chơi, đi học, đi tiệc,...\r\n\r\n1. Đặc điểm nổi bật Áo thun ngắn tay bé gái 900.076\r\n- Chất liệu 100% vải cotton xước thông thoáng, mát mẻ và an toàn cho làn da của bé Cotton\r\n\r\n- Loại sản phẩm: Áo bé gái, Áo thun bé gái\r\n\r\n- Phù hợp với bé gái cân nặng từ 11 - 35kg, từ 2 - 12 tuổi\r\n\r\n- Áo thun ngắn tay in hình trái dưa hấu dễ thương, năng động và sắc nét.\r\n\r\n2. Thông tin chi tiết Áo thun ngắn tay bé gái 900.076\r\nÁo thun ngắn tay bé gái form vừa vặn thoải mái. Kiểu dáng dễ phối nhiều outfit lịch sự cho bé diện đi học, đi tiệc hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.', 1510325.00, '2024-11-24 15:14:17', 0, 49, NULL, NULL, 0),
(5, '005', 'Bé gái', 'Đồ bộ', 'Đồ bộ thun tăm dài tay bé gái Rabity', '../uploads/Screenshot 2024-11-24 221446.png', 'Thời tiết thay đổi liên tục, những ngày lạnh hay nhiệt độ thấp vào ban đêm, đồ bộ dài tay cho bé là cứu tinh lúc này. Chất thun tăm được dệt từ sợi cotton co giãn thoải mái, bé mặc thích thú cả ngày.\r\n\r\n1. Đặc điểm nổi bật Đồ bộ thun tăm dài tay bé gái Rabity 961.001\r\nChất liệu: Với thiết kế 100% vải cotton nhẹ thoáng, êm mịn và an toàn cho làn da bé.\r\nĐộ tuổi, cân nặng: phù hợp cho bé từ 2 - 6 tuổi, từ 11-21kg.\r\nLoại sản phẩm: Đồ bộ bé gái, đồ bộ dài tay bé gái.\r\nÁo tay dài quần dài, họa tiết bông hoa nhỏ xinh xắn.\r\n2. Thông tin chi tiết Đồ bộ thun tăm dài tay bé gái Rabity 961.001\r\nBộ thun tăm dài tay bé gái kiểu dáng điệu đà, màu sắc hồng nhạt, vàng nhạt dịu dàng cho các bé gái. Sản phẩm thích hợp cho bé mặc trong mùa thu đông hoặc khi thời tiết lạnh, mang đến cảm giác ấm áp và thoải mái khi mặc.', 99999999.99, '2024-11-24 15:15:08', 0, 50, NULL, NULL, 0),
(6, '006', 'Bé trai', 'Phụ kiện', 'Mũ lưỡi trai bé trai', '../uploads/Screenshot 2024-11-24 221544.png', 'Freesize', 99999999.99, '2024-11-24 15:16:11', 0, 39, NULL, NULL, 10),
(7, '007', 'Bé gái', 'Áo', 'Áo thun dài tay bé gái Rabity', '../uploads/Screenshot 2024-11-26 125423.png', 'Nội dung đang được cập nhật', 123123.00, '2024-11-26 05:54:53', 0, 40, NULL, NULL, 10),
(9, '011', 'Bé trai', 'Quần', 'quần', 'Screenshot 2024-11-23 000410.png', '2ewrgthgth', 100000.00, '2024-12-05 07:06:40', 10, 44, 10000.00, NULL, 0),
(10, '014', 'Bé gái,BST Thu Đông', 'Đồ bộ', 'Quần nỉ dài bé trai', 'Screenshot 2024-12-05 171612.png', 'Quần nỉ là sự kết hợp hoàn hảo giữa phong cách năng động và tiện dụng. Quần nỉ không chỉ phù hợp cho những buổi dạo phố, mà còn là lựa chọn lý tưởng cho các bé khi tham gia các hoạt động ngoại khóa, vui chơi thể thao. Hơn nữa, với kiểu dáng thời trang và màu sắc phong phú, quần nỉ chắc chắn sẽ giúp các bé tự tin và nổi bật trong mọi hoàn cảnh\r\n\r\n1. Đặc điểm nổi bật Quần nỉ dài bé trai \r\nNhóm sản phẩm: Quần bé trai; Quần dài bé trai\r\nChất liệu: 95% cotton 5% spandex an toàn và thoáng mát cho da của bé\r\nSize: Phù hợp với bé trai cân nặng từ 14 - 35kg, từ 4 - 12 tuổi\r\n \r\n\r\n2. Chất liệu Quần nỉ dài bé trai \r\nQuần dài bé trai form vừa vặn thoải mái. Kiểu dáng dễ phối nhiều outfit lịch sự cho bé diện đi học, đi tiệc hay xuống phố. Sản phẩm đạt chứng nhận Oeko-Tex 100 an toàn cho da trẻ em.\r\n\r\n', 100000.00, '2024-12-05 10:17:27', 5, 14, 10000.00, NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(11, 1, 'Screenshot 2024-12-12 211616.png'),
(12, 1, 'Screenshot 2024-12-12 211611.png'),
(13, 1, 'Screenshot 2024-12-12 211606.png'),
(14, 1, 'Screenshot 2024-12-12 211602.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `gender`, `role`, `created_at`) VALUES
(1, '', 'tuan1', 'xmeosadx@gmail.com', '$2y$10$..qwYnX8sNPFB5/CjcPMMO1UxCnYy3udkvKAT8zDuXY2c4PldG.Dq', '', 'user', '2024-11-24 13:34:32'),
(2, '', 'admin', 'xmeo2612x@gmail.com', '$2y$10$.STfEayHecZFksdKU.OAIup92zbneMWwJ1goW.r0DetqvFxLVJ1fG', '', 'admin', '2024-11-24 13:56:47'),
(3, '', 'tuan2', 'Farmx12@zz.zz', '$2y$10$.0afaOuXOA066qrwu/QjgOnKVC5PvzCPNXvmhuUoy8Af0aenzt1.m', '', 'user', '2024-12-03 10:47:36'),
(4, 'Phạm Quang Tuấn', 'quangtuan', 'quangtuan@gmail.com', '$2y$10$6tDmsLa7oLK.phCaocDC/uHZowoBKxZBc74Vymk6XeWZOe39.wZsq', 'Nam', 'user', '2024-12-14 10:00:46'),
(5, 'Trần Phương Ly', 'phuonglyxinhgai', 'may_lily@gmail.com', '$2y$10$NyJ5MIYMgC/boQKce4zk0evQCm/Zh6HQ/S2kSeAuOBNoDcNxdxtry', 'Nữ', 'user', '2024-12-14 10:14:51'),
(6, 'Phạm Quang Tuấn1', 'quangtuanxautrai', 'ptuan2594@gmail.com', '$2y$10$fz/96XXY/qB3swrJgnKxQ.4QqygfTSyfBgr1f36n/ywakC6tlM37S', 'Nam', 'user', '2024-12-14 16:41:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender` enum('Nam','Nữ','Khác') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `gender`, `birthdate`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nam', '2004-06-26', '0836 998 775', 'Vũ Thư, Thái Bình', '2024-12-13 06:57:59', '2024-12-13 06:57:59'),
(2, 1, 'Nam', '2004-06-26', '0836 998 775', 'Vũ Thư, Thái Bình', '2024-12-13 06:59:13', '2024-12-13 06:59:13'),
(3, 1, 'Nam', '2004-06-26', '0836 998 775', 'Vũ Thư, Thái Bình', '2024-12-13 07:01:03', '2024-12-13 07:01:03'),
(4, 1, 'Nam', '2004-06-26', '0836 998 775', 'Vũ Thư, Thái Bình', '2024-12-13 07:07:53', '2024-12-13 07:07:53'),
(5, 1, 'Nam', '2004-06-26', '0836 998 775', 'Vũ Thư, Thái Bình', '2024-12-13 07:11:00', '2024-12-13 07:11:00'),
(6, 1, 'Nam', '2004-06-26', '0836 998 775', 'Vũ Thư, Thái Bình', '2024-12-13 07:15:37', '2024-12-13 07:15:37'),
(7, 1, 'Nam', '2004-06-26', '0836 998 775', 'Vũ Thư, Thái Bình', '2024-12-13 07:24:45', '2024-12-13 07:24:45');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
