-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 03:56 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `budget`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `book_desc` varchar(100) NOT NULL,
  `book_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `user_id`, `book_name`, `category_id`, `book_desc`, `book_date`) VALUES
(15, 6, 'rteewedittt kk', 2, 'ueeerf  efiuef', '2022-06-17 17:32:53'),
(17, 6, 'A matyr', 1, 'From my warning vvv', '2022-06-17 17:09:16'),
(18, 5, 'New Admin Book', 1, 'The salary of admin', '2022-05-10 19:11:15'),
(19, 5, 'Admin Expenditure', 2, 'The expenses of admin', '2022-05-10 19:15:27'),
(22, 5, 'Test Book dghabjsak sjkasajknsnajs ajksnajn sakjs ', 1, 'Test Book dghabjsak sjkasajknsnajs ajksnajn sakjs akj sjabsjabnsakjnsja sjasbakjnskajnska sak jsakjn', '2022-05-17 15:08:16'),
(26, 6, 'Deded', 2, '2', '2022-06-17 16:43:31'),
(36, 6, 'Cloudware Technologies', 2, 'hjdfytfkugihlo ugiholgiu', '2022-06-22 13:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_desc`) VALUES
(1, 'Income', 'Record and track your cash inflow'),
(2, 'Expenditure', 'Track and see how deep you\'re eating your money');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `sub_category_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_category_id`, `category_id`, `sub_category_name`) VALUES
(1, 1, 'January'),
(2, 2, 'Loan'),
(3, 2, 'Test sub'),
(4, 2, 'Entertainment'),
(5, 2, 'Transport'),
(6, 2, 'Food'),
(7, 2, 'Groceries'),
(8, 2, 'Health'),
(9, 2, 'Housing'),
(10, 2, 'Personal Care'),
(11, 2, 'Phone & Internet'),
(12, 2, 'Utilities'),
(13, 2, 'Savings'),
(14, 2, 'Transfer'),
(15, 2, 'Atm Withdrawal'),
(16, 2, 'Gifts & Donation'),
(17, 2, 'Online Transaction'),
(18, 2, 'Shopping'),
(19, 2, 'Travel'),
(20, 2, 'Education'),
(21, 2, 'Betting'),
(22, 2, 'Loan Payment'),
(23, 1, 'Wages'),
(24, 1, 'Salary'),
(25, 1, 'Commission'),
(26, 1, 'Interest'),
(27, 1, 'Investment'),
(28, 1, 'Gift'),
(29, 1, 'Allowance'),
(30, 1, 'Grants');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT 'debit or credit',
  `sub_category_id` int(11) NOT NULL,
  `transaction_amount` varchar(20) NOT NULL,
  `transaction_desc` varchar(100) NOT NULL,
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `book_id`, `type`, `sub_category_id`, `transaction_amount`, `transaction_desc`, `transaction_date`) VALUES
(6, 6, 15, 1, 3, '45000', 'kjsfbuvbfiubuibubffdv', '2022-05-10 16:27:05'),
(7, 6, 15, 1, 2, '100000', 'Prune man!', '2022-05-10 16:28:01'),
(8, 6, 17, 1, 14, '2000111', 'Yeah yeah, I edited this', '2022-05-10 16:30:28'),
(9, 6, 17, 0, 27, '5098899', 'hjy', '2022-05-10 17:02:30'),
(10, 6, 15, 1, 2, '43333', 'sfvfb', '2022-05-10 17:08:14'),
(11, 6, 15, 1, 3, '8797889', 'jvbkvbk', '2022-05-10 17:40:50'),
(12, 6, 15, 0, 2, '190', 'Airtime ni o', '2022-05-10 17:45:25'),
(13, 5, 18, 1, 1, '60000', 'Income by January', '2022-05-10 20:10:32'),
(28, 5, 19, 0, 2, '9247000', 'my new transaction', '2022-05-12 09:58:33'),
(29, 5, 19, 0, 2, '84503', 'New desc', '2022-05-12 13:18:55'),
(30, 5, 19, 0, 21, '7001', 'edited desc', '2022-05-12 13:20:55'),
(33, 6, 17, 0, 25, '4000', 'eer', '2022-06-17 15:38:23'),
(35, 6, 17, 0, 27, '4555', 'aayyy', '2022-06-17 15:39:26'),
(41, 6, 17, 0, 27, '4465', 'hju', '2022-06-17 16:33:40'),
(44, 6, 17, 0, 25, '44444', 'ddddd', '2022-06-19 19:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `date_registered`) VALUES
(5, 'admin', 'admin', 'admin@budget.com', '$2y$10$kKzuMxuxigEvMCU3th/Dj.HlFwknFHZZYYLvg.jSXzqdQ3wkbA7fi', '2022-05-07 20:58:39'),
(6, 'Timothy', 'Adeleke', 'dev@budget.com', '$2y$10$kKzuMxuxigEvMCU3th/Dj.HlFwknFHZZYYLvg.jSXzqdQ3wkbA7fi', '2022-05-08 18:18:04'),
(11, 'James', 'Robert', 'timothy.adeleke@cloudware.ng', '$2y$10$kAU.SrpcK/Eh9mnGONBlE.8W4F5Hjp4YawqqutW7ui6HysVObLp9G', '2022-06-17 14:18:25'),
(12, 'James', 'Robert', 'james@budget.com', '$2y$10$xRUwCp/6SbjEQcKUAwboRuSzGN6LGCxERVa2qq8tZyHNBCtMEypii', '2022-06-22 13:29:46'),
(13, 'James', 'Robert', 'rob@budget.com', '$2y$10$3YW7hK1fDn8ToaAckqKqcuXw66nTTQEHCEnI0noFphA8HcQekC.He', '2022-06-22 13:40:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `books_ibfk_1` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`sub_category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transactions_ibfk_1` (`book_id`),
  ADD KEY `transactions_ibfk_3` (`user_id`),
  ADD KEY `sub_category_id` (`sub_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_4` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`sub_category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
