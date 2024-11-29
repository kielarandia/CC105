-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 09:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eorcon`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `address`) VALUES
(11, '13', 'JP Rizal San Luis');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `gcash_qr` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `gcash_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `gcash_qr`, `account_name`, `gcash_number`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'ezek.jpg', 'Escalante Garments Trading', '09953557415'),
(4, 'staff002', '01cfcd4f6b8770febfb40cb906715822', '', '', ''),
(5, 'staff003', '827ccb0eea8a706c4c34a16891f84e7b', '', '', ''),
(6, 'staff03', '01cfcd4f6b8770febfb40cb906715822', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `announcements_tb`
--

CREATE TABLE `announcements_tb` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements_tb`
--

INSERT INTO `announcements_tb` (`id`, `title`, `content`, `created_at`) VALUES
(3, 'Announcement 1:', '🛍️✨ Discover the Latest Fashion at [Your Garment Store Name]! ✨🛍️\r\n\r\nLooking for stylish and comfortable outfits? Visit our garment store today for a wide selection of trendy clothing for all ages. From casual wear to office attire, we have everything you need to stay fashionable and confident. Experience top-quality products at great prices!\r\n\r\n⏰ Store Hours: Monday to Saturday: 9 AM - 7 PM\r\nSunday: 10 AM - 5 PM', '2024-10-22 06:50:28'),
(4, 'Announcement 2: 🌟 PROMO ALERT! 🌟', '👗👚 Buy 2, Get 1 Free! 👖👕\r\n\r\nShop now and get a free item when you buy any 2 garments! Take advantage of this special limited-time offer and update your wardrobe with the latest styles without overspending. Don’t miss out – visit us today and save big on your favorite clothing!\r\n\r\n📍 Location: [Your Address]\r\n📞 Contact Us: (123) 456-7890', '2024-10-22 06:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_tb`
--

CREATE TABLE `cms_tb` (
  `id` int(11) NOT NULL,
  `home_details` text NOT NULL,
  `about_details` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cms_tb`
--

INSERT INTO `cms_tb` (`id`, `home_details`, `about_details`) VALUES
(1, 'Style, Quality & Comfort', '? Elevate Your Style at ESCALANTE GARMENTS TRADING! ?\r\n\r\nExperience the finest selection of high-quality garments, crafted with precision and care. From trendy everyday wear to elegant pieces for special occasions, every stitch reflects our commitment to quality and style. Step into a world of comfort and fashion where each outfit tells a story of craftsmanship and attention to detail. Visit our store today – where your wardrobe dreams come true!');

-- --------------------------------------------------------

--
-- Table structure for table `file_tb`
--

CREATE TABLE `file_tb` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `date_upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`, `timestamp`) VALUES
(1, 0, 'Ezekiel Arandia', 'ezyarandia@gmail.com', '09952925528', 'FSDSDFSDFSD', '2024-11-28 17:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(11) NOT NULL,
  `placed_on` varchar(255) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `order_id` varchar(255) NOT NULL,
  `reference_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `order_id`, `reference_no`) VALUES
(55, 14, 'Ezekiel Arandia', '0995355741', 'ezyarandia@gmail.com', 'cash on delivery', 'Balite Site (Main Address)', 'Jersey Uniforms (700.00 x 1   ) - ', 770, '2024-11-29', 'pending', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `user_id`, `pid`, `name`, `price`, `quantity`, `note`) VALUES
(74, '1', 14, 11, 'Basketball Shorts #Green', 250, 1, ''),
(75, '1', 14, 12, 'Small Keychain', 75, 1, ''),
(76, '1', 14, 12, 'Small Keychain', 75, 1, ''),
(77, '1', 14, 10, 'Jersey Uniforms', 700, 1, ''),
(78, '53', 14, 11, 'Sublimated Polo Shirt', 500, 1, ''),
(79, '54', 14, 12, 'Small Keychain', 75, 1, ''),
(80, '1', 14, 10, 'Jersey Uniforms', 700, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `stock_out` varchar(255) NOT NULL DEFAULT '0',
  `discount_qnty` varchar(255) NOT NULL DEFAULT '0',
  `discount_price` varchar(255) NOT NULL DEFAULT '0',
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `stock`, `image_01`, `image_02`, `image_03`, `stock_out`, `discount_qnty`, `discount_price`, `category`) VALUES
(10, 'Jersey Uniforms', '🏀 Show your team pride with the iconic Lakers jersey uniform, featuring a sleek design and comfortable fit for every fan!', 700, 100, 'fullset.png', 'downloadd.jpeg', 'download.jpeg', '0', '0', '0', 'Garments'),
(11, 'Sublimated Polo Shirt', 'Create your unique style with high-quality sublimated polo shirts, tailored to your design preferences. Durable, vibrant, and breathable, these shirts are perfect for teams, businesses, or personal use. Stand out with unlimited colors and patterns that won’t fade or peel!', 500, 100, 'sublitshirt.png', 'fronttshirt.jpg', 'backtshirt.jpg', '0', '0', '0', 'Garments'),
(12, 'Small Keychain', '🔑 Keep your keys organized with our compact and stylish small keychain, perfect for adding a touch of personality wherever you go!', 75, 100, 'keychain.jpg', 'keychain_3.jpg', 'keychain_2.jpg', '0', '0', '0', 'Souvenirs'),
(13, 'Pesonalize Mug', 'Add a personal touch to your coffee or tea time with customized mugs! Perfect for gifts, promotions, or personal use, these durable mugs showcase your unique designs, logos, or messages in vibrant, long-lasting prints.', 280, 100, 'mug.png', '', '', '0', '0', '0', ''),
(14, 'Personalized Id lace', 'Keep your essentials secure in style with customized ID laces! Perfect for schools, offices, or events, these durable and comfortable lanyards can feature your logo, name, or design in vibrant, high-quality prints.', 50, 100, 'idlace.png', 'lace.jpg', 'laces.jpg', '0', '0', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `Status` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact_Number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `code`, `Status`, `Address`, `Contact_Number`) VALUES
(14, 'Ezekiel Arandia', 'ezyarandia@gmail.com', '2407eacebdaaf440f3c23ecdc53d0153', '43817', 1, 'Balite Site', '09953557415');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements_tb`
--
ALTER TABLE `announcements_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_tb`
--
ALTER TABLE `cms_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_tb`
--
ALTER TABLE `file_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `announcements_tb`
--
ALTER TABLE `announcements_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cms_tb`
--
ALTER TABLE `cms_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `file_tb`
--
ALTER TABLE `file_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
