-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 06:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_card` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `name_card`, `created_at`, `updated_at`) VALUES
(1, 'BCA', NULL, NULL),
(2, 'BRI', NULL, NULL),
(3, 'MANDIRI', NULL, NULL),
(4, 'OVO', NULL, NULL),
(5, 'GOPAY', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_category`, `created_at`, `updated_at`) VALUES
(1, 'Makanan', NULL, NULL),
(2, 'Minuman', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_01_17_150715_create_products_table', 1),
(6, '2022_01_17_151309_create_categories_table', 1),
(7, '2022_01_17_151322_create_orders_table', 1),
(8, '2022_01_17_153047_create_carts_table', 1),
(9, '2022_01_18_042414_create_settings_table', 1),
(10, '2022_01_19_070553_create_taxes_table', 1),
(11, '2022_01_24_175207_create_cards_table', 1),
(12, '2025_06_14_170203_create_order_items_table', 1),
(13, '2025_06_15_125750_create_tables_table', 1),
(14, '2025_06_15_145136_add_foreign_keys_to_orders_table', 1),
(15, '2025_06_17_150321_add_stock_to_products_table', 1),
(16, '2025_06_18_080723_add_qris_image_to_settings_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment` varchar(255) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `invoice`, `user_id`, `table_id`, `payment`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CUST-250617153224', NULL, NULL, 'pending', 28600.00, 'selesai', '2025-06-17 08:32:24', '2025-06-17 08:34:33'),
(2, 'INV250617160049', 1, NULL, 'debit', 30800.00, 'selesai', '2025-06-17 09:00:49', '2025-06-17 18:59:33'),
(3, 'INV250618015921', 1, NULL, 'tunai', 16500.00, 'selesai', '2025-06-17 18:59:21', '2025-06-17 18:59:39'),
(4, 'INV250618020401', 1, NULL, 'tunai', 30800.00, 'selesai', '2025-06-17 19:04:01', '2025-06-17 19:04:16'),
(5, 'CUST-250618074455', NULL, NULL, 'pending', 41800.00, 'selesai', '2025-06-18 00:44:55', '2025-06-18 01:03:40'),
(7, 'CUST-250618113502', NULL, NULL, 'pending', 48400.00, 'selesai', '2025-06-18 04:35:02', '2025-06-18 04:35:25'),
(8, 'CUST-250618114106', NULL, NULL, 'pending', 44000.00, 'selesai', '2025-06-18 04:41:06', '2025-06-18 04:41:35'),
(9, 'CUST-250618114257', NULL, NULL, 'pending', 39600.00, 'selesai', '2025-06-18 04:42:57', '2025-06-18 04:43:44'),
(10, 'CUST-250618114546', NULL, NULL, 'pending', 27500.00, 'selesai', '2025-06-18 04:45:46', '2025-06-18 05:06:58'),
(11, 'CUST-250618122301', NULL, NULL, 'pending', 81400.00, 'selesai', '2025-06-18 05:23:01', '2025-06-18 05:41:27'),
(12, 'INV250618124014', 1, NULL, 'cashless', 51700.00, 'habis', '2025-06-18 05:40:14', '2025-06-18 05:41:05'),
(13, 'INV250618125233', 1, NULL, 'cashless', 16500.00, 'selesai', '2025-06-18 05:52:33', '2025-06-18 05:52:44'),
(14, 'INV250618130515', 1, 2, 'tunai', 35200.00, 'selesai', '2025-06-18 06:05:15', '2025-06-18 06:07:37'),
(15, 'CUST-250618130713', NULL, 2, 'pending', 18700.00, 'selesai', '2025-06-18 06:07:13', '2025-06-18 06:07:40'),
(16, 'CUST-250618131224', NULL, 3, 'pending', 37400.00, 'selesai', '2025-06-18 06:12:24', '2025-06-18 06:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 13000.00, '2025-06-17 08:32:24', '2025-06-17 08:32:24'),
(2, 2, 1, 1, 13000.00, '2025-06-17 09:00:49', '2025-06-17 09:00:49'),
(3, 2, 3, 1, 15000.00, '2025-06-17 09:00:49', '2025-06-17 09:00:49'),
(4, 3, 3, 1, 15000.00, '2025-06-17 18:59:21', '2025-06-17 18:59:21'),
(5, 4, 1, 1, 13000.00, '2025-06-17 19:04:01', '2025-06-17 19:04:01'),
(6, 4, 3, 1, 15000.00, '2025-06-17 19:04:01', '2025-06-17 19:04:01'),
(7, 5, 1, 1, 13000.00, '2025-06-18 00:44:55', '2025-06-18 00:44:55'),
(8, 5, 9, 1, 25000.00, '2025-06-18 00:44:55', '2025-06-18 00:44:55'),
(11, 7, 5, 1, 19000.00, '2025-06-18 04:35:02', '2025-06-18 04:35:02'),
(12, 7, 9, 1, 25000.00, '2025-06-18 04:35:02', '2025-06-18 04:35:02'),
(13, 8, 4, 1, 15000.00, '2025-06-18 04:41:06', '2025-06-18 04:41:06'),
(14, 8, 9, 1, 25000.00, '2025-06-18 04:41:06', '2025-06-18 04:41:06'),
(15, 9, 5, 1, 19000.00, '2025-06-18 04:42:57', '2025-06-18 04:42:57'),
(16, 9, 2, 1, 17000.00, '2025-06-18 04:42:57', '2025-06-18 04:42:57'),
(17, 10, 9, 1, 25000.00, '2025-06-18 04:45:46', '2025-06-18 04:45:46'),
(18, 11, 4, 1, 15000.00, '2025-06-18 05:23:01', '2025-06-18 05:23:01'),
(19, 11, 9, 1, 25000.00, '2025-06-18 05:23:01', '2025-06-18 05:23:01'),
(20, 11, 5, 1, 19000.00, '2025-06-18 05:23:01', '2025-06-18 05:23:01'),
(21, 11, 3, 1, 15000.00, '2025-06-18 05:23:01', '2025-06-18 05:23:01'),
(22, 12, 3, 2, 15000.00, '2025-06-18 05:40:14', '2025-06-18 05:40:14'),
(23, 12, 2, 1, 17000.00, '2025-06-18 05:40:14', '2025-06-18 05:40:14'),
(24, 13, 3, 1, 15000.00, '2025-06-18 05:52:33', '2025-06-18 05:52:33'),
(25, 14, 2, 1, 17000.00, '2025-06-18 06:05:15', '2025-06-18 06:05:15'),
(26, 14, 3, 1, 15000.00, '2025-06-18 06:05:15', '2025-06-18 06:05:15'),
(27, 15, 2, 1, 17000.00, '2025-06-18 06:07:13', '2025-06-18 06:07:13'),
(28, 16, 4, 1, 15000.00, '2025-06-18 06:12:24', '2025-06-18 06:12:24'),
(29, 16, 5, 1, 19000.00, '2025-06-18 06:12:24', '2025-06-18 06:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_product` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `discount` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name_product`, `category_id`, `price`, `stock`, `discount`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Ayam goreng', 1, 13000, 0, '0', '<p>sample</p>', 'ayam.png', NULL, '2025-06-18 00:44:55'),
(2, 'Nasi goreng', 1, 17000, 11, '0', '<p>sample</p>', 'ayam.png', NULL, '2025-06-18 06:07:13'),
(3, 'Mie goreng', 1, 15000, 6, '0', '<p>sample</p>', 'ayam.png', NULL, '2025-06-18 06:05:15'),
(4, 'Ayam bakar', 1, 15000, 12, '0', '<p>sample</p>', 'ayam.png', NULL, '2025-06-18 06:12:24'),
(5, 'Ikan bakar', 1, 19000, 11, '0', '<p>sample</p>', 'ayam.png', NULL, '2025-06-18 06:12:24'),
(9, 'Dimsum', 1, 25000, 0, '0', '<p>Isi 5</p>', 'dimsum (1).jpg', '2025-06-17 19:37:19', '2025-06-18 05:23:01');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `qris_image` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `address`, `images`, `qris_image`, `instagram`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'CAFFEE_IN', 'JL IN Aja Dulu', '1750231438_logocaffein.png', '1750248304_qris.jpg', 'mhilmanrz', '081296723674', '2025-06-17 08:29:01', '2025-06-18 05:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'MEJA 1', '2025-06-17 08:30:39', '2025-06-17 08:30:39'),
(2, 'MEJA 2', '2025-06-17 08:30:47', '2025-06-17 08:30:47'),
(3, 'MEJA 3', '2025-06-17 08:30:55', '2025-06-17 08:30:55'),
(4, 'MEJA 4', '2025-06-18 06:34:59', '2025-06-18 06:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Diskon awal bulan', '10', '2025-06-17 08:29:01', '2025-06-17 08:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'kasir',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$PdMukRRSBkLwMUr2aIlEJ.ZfwcffzjEqgol6e9OZQ51r0db4U2awm', 'admin', NULL, '2025-06-17 08:29:45', '2025-06-17 08:29:45'),
(2, 'Kasir', 'kasir@gmail.com', NULL, '$2y$10$at80B5dvp7OdDnts/9Vb3efUjPb5miLgw0tsCQXjL61L2Z0KQFf5u', 'kasir', NULL, '2025-06-17 19:48:30', '2025-06-17 19:48:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_unique` (`invoice`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_table_id_foreign` (`table_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
