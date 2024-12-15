-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 05:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `furniture`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `email`, `password`, `created_at`) VALUES
(1, 'fire', 'ss', 'fire@gmail.com', 827, '2024-10-14 16:31:44'),
(2, 'john', '12345678', 'johny123@gmail.com', 32135, '2024-11-20 10:22:31'),
(3, 'john', 'rems', 'firee@gmail.com', 32135, '2024-11-20 10:23:07'),
(4, 'john', 'rems', 'rems@gmail.com', 25, '2024-11-20 10:27:37'),
(5, 'jamir', 'basa', 'jamirbasa@gmail.com', 25, '2024-11-26 21:52:18'),
(6, 'paul daniel', 'ojales', '1@gmail.com', 0, '2024-12-01 11:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(11) NOT NULL,
  `brgyCode` varchar(255) NOT NULL,
  `Brgy_Name` varchar(255) DEFAULT NULL,
  `regCode` varchar(255) NOT NULL,
  `provCode` varchar(255) NOT NULL,
  `citymunCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `brgyCode`, `Brgy_Name`, `regCode`, `provCode`, `citymunCode`) VALUES
(30326, '097332001', 'Arena Blanco', '09', '0973', '097332'),
(30327, '097332002', 'Ayala', '09', '0973', '097332'),
(30328, '097332004', 'Baliwasan', '09', '0973', '097332'),
(30329, '097332005', 'Baluno', '09', '0973', '097332'),
(30330, '097332010', 'Boalan', '09', '0973', '097332'),
(30331, '097332011', 'Bolong', '09', '0973', '097332'),
(30332, '097332012', 'Buenavista', '09', '0973', '097332'),
(30333, '097332013', 'Bunguiao', '09', '0973', '097332'),
(30334, '097332014', 'Busay (Sacol Island)', '09', '0973', '097332'),
(30335, '097332015', 'Cabaluay', '09', '0973', '097332'),
(30336, '097332016', 'Cabatangan', '09', '0973', '097332'),
(30337, '097332017', 'Cacao', '09', '0973', '097332'),
(30338, '097332018', 'Calabasa', '09', '0973', '097332'),
(30339, '097332019', 'Calarian', '09', '0973', '097332'),
(30340, '097332020', 'Campo Islam', '09', '0973', '097332'),
(30341, '097332021', 'Canelar', '09', '0973', '097332'),
(30342, '097332022', 'Cawit', '09', '0973', '097332'),
(30343, '097332023', 'Culianan', '09', '0973', '097332'),
(30344, '097332024', 'Curuan', '09', '0973', '097332'),
(30345, '097332025', 'Dita', '09', '0973', '097332'),
(30346, '097332026', 'Divisoria', '09', '0973', '097332'),
(30347, '097332027', 'Dulian (Upper Bunguiao)', '09', '0973', '097332'),
(30348, '097332028', 'Dulian (Upper Pasonanca)', '09', '0973', '097332'),
(30349, '097332030', 'Guisao', '09', '0973', '097332'),
(30350, '097332031', 'Guiwan', '09', '0973', '097332'),
(30351, '097332032', 'La Paz', '09', '0973', '097332'),
(30352, '097332033', 'Labuan', '09', '0973', '097332'),
(30353, '097332034', 'Lamisahan', '09', '0973', '097332'),
(30354, '097332035', 'Landang Gua', '09', '0973', '097332'),
(30355, '097332036', 'Landang Laum', '09', '0973', '097332'),
(30356, '097332037', 'Lanzones', '09', '0973', '097332'),
(30357, '097332038', 'Lapakan', '09', '0973', '097332'),
(30358, '097332039', 'Latuan (Curuan)', '09', '0973', '097332'),
(30359, '097332040', 'Limaong', '09', '0973', '097332'),
(30360, '097332041', 'Limpapa', '09', '0973', '097332'),
(30361, '097332042', 'Lubigan', '09', '0973', '097332'),
(30362, '097332043', 'Lumayang', '09', '0973', '097332'),
(30363, '097332044', 'Lumbangan', '09', '0973', '097332'),
(30364, '097332045', 'Lunzuran', '09', '0973', '097332'),
(30365, '097332046', 'Maasin', '09', '0973', '097332'),
(30366, '097332047', 'Malagutay', '09', '0973', '097332'),
(30367, '097332048', 'Mampang', '09', '0973', '097332'),
(30368, '097332049', 'Manalipa', '09', '0973', '097332'),
(30369, '097332050', 'Mangusu', '09', '0973', '097332'),
(30370, '097332051', 'Manicahan', '09', '0973', '097332'),
(30371, '097332052', 'Mariki', '09', '0973', '097332'),
(30372, '097332053', 'Mercedes', '09', '0973', '097332'),
(30373, '097332054', 'Muti', '09', '0973', '097332'),
(30374, '097332055', 'Pamucutan', '09', '0973', '097332'),
(30375, '097332056', 'Pangapuyan', '09', '0973', '097332'),
(30376, '097332057', 'Panubigan', '09', '0973', '097332'),
(30377, '097332058', 'Pasilmanta (Sacol Island)', '09', '0973', '097332'),
(30378, '097332059', 'Pasonanca', '09', '0973', '097332'),
(30379, '097332060', 'Patalon', '09', '0973', '097332'),
(30380, '097332061', 'Barangay Zone I (Pob.)', '09', '0973', '097332'),
(30381, '097332062', 'Barangay Zone II (Pob.)', '09', '0973', '097332'),
(30382, '097332063', 'Barangay Zone III (Pob.)', '09', '0973', '097332'),
(30383, '097332064', 'Barangay Zone IV (Pob.)', '09', '0973', '097332'),
(30384, '097332065', 'Putik', '09', '0973', '097332'),
(30385, '097332066', 'Quiniput', '09', '0973', '097332'),
(30386, '097332067', 'Recodo', '09', '0973', '097332'),
(30387, '097332068', 'Rio Hondo', '09', '0973', '097332'),
(30388, '097332069', 'Salaan', '09', '0973', '097332'),
(30389, '097332070', 'San Jose Cawa-cawa', '09', '0973', '097332'),
(30390, '097332071', 'San Jose Gusu', '09', '0973', '097332'),
(30391, '097332072', 'San Roque', '09', '0973', '097332'),
(30392, '097332073', 'Sangali', '09', '0973', '097332'),
(30393, '097332074', 'Santa Barbara', '09', '0973', '097332'),
(30394, '097332075', 'Santa Catalina', '09', '0973', '097332'),
(30395, '097332076', 'Sibulao', '09', '0973', '097332'),
(30396, '097332077', 'Sinubong', '09', '0973', '097332'),
(30397, '097332078', 'Sinunuc', '09', '0973', '097332'),
(30398, '097332079', 'Tagasilay', '09', '0973', '097332'),
(30399, '097332080', 'Taguiti', '09', '0973', '097332'),
(30400, '097332081', 'Talisayan', '09', '0973', '097332'),
(30401, '097332082', 'Taluksangay', '09', '0973', '097332'),
(30402, '097332083', 'Talon-talon', '09', '0973', '097332'),
(30403, '097332084', 'Tictapul', '09', '0973', '097332'),
(30404, '097332085', 'Tigbalabag', '09', '0973', '097332'),
(30405, '097332086', 'Tolosa', '09', '0973', '097332'),
(30406, '097332087', 'Tugbungan', '09', '0973', '097332'),
(30407, '097332088', 'Tulungatung', '09', '0973', '097332'),
(30408, '097332089', 'Tumaga', '09', '0973', '097332'),
(30409, '097332090', 'Tumalutab (Sacol Island)', '09', '0973', '097332'),
(30410, '097332091', 'Upper Calarian', '09', '0973', '097332'),
(30411, '097332092', 'Victoria', '09', '0973', '097332'),
(30412, '097332093', 'Vitali', '09', '0973', '097332'),
(30413, '097332094', 'Zambowood', '09', '0973', '097332');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 37, '2024-11-21 14:53:34', '2024-11-21 14:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `added_at`) VALUES
(23, 3, 14, 2, '2024-11-21 14:53:34'),
(24, 3, 18, 1, '2024-11-21 14:53:39');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'tables'),
(2, 'chairs'),
(3, 'doors');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_ordered` date NOT NULL,
  `date_completed` date DEFAULT NULL,
  `status` enum('Completed','Canceled') NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`id`, `product_id`, `user_id`, `date_ordered`, `date_completed`, `status`, `quantity`, `total_cost`) VALUES
(1, 25, 35, '2024-12-17', '2024-12-23', 'Canceled', 2, 9180.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_keywords`, `category_id`, `product_image1`, `product_image2`, `product_image3`, `product_price`, `date`, `status`, `seller_id`, `quantity`) VALUES
(14, 'RE:zero merchandise', 'Keychains, bedsheets, and many more merchandise that a negga would love! purchase the product now and experience a life similar to another fucking world!!!! aefgghhhhhh', 're:zero', 1, '699770.png', '1323312.jpeg', 're-zero-natsuki-subaru-uhd-4k-wallpaper.jpg', '900', '2024-12-08 14:43:14', 'true', 19, 0),
(17, 'Elegant Table ', 'Basic table set that comes in different type of wood and sizes. durable, secure, and good decoration for homes', 'table24', 1, 'table1.jpg', 'b-45_1024x1024@2x.webp', 'Toya-Icons-Sophia-4-seater-600x600.jpg', '2000', '2024-11-12 13:43:51', 'true', 4, 0),
(18, 'Sample Product', 'Illuminate your workspace with the Smart LED Desk Lamp that combines sleek design with advanced technology. This energy-efficient desk lamp features adjustable brightness levels and a range of color temperatures, making it perfect for any task', 'Sample', 2, 'ea01ac68-f95d-44c0-bafe-b0ab0071b4fa.webp', 'images.jfif', 'high_quality_re_zero_4k_wallpaper_by_sdugoten_dfvyffu-414w-2x.jpg', '499', '2024-11-12 17:59:11', 'true', 4, 0),
(19, 'painting', 'it is a painting of a painter', 'pp', 1, 'thumb-1920-1323803.jpeg', 'bg.png', 'high_quality_re_zero_4k_wallpaper_by_sdugoten_dfvyffu-414w-2x.jpg', '500', '2024-11-30 12:37:49', 'true', 17, 0),
(20, 'Frame', 'it is a very very frame', 'frame', 3, '418242049_7166968090050657_3787948158708799180_n.jpg', '387512755_1407599433156736_1528413741543136407_n.jpg', '418626179_2082648605423733_1408003536253476387_n.jpg', '2000', '2024-12-01 21:24:10', 'true', 18, 10),
(21, 'Sample 3', 'nice chair upuan mo ako please', 'chaorss', 2, 'anime-re-zero-starting-life-in-another-world-subaru-natsuki-wallpaper-thumb .jpg', 'Login rezero.jpg', 'Diez Green Wool Sofa + Reviews _ CB2.jpg', '400', '2024-12-01 21:37:42', 'true', 18, 600),
(22, 'Blue Sofa', 'This beautiful blue sofa is the perfect blend of style, comfort, and durability, designed to elevate any living space. The rich, deep blue fabric adds a touch of sophistication while remaining versatile enough to complement a wide range of decor styles, from modern to traditional. The soft upholstery feels inviting to the touch, making it ideal for long hours of lounging or entertaining guests.', 'bluesofa', 2, 'depositphotos_377527168-stock-photo-interior-design-modern-living-room.jpg', 'furniture-styles-GettyImages-1467984982-512fed4077b646eabbc187619554d517.jpg', 'images.jpg', '8999', '2024-12-08 13:25:13', 'true', 19, 55),
(23, 'Round White Mini Table', 'This round white table with oak legs combines simplicity and elegance, making it a versatile addition to any home or office. The sleek, white tabletop offers a clean, modern look that brightens up any space, while the warm, natural oak legs add a touch of timeless charm. Its compact, round shape makes it perfect for smaller dining areas, kitchens, or even as a stylish workspace. The sturdy oak legs provide excellent support, ensuring long-lasting durability, while the minimalist design allows it to effortlessly blend with various interior styles, from contemporary to rustic.', 'roundwhitetable', 1, 'tablewhite.jpg', 'tablewhite3.jpg', 'tablewihte2.jpg', '2999', '2024-12-08 13:34:38', 'true', 19, 177),
(24, 'Brownies Door Yummy', 'This elegant brown door is the perfect blend of durability and style, designed to enhance the entrance of your home. Made from high-quality materials, the rich brown finish adds warmth and sophistication to any room or exterior. Its sturdy construction ensures long-lasting performance, providing both security and peace of mind', 'Browndoor', 3, 'Dowaru 3.jpg', 'Kusen pintu jati mewah.jpg', 'Metāla durvis - Dzelzs ārdurvis - Metaluks.jpg', '1799', '2024-12-08 14:06:18', 'true', 19, 4),
(25, 'Mini table: Oak', 'The Mini Table Oak perfectly encapsulates the harmonious balance of style, functionality and durability. Beautifully crafted from premium solid oak wood, this compact table exudes a warm, rustic charm that elevates any living space. Its sleek, minimalist design complements modern interiors while its compact footprint makes it ideal for small rooms, apartments, cozy reading nooks or home offices. Whether utilized as a side table, coffee table or study desk, the versatility of the Mini Table Oak knows no bounds. With its robust construction and high-quality finish, this table promises longevity and effortless maintenance. Its compact size belies its considerable functionality, making it perfect for study areas, display spaces or social gatherings. The Mini Table Oak seamlessly blends into various decor styles, ensuring an effortless, elegant aesthetic.', 'Oaktablemini', 1, 'oak mini table.jpg', 'oak mini table2.jpg', 'oak mini table3.jpg', '4590', '2024-12-10 10:34:28', 'true', 20, 10),
(26, 'Walnut Dining Chair', 'The oak or walnut dining chair is made from European wood and Italian leather or wool. The frame is treated with Rubio monocoat two-component wood oil for optimal durability and sustainability. The chair features Italian calf leather or wool upholstery and 30mm foam cushioning for superior seating comfort.', 'walnut', 2, 'coffee chair3.jpg', 'coffee chair2.jpg', 'coffee chair.jpg', '299', '2024-12-10 10:55:43', 'true', 20, 200);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` decimal(3,2) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `product_id`, `user_id`, `rating`, `review`, `created_at`) VALUES
(6, 14, 35, 5.00, 'best merchandize i can get in this store. perfectly crafted down to very last edges', '2024-12-01 20:48:15'),
(7, 21, 35, 5.00, 'Very Nicest Product', '2024-12-08 13:59:56'),
(8, 23, 35, 4.00, 'I&#39;m thoroughly satisfied with my round white table purchase! The sleek, modern design perfectly complements my interior, and the sturdy build ensures durability. Assembly was surprisingly hassle-free. Whether for dining, working or entertaining, this versatile table fits perfectly in any setting. Overall, excellent quality and value!', '2024-12-10 06:45:47'),
(9, 23, 41, 1.00, 'I&#39;m disappointed with my round white table purchase. The design looks cheaper than expected, and the material feels flimsy. Assembly was frustrating due to unclear instructions. Unfortunately, the table wobbles and doesn&#39;t feel stable. For the price, I expected better quality and craftsmanship.', '2024-12-10 06:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `subscription_id` int(11) NOT NULL,
  `profile_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id`, `firstName`, `lastName`, `email`, `password`, `created_at`, `subscription_id`, `profile_img`) VALUES
(1, 'pol', 'daniel', 'poldaniel@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2024-09-29 20:55:11', 0, ''),
(2, 'james', 'bond', 'jamesbond@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2024-09-29 20:55:11', 0, ''),
(3, 'paul daniel', 'ojales', 'sample@gmail.com', '5e8ff9bf55ba3508199d22e984129be6', '2024-09-29 14:14:30', 0, ''),
(4, 's', 's', 'staff@gmail.com', '1253208465b1efa876f982d8a9e73eef', '2024-10-10 07:17:10', 0, ''),
(6, 'paul daniel', 'ojales', 'p@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-11-30 08:08:26', 0, ''),
(17, 'paul daniel', 'ojales', '1@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', '2024-11-30 12:30:23', 0, ''),
(18, 'paul daniel', 'ojales', '2@gmail.com', 'c81e728d9d4c2f636f067f89cc14862c', '2024-12-01 21:35:59', 3, './profile_images/387512755_1407599433156736_1528413741543136407_n.jpg'),
(19, 'Subaru', 'Natsuki', 'pauldanielojales@gmail.com', 'fef9e90f2fe95dc53fbda9f3b8966742', '2024-12-08 13:19:46', 2, './profile_images/Chill_guy_original_artwork.jpg'),
(20, 'Monroe', 'Capellano', 'seller@gmail.com', '64c9ac2bb5fe46c3ac32844bb97be6bc', '2024-12-10 10:32:21', 3, './profile_images/pfp.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `name`, `start_date`, `end_date`) VALUES
(1, '1 month subscription', '2024-09-30', '2024-10-30'),
(2, '1 month subscription', '2024-10-30', '2024-11-30'),
(3, '2 months subscription', '2024-10-30', '2024-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `barangay_id`, `contact_number`, `email`, `password`, `created_at`) VALUES
(34, 'John Harold', 'Remigio', 30330, '', 'hotboyspicylava@gmail.com', '$2y$10$XvlXzfU4DQ.Y6f0m3bJO2uz94DIXeT..vs1WqHmluc9VP.qDax6IW', '2024-10-22 13:04:27'),
(35, 'Paul Daniel', 'Ojales', 30390, '', 'pauldanielojales@gmail.com', '$2y$10$EBH4F3Ppw9vwMjeM5fhvqebUmUQvmd3.ulL5ImGqk.1uzuXDobDDi', '2024-11-12 11:35:04'),
(36, 'dsvdsv', 'freddy', 30339, '', 'EMT@gmail.com', '$2y$10$qvNQ0nT.NpZQYu0x6PVFeuHwWTVExh3zGWOO2TWskFqdAAol.3hvC', '2024-11-13 05:25:46'),
(37, 'John Harold', 'Remigio', 30330, '', 'sample@gmail.com', '$2y$10$.52/LBFhZOKyhaLD56vEL.APt1uzJB82EzgLV1F/6ToH.Bor/tYQK', '2024-11-21 14:53:12'),
(38, 'test', 'ting', 30340, '', 'test@gmail.com', '$2y$10$llyjWnLMNpzvTNLHYCfstehPGqN7e0L/zowQDYQkEoqHeo4wzaQdW', '2024-11-28 13:40:56'),
(39, 'John Harold', 'Remigio', 30330, '', '1@gmail.com', '$2y$10$v2M2XVnvVRWWQZWkflybWOGsHepHLqKneLVU8v/yUk.3hi7JhtmTK', '2024-11-30 12:27:05'),
(41, 'John Harold', 'Remigio', 30330, '', 'johnharoldremigio@user.com', '$2y$10$X63xQx.5BHP36u0E1vUtwOAlAXxl4onj3c/J.Lgt/UuFqZTeR2V2G', '2024-12-08 10:50:08'),
(42, 'John Harold', 'Remigio', 30327, '', '11@gmail.com', '$2y$10$fAscRjzEtB8Y8wGXWHEUrOMFKVRnU17TuQ.XUKSXzLP31Y.916W9i', '2024-12-08 11:04:56'),
(47, 'are', 'no', 30340, '09175447598', 'bunny@gmail.com', '$2y$10$EL5UV.wMeJaIJTPvKrJhbui1aCo5QiCInnYfPziIAsYgGSfl2n5Fq', '2024-12-15 16:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_order`
--

INSERT INTO `user_order` (`id`, `user_id`, `date`, `total_cost`) VALUES
(61, 35, '2024-12-09', 1799.00),
(62, 35, '2024-12-09', 1799.00),
(63, 35, '2024-12-09', 1799.00),
(64, 35, '2024-12-09', 1799.00),
(65, 35, '2024-12-09', 1799.00),
(66, 35, '2024-12-09', 1799.00),
(67, 35, '2024-12-09', 1799.00),
(68, 35, '2024-12-09', 1799.00),
(69, 35, '2024-12-10', 29990.00),
(70, 41, '2024-12-10', 2999.00),
(71, 41, '2024-12-10', 8999.00),
(72, 41, '2024-12-10', 2000.00),
(73, 41, '2024-12-10', 500.00),
(74, 41, '2024-12-10', 8999.00),
(75, 35, '2024-12-10', 299.00),
(76, 35, '2024-12-11', 1799.00),
(77, 35, '2024-12-13', 5998.00),
(78, 35, '2024-12-14', 8999.00),
(79, 35, '2024-12-14', 4590.00),
(80, 41, '2024-12-14', 8999.00),
(81, 41, '2024-12-14', 2000.00),
(82, 41, '2024-12-14', 8999.00),
(83, 41, '2024-12-14', 2999.00),
(84, 35, '2024-12-15', 8999.00),
(85, 35, '2024-12-15', 2000.00),
(86, 35, '2024-12-17', 9180.00),
(87, 35, '2024-12-17', 26991.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_order_details`
--

CREATE TABLE `user_order_details` (
  `id` int(11) NOT NULL,
  `user_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('Pending','Completed','Canceled') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_order_details`
--

INSERT INTO `user_order_details` (`id`, `user_order_id`, `product_id`, `seller_id`, `quantity`, `status`, `user_id`) VALUES
(103, 82, 22, 19, 1, 'Completed', 41),
(104, 83, 23, 19, 1, 'Canceled', 41),
(105, 84, 22, 19, 1, 'Canceled', 35),
(106, 85, 21, 18, 5, 'Pending', 35),
(107, 86, 25, 20, 2, 'Canceled', 35),
(108, 87, 23, 19, 9, 'Completed', 35);

--
-- Triggers `user_order_details`
--
DELIMITER $$
CREATE TRIGGER `after_status_update` AFTER UPDATE ON `user_order_details` FOR EACH ROW BEGIN
    -- Check if the status has changed to 'Completed' or 'Canceled'
    IF NEW.status IN ('Completed', 'Canceled') THEN
        INSERT INTO order_history (
            product_id,
            user_id,
            date_ordered,
            date_completed, -- Keep 'date_completed'
            status,
            quantity,
            total_cost
        )
        VALUES (
            NEW.product_id, -- Use product_id from user_order_details
            NEW.user_id, -- Use user_id from user_order_details
            (SELECT date FROM user_order WHERE id = NEW.user_order_id), -- Get the order date from user_order
            NOW(), -- Set the current date for status change (either Completed or Canceled)
            NEW.status, -- Status from user_order_details
            NEW.quantity, -- Quantity from user_order_details
            (SELECT total_cost FROM user_order WHERE id = NEW.user_order_id) -- Get total cost from user_order
        );
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_order_details`
--
ALTER TABLE `user_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30414;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `user_order_details`
--
ALTER TABLE `user_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`id`);

--
-- Constraints for table `user_order_details`
--
ALTER TABLE `user_order_details`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
