-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 08:59 PM
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
  `user_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'Chưa giao',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_name`, `phone`, `address`, `product_id`, `product_name`, `price`, `quantity`, `total_price`, `created_at`, `payment_method`, `shipping_method`, `shipping_cost`, `bank`, `user_id`, `status`, `updated_at`) VALUES
(65, 'Nguyễn Đình Tuấn', '0836 998 775', '12344', 30, 'Mũ lưỡi trai Spider-Man bé trai Rabity', 129000.00, 1, 159000.00, '2024-12-17 13:23:17', 'bank_transfer', 'standard', 30000, 'MB', 14, 'Đã nhận', '2024-12-18 19:24:00'),
(66, 'Áo thun ngắn tay Ngoan xinh yêu cho bé gái', '12345', 'Thái Bình', 28, 'Quần kaki dài Marvel Avengers bé trai Rabity', 305000.00, 4, 1270000.00, '2024-12-18 18:30:18', 'COD', 'express', 50000, '', 13, 'Đã giao', '2024-12-18 18:40:29');

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

INSERT INTO `products` (`id`, `product_code`, `category`, `category_name`, `name`, `image`, `description`, `price`, `created_at`, `sale_percentage`, `stock`, `cost_price`, `sale_price`, `sold_quantity`) VALUES
(12, '001', 'Bé gái', 'Áo', 'Áo thun ngắn tay Ngoan xinh yêu cho bé gái', '900083-3_ba2d1c4ab2254e97b2c6af9ccd94cfcb.webp', 'Áo thun ngắn tay luôn là một loại trang phục được rất nhiều ba mẹ lựa chọn khi mua sắm quần áo cho con bởi sự thoải mái và tiện lợi mà chúng mang lại. Với nhưng mẫu áo thun ba mẹ có thể kết hợp được với nhiều kiểu quần, kiểu váy khác nhau để tạo nên những outfits mặc ở nhà, đi chơi, đi học,...\r\n- Nhóm sản phẩm: Áo thun bé gái, áo bé gái\r\n- Chất liệu 95% cotton 5% spandex thoáng mát, co giãn và an toàn cho làn da của bé\r\n- Phù hợp với bé gái cân nặng từ 11 - 35kg, từ 2 - 12 tuổi\r\n- Áo thun bé gái form basic in chữ Ngoan xinh yêu đáng yêu, hình in to sắc nét và màu sắc phối hài hòa, nổi bật.', 179000.00, '2024-12-17 12:01:24', 30, 100, 150000.00, NULL, 0),
(16, '002', 'Bé gái', 'Áo', 'Áo nỉ dài tay bé gái Rabity x ELLE Kids - designed in Paris', 'dsc09592_copy_7d0ac79c66334423b097ee552c5aa446.webp', 'Nội dung đang được cập nhật', 269000.00, '2024-12-17 12:09:00', 0, 100, 175000.00, NULL, 0),
(17, '003', 'Bé gái', 'Áo', 'Áo thun ngắn tay bé gái Rabity x ELLE Kids - designed in Paris', 'dsc09679_copy_bb10069dde2d4f1883485baa6ff378cb.webp', 'Nội dung đang được cập nhật', 169000.00, '2024-12-17 12:12:05', 0, 100, 130000.00, NULL, 0),
(18, '004', 'Bé gái,BST Thu Đông', 'Quần', 'Quần kaki dài bé gái Rabity x ELLE Kids - designed in Paris', '842001-0_f1b8d77d8bb04fc9b0f6bf1ab3e7e2f3.webp', 'Quần kaki là một kiểu quần rất tiện lợi nên thường được ba mẹ lựa chọn khi mua sắm quần áo cho bé gái, với những chiếc quần kaki bạn có thể phối với đa dạng mẫu áo khác nhau như áo thun tay ngắn, áo sát nách, áo sơ mi,... để mặc đi học, đi chơi hoặc đi tiệc.', 279000.00, '2024-12-17 12:14:51', 0, 100, 200000.00, NULL, 0),
(19, '005', 'Bé gái', 'Quần', 'Quần jean dài bé gái Rabity x ELLE Kids - designed in Paris', '841001241-0_506b5e2cd79a4fbf864338a4be6075c4.webp', 'Nội dung đang được cập nhật', 369000.00, '2024-12-17 12:17:16', 0, 100, 300000.00, NULL, 0),
(20, '006', 'Bé gái,BST Đồ Bộ Mặc Nhà,BST Đồ Đi Chơi Noel', 'Đồ bộ', 'Bộ nỉ dài tay bé gái Rabity x ELLE Kids - designed in Paris', 'dsc09474_copy_2_45d4855d20c14cec8dd4c50be3893c78.webp', 'Thời tiết thay đổi liên tục, những ngày lạnh hay nhiệt độ thấp vào ban đêm, đồ bộ dài tay cho bé là cứu tinh lúc này. Chất nỉ được dệt từ sợi cotton co giãn thoải mái, bé mặc thích thú cả ngày.', 369000.00, '2024-12-17 12:20:36', 0, 100, 290000.00, NULL, 0),
(21, '007', 'Bé gái', 'Phụ kiện', 'Set 2 bím tóc bé gái Rabity', '97103424-1_aa52940edcd84a87864e2fa172573246.webp', 'Nội dung đang được cập nhật', 89000.00, '2024-12-17 12:23:52', 10, 100, 50000.00, NULL, 0),
(22, '008', 'Bé gái', 'Phụ kiện', 'Hộp phụ kiện bé gái Rabity', '97102824-2_5c575c69b3764194833aa075ba686300.webp', 'Nội dung đang được cập nhật', 99000.00, '2024-12-17 12:26:14', 10, 100, 40000.00, NULL, 0),
(23, '009', 'Bé gái', 'Phụ kiện', 'Mũ cói bé gái Rabity', '2_1_23709589d1fb407b87e09b389502d0f6.webp', 'Nội dung đang được cập nhật', 129000.00, '2024-12-17 12:28:41', 25, 100, 99999.00, NULL, 0),
(24, '010', 'Bé gái', 'Đầm váy', 'Đầm váy thô ngắn tay bé gái Rabity x ELLE Kids - designed in Paris', '2_copy_3b31e5b2ae184e8fb53cd786a6390a2b.webp', 'Đầm váy là là một outfits không thể thiếu trong tủ đồ của các cô công chúa nhỏ giúp ba mẹ tiết kiệm thời gian trong việc lựa chọn cho bé mỗi ngày mà bé có thể mặc trong nhiều dịp khác nhau như như đi chơi, đi học, đi tiệc,...', 569000.00, '2024-12-17 12:54:30', 10, 100, 350000.00, NULL, 0),
(25, '011', 'Bé trai', 'Áo', '[Độc quyền Online] Áo thun ngắn tay in chữ Việt Nam bé trai/bé gái Rabity', '900081-1_2408deff07e148a2a3e1a480e3c3f83e.webp', 'Nội dung đang được cập nhật', 129000.00, '2024-12-17 12:57:17', 10, 100, 100000.00, NULL, 0),
(26, '012', 'Bé trai', 'Áo', '[Độc quyền Online] Áo thun ngắn tay bé trai/bé gái Capybara', '900080243-0_56b8193299984f72a7354eca24d3dc22.webp', 'Nội dung đang được cập nhật', 125000.00, '2024-12-17 12:59:59', 15, 100, 75000.00, NULL, 0),
(27, '013', 'Bé trai', 'Quần', 'Quần short kaki bé trai Rabity x ELLE Kids - designed in Paris', '12_copy_40e4cabb91894d6cb087798f8b7d45ad.webp', 'Quần short kaki là một trong những sản phẩm luôn được ba mẹ ưa chuộng khi phối đồ cho bé trai bởi sự tiện lợi và thoải mái mà chúng mang lại cho bé. Bạn có thể phối nhiều outfits khác nhau cho bé từ những chiếc quần short từ năng động đến lịch sự, mặc đi học, đi chơi, đi tiệc,...đều phù hợp.', 269000.00, '2024-12-17 13:02:38', 5, 100, 150000.00, NULL, 0),
(28, '014', 'Bé trai', 'Quần', 'Quần kaki dài Marvel Avengers bé trai Rabity', '542001240-1_d6f47fa0a54f4905a67eabf790559e88.jpg', 'Quần kaki là sự kết hợp hoàn hảo giữa phong cách năng động và tiện dụng. Quần kaki không chỉ phù hợp cho những buổi dạo phố, mà còn là lựa chọn lý tưởng cho các bé khi tham gia các hoạt động ngoại khóa, vui chơi thể thao. Hơn nữa, với kiểu dáng thời trang và màu sắc phong phú, quần kaki chắc chắn sẽ giúp các bé tự tin và nổi bật trong mọi hoàn cảnh', 305000.00, '2024-12-17 13:05:36', 8, 96, 255000.00, NULL, 4),
(29, '015', 'Bé trai,BST Đồ Đi Chơi Noel,BST Disney - Friends', 'Đồ bộ', 'Đồ bộ thun Spider-Man dài tay bé trai Rabity', '561001240-3_d0cabd4ade3e44348b7face22fd02285.webp', 'Thời tiết thay đổi liên tục, những ngày lạnh hay nhiệt độ thấp vào ban đêm, đồ bộ dài tay cho bé là cứu tinh lúc này. Chất nỉ được dệt từ sợi cotton co giãn thoải mái, bé mặc thích thú cả ngày.', 296000.00, '2024-12-17 13:08:44', 30, 100, 189000.00, NULL, 0),
(30, '016', 'Bé trai', 'Phụ kiện', 'Mũ lưỡi trai Spider-Man bé trai Rabity', '9710042400005_c5577a1c716b4e12ade596f90b9ef691.webp', 'Nội dung đang được cập nhật', 129000.00, '2024-12-17 13:20:05', 5, 99, 55000.00, NULL, 1);

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
(21, 12, '900083-1_3f456f0b9b1b460bb4dc62cba27f7c61.webp'),
(22, 12, '900083-2_f676510a34064b79b5045c7c142c1833.webp'),
(23, 16, '20_copy_d47e753a01824893ac2ba6e9dd212487.webp'),
(24, 16, '20-3_efa29bc4d967494fad17c88c8b6b016c.webp'),
(25, 16, 'dsc09563_copy_9de59a5b94b64c4295ced9bc1344d0d3.webp'),
(26, 16, 'dsc09916_copy_ab851af594454a1d84229c51354c3221.webp'),
(27, 17, '24_copy_08e3cbf6a64d424188661bc950b040ee.webp'),
(28, 17, '25_copy_2fa4e03adc3d412e97e590c7613d1f99.webp'),
(29, 17, '25-3_f20f08c9b8a143759896c7bbc024f6fd.webp'),
(30, 17, 'dsc09627_copy_b29e3f26682e4872bf9b44e618659391.webp'),
(31, 18, '842001-4_3a42949a6e72460f85899f68a04cca96.webp'),
(32, 18, '842001-5_49b94e33b7474ca3b1f2a14a46547b31.webp'),
(33, 18, 'dsc09913_copy_2eca5e577c7e4752a6cb25032ca4556c.webp'),
(34, 19, '841001241-1_ebfac57210d0449c92af9abe750d234b.webp'),
(35, 19, '841001241-2_53f2c95fdfe44f76ac9a83e790405ef0.jpg'),
(36, 19, '841001241-3_3dfefc0946ec4ac29f9032dd5291a0b4.jpg'),
(37, 20, '866001_2574bdfa1c704bceb5e0645f24f65201.webp'),
(38, 20, '866001-2_de9fba8d24d94a20b76cb6d9eece235f.webp'),
(39, 20, '866001-3_76783c4b20934da7bdd6df6c0d533c4e.webp'),
(40, 20, 'dsc09466_copy_2_9220c91fe3a1460a849fc71ea6890e16.webp'),
(41, 21, '97103424-2_a9f7a6067097479cbcc5f3b79f399b2c.webp'),
(42, 21, '97103424-4_99860972dc6d47afb1ae30d8663d8d50.webp'),
(43, 21, '97103424-6_008c8864711b4a9aa24ca609f92db8c4.webp'),
(44, 22, '97102824-1_0dae3895e4144607a02faccbee612199.webp'),
(45, 22, '97102824-4_827473af48aa408891a3ee6ce128ee7c.webp'),
(46, 22, '97102824-5_eb9d014b54ab42e59bed6c82264bb18b.webp'),
(47, 23, '2_0_e2f3e674e0a54bd4897c1fef73c0b0f3.webp'),
(48, 23, '2_2_a4afb5573f3141478d31f7b8e61ff4a7.webp'),
(49, 23, 'dsc03740_copy_71ade21c60d24816b9f6e2d2a68c8b8b.webp'),
(50, 24, '2_4_f2760e2465e745989f501d25b10d6477.webp'),
(51, 24, '3.webp'),
(52, 24, 'dsc00001_copy_fe82929405934053b1818a29c750c189.webp'),
(53, 24, 'gfg_13450e3da6c4488580171dad6e7e6638.webp'),
(54, 25, '900081-2_8936cd3e540645cd8eec1638dd92e4eb.webp'),
(55, 25, '900081-3_d987ec0e043d4d6aaa6122b782e713aa.webp'),
(56, 26, '900080243-3_dff2eaf2213b42369f9ca6f322dbf4be.webp'),
(57, 26, '900080243-4_f5de8d0fa4da40619db9e2a82d56b0d9.webp'),
(58, 26, '900080243-6_a7203dacfd3048ddae6b3df628426d40.webp'),
(59, 27, '11_4_3ce11ebfec1440fc9f2c9fe264ea8ebd.webp'),
(60, 27, '11_copy_55fd10ce2e614e0698d6b0b2b695ee94.webp'),
(61, 27, '12-2_0af1cf20079f4dd6864404a20d5901d1.webp'),
(62, 28, '542001240-6_f8e256889c194942932bc65ad99d3a08.jpg'),
(63, 28, '542001240-7_4cc3b175748947e0b67e0d7f3e9e25fe.webp'),
(64, 28, 'dsc01210_copy_ead4aeeee7224dbfb07ca6ce262d1476.webp'),
(65, 28, 'dsc01286_copy_4393983e15da4d679da096041b93a977.webp'),
(66, 29, '561001240-6_4ee64494936641fdb52e31ce337541a8.webp'),
(67, 29, 'dsc01120_copy_50ddce35cbe44a598893fe825cf45a07.webp'),
(68, 29, 'dsc01123_copy_55756ae2c80d42388b88931bb8bd19e2.webp'),
(69, 30, '9710042400005-1_04090cae29914854bbeeffbc1a34132e.webp'),
(70, 30, '9710042400005-2_1f7602c85c7e45378b450cde747ccba0.webp');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `order_id`, `product_id`, `user_id`, `rating`, `review`, `created_at`) VALUES
(1, 65, 30, 14, 5, 'Đẹp', '2024-12-18 19:27:43');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

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
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_reviews_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD CONSTRAINT `security_questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
