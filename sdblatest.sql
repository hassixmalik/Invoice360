-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.25-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_cignadlte
CREATE DATABASE IF NOT EXISTS `db_cignadlte` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_cignadlte`;

-- Dumping structure for table db_cignadlte.billing_address
CREATE TABLE IF NOT EXISTS `billing_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_unique_id` int(11) DEFAULT NULL,
  `attention` varchar(255) DEFAULT NULL,
  `country_region` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax_number` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_unique_id` (`customer_unique_id`),
  CONSTRAINT `billing_address_ibfk_1` FOREIGN KEY (`customer_unique_id`) REFERENCES `new_customer` (`customer_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.billing_address: ~3 rows (approximately)
INSERT INTO `billing_address` (`id`, `customer_unique_id`, `attention`, `country_region`, `address`, `city`, `state`, `zipcode`, `phone`, `fax_number`) VALUES
	(3, 3, '', 'Capital Territory', 'Street 6, house no 19 - Sector f8/3', 'Islamabad', 'Capital Territory', '44210', '', ''),
	(4, 2, '', 'Capital Territory', 'Street 6, house no 19 - Sector f8/3', 'Islamabad', 'Capital Territory', '44210', '', ''),
	(5, 5, '', 'Bahrain', 'Avenue Mall', 'Manama', 'Bahrain', '', '', '');

-- Dumping structure for table db_cignadlte.due_payments
CREATE TABLE IF NOT EXISTS `due_payments` (
  `due_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT NULL,
  `due_date` date NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `status` enum('Pending','Overdue') DEFAULT 'Pending',
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`due_payment_id`),
  KEY `quotation_id` (`quotation_id`),
  KEY `due_payments_ibfk_2` (`invoice_id`),
  CONSTRAINT `due_payments_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`quotation_id`),
  CONSTRAINT `due_payments_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.due_payments: ~2 rows (approximately)
INSERT INTO `due_payments` (`due_payment_id`, `quotation_id`, `due_date`, `amount_due`, `status`, `invoice_id`) VALUES
	(8, NULL, '2024-07-31', 196.00, 'Pending', 20),
	(9, NULL, '2024-07-31', 300.00, 'Pending', 22);

-- Dumping structure for table db_cignadlte.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_unique_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `salesperson` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` enum('Draft','Invoiced','Paid','Overdue') DEFAULT 'Draft',
  `payment_due` int(11) DEFAULT NULL,
  PRIMARY KEY (`invoice_id`),
  UNIQUE KEY `invoice_no` (`invoice_no`),
  KEY `customer_unique_id` (`customer_unique_id`),
  KEY `payment_due` (`payment_due`),
  CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`customer_unique_id`) REFERENCES `new_customer` (`customer_unique_id`),
  CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`payment_due`) REFERENCES `due_payments` (`due_payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.invoices: ~4 rows (approximately)
INSERT INTO `invoices` (`invoice_id`, `customer_unique_id`, `invoice_no`, `order_no`, `invoice_date`, `expiry_date`, `salesperson`, `project_name`, `subject`, `status`, `payment_due`) VALUES
	(19, 3, '09', '123', '2024-07-23', '2024-07-17', 'Ahmed', 'Naeem Machine Repairing', 'swimming pool cleaining', 'Draft', NULL),
	(20, 3, '786', '1222', '2024-07-23', '2024-07-31', 'Ahmed', 'Naeem Machine Repairing', 'swimming pool cleaining', 'Invoiced', NULL),
	(21, 5, '33', '1222', '2024-07-23', '2024-07-31', 'Ahmed', 'Naeem Machine Repairing', 'swimming pool cleaining', 'Invoiced', NULL),
	(22, 3, '1455', '1222', '2024-07-26', '2024-07-31', 'Hassan', 'Joe\'s Cafe', 'pool cleaning and maintanence.', 'Invoiced', NULL);

-- Dumping structure for table db_cignadlte.items
CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT NULL,
  `service_description` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `quotation_id` (`quotation_id`),
  KEY `items_ibfk_2` (`invoice_id`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`quotation_id`),
  CONSTRAINT `items_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.items: ~15 rows (approximately)
INSERT INTO `items` (`item_id`, `quotation_id`, `service_description`, `area`, `qty`, `price`, `amt`, `sub_total`, `invoice_id`) VALUES
	(4, 23, 'abc', 'swimming pool', 1, 200.00, 200.00, 200.00, NULL),
	(6, 23, 'abc', 'swimming pool', 1, 200.00, 200.00, 200.00, 19),
	(7, 24, 'abc\r\nabc\r\nffffffffffffffffffffffffff', 'swimming pool', 1, 200.00, 200.00, 290.00, NULL),
	(8, 24, 'abc', 'swimming pool', 45, 2.00, 90.00, 290.00, NULL),
	(11, 24, 'abc\r\nabc\r\nffffffffffffffffffffffffff', 'swimming pool', 1, 200.00, 200.00, 1196.00, 20),
	(12, 24, 'abc', 'swimming pool', 45, 2.00, 90.00, 1196.00, 20),
	(13, 24, 'abc', 'swimming pool', 4, 19.00, 76.00, 1196.00, 20),
	(14, 24, 'xyz', 'pool', 23, 10.00, 230.00, 1196.00, 20),
	(15, 24, 'ABC', 'area', 10, 10.00, 100.00, 1196.00, 20),
	(16, 24, 'xyz', 'abc', 10, 30.00, 300.00, 1196.00, 20),
	(17, 24, 'xyz', 'abc', 10, 20.00, 200.00, 1196.00, 20),
	(18, 25, 'Double Door, freezer Gas Kit', 'Kitchen', 2, 35.00, 70.00, 150.00, 21),
	(19, 25, 'Heater change', 'Kitchen', 2, 40.00, 80.00, 150.00, 21),
	(22, 24, 'abc', 'Kitchen', 6, 50.00, 300.00, 500.00, 22),
	(23, 24, 'cfg', 'pool', 10, 20.00, 200.00, 500.00, 22);

-- Dumping structure for table db_cignadlte.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` enum('top','left') NOT NULL DEFAULT 'left',
  `name` varchar(100) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(30) NOT NULL DEFAULT 'far fa-circle',
  `is_last` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.menus: ~15 rows (approximately)
INSERT INTO `menus` (`id`, `parent_id`, `position`, `name`, `slug`, `link`, `icon`, `is_last`, `is_active`) VALUES
	(1, NULL, 'left', 'Starter Page', 'starter', 'starter', 'fas fa-tachometer-alt', 1, 1),
	(2, NULL, 'left', 'Tables', 'table', '#', 'fas fa-table', 0, 1),
	(3, 2, 'left', 'Simple Table', 'simple_table', 'tables/simple', 'far fa-circle', 1, 1),
	(4, 2, 'left', 'Datatables', 'dtables', 'tables/dtables', 'far fa-circle', 1, 1),
	(5, 2, 'left', 'JqGrid', 'jqgrid', 'tables/jqgrid', 'far fa-circle', 1, 1),
	(6, NULL, 'left', 'Level 1', 'level_1', '#', 'fas fa-circle', 0, 1),
	(7, 6, 'left', 'Level 2', 'level_2', '#', 'far fa-circle', 1, 1),
	(8, 6, 'left', 'Level 2', 'level_2', '#', 'far fa-circle', 0, 1),
	(9, 8, 'left', 'Level 3', 'level_3', '#', 'fas fa-circle', 1, 1),
	(10, NULL, 'top', 'Home', 'home', '#', 'far fa-circle', 1, 1),
	(11, NULL, 'top', 'Contact', 'contact', '#', 'far fa-circle', 1, 1),
	(12, NULL, 'left', 'Extra', 'extra', '#', 'far fa-plus-square', 0, 1),
	(13, 12, 'left', 'Login', 'login', 'login', 'far fa-circle', 1, 1),
	(14, 12, 'left', 'Register', 'register', 'register', 'far fa-circle', 1, 1),
	(15, NULL, 'left', 'CRUD', 'crud', 'crud', 'far fa-circle', 1, 1);

-- Dumping structure for table db_cignadlte.new_customer
CREATE TABLE IF NOT EXISTS `new_customer` (
  `customer_unique_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_type` enum('Business','Individual') NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `customer_display_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `recievables` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`customer_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.new_customer: ~4 rows (approximately)
INSERT INTO `new_customer` (`customer_unique_id`, `customer_type`, `customer_name`, `company_name`, `customer_display_name`, `customer_email`, `customer_phone`, `recievables`) VALUES
	(2, 'Business', 'Muhammad Hassan Raza', 'Air University Islamabad', 'Hassi', 'hassi.x.malik@gmail.com', '03181400912', 0.00),
	(3, 'Individual', 'Saleem', 'NMR', 'Naeem Machine reparing', 'nmr@gmail.com', '1234567890', 0.00),
	(4, 'Business', 'Mr Saeed', 'Joe\'s Cafe', 'Joe\'s Cafe', 'joescafe@gmail.com', '1234567890', 0.00),
	(5, 'Business', 'Mr Sagar', 'Joe\'s Cafe', 'Joe\'s Cafe', 'mrsagar@gmail.com', '36400607', 0.00);

-- Dumping structure for table db_cignadlte.other_details_of_customer
CREATE TABLE IF NOT EXISTS `other_details_of_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_unique_id` int(11) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `opening_balance` decimal(10,2) DEFAULT 0.00,
  `payment_terms` varchar(255) DEFAULT NULL,
  `documents` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_unique_id` (`customer_unique_id`),
  CONSTRAINT `other_details_of_customer_ibfk_1` FOREIGN KEY (`customer_unique_id`) REFERENCES `new_customer` (`customer_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.other_details_of_customer: ~0 rows (approximately)
INSERT INTO `other_details_of_customer` (`id`, `customer_unique_id`, `currency`, `opening_balance`, `payment_terms`, `documents`) VALUES
	(5, 5, 'BHD', 0.00, '', '');

-- Dumping structure for table db_cignadlte.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` varchar(50) NOT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount_received` decimal(10,2) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `notes` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `quotation_id` (`quotation_id`),
  KEY `payments_ibfk_2` (`invoice_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`quotation_id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.payments: ~2 rows (approximately)
INSERT INTO `payments` (`payment_id`, `quotation_id`, `payment_date`, `amount_received`, `invoice_id`, `notes`) VALUES
	('9087', NULL, '2024-07-26', 200.00, 22, ''),
	('92bf', NULL, '2024-07-26', 1000.00, 20, '');

-- Dumping structure for table db_cignadlte.quotations
CREATE TABLE IF NOT EXISTS `quotations` (
  `quotation_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_unique_id` int(11) DEFAULT NULL,
  `quotation_no` varchar(50) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `quote_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `salesperson` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` enum('Draft','Invoiced','Paid','Overdue') DEFAULT 'Draft',
  PRIMARY KEY (`quotation_id`),
  UNIQUE KEY `quotation_no` (`quotation_no`),
  KEY `customer_unique_id` (`customer_unique_id`),
  CONSTRAINT `quotations_ibfk_1` FOREIGN KEY (`customer_unique_id`) REFERENCES `new_customer` (`customer_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.quotations: ~3 rows (approximately)
INSERT INTO `quotations` (`quotation_id`, `customer_unique_id`, `quotation_no`, `reference_no`, `quote_date`, `expiry_date`, `salesperson`, `project_name`, `subject`, `status`) VALUES
	(23, 3, '123', '00', '2024-07-23', '2024-07-17', 'Ahmed', 'Naeem Machine Repairing', 'swimming pool cleaining', 'Invoiced'),
	(24, 3, '1222', '00', '2024-07-23', '2024-07-31', 'Ahmed', 'Naeem Machine Repairing', 'swimming pool cleaining', 'Invoiced'),
	(25, 5, '1885', '00', '2024-07-23', '2024-08-07', 'Saleem', 'Joe\'s Cafe', ' Double Door, freezer, Gas Kit, and Heater change', 'Draft');

-- Dumping structure for table db_cignadlte.shipping_address
CREATE TABLE IF NOT EXISTS `shipping_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_unique_id` int(11) DEFAULT NULL,
  `attention` varchar(255) DEFAULT NULL,
  `country_region` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax_number` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_unique_id` (`customer_unique_id`),
  CONSTRAINT `shipping_address_ibfk_1` FOREIGN KEY (`customer_unique_id`) REFERENCES `new_customer` (`customer_unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.shipping_address: ~0 rows (approximately)
INSERT INTO `shipping_address` (`id`, `customer_unique_id`, `attention`, `country_region`, `address`, `city`, `state`, `zipcode`, `phone`, `fax_number`) VALUES
	(1, 5, '', '', '', '', '', '', '', '');

-- Dumping structure for table db_cignadlte.terms_and_conditions
CREATE TABLE IF NOT EXISTS `terms_and_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotation_id` (`quotation_id`),
  KEY `terms_and_conditions_ibfk_2` (`invoice_id`),
  CONSTRAINT `terms_and_conditions_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`quotation_id`),
  CONSTRAINT `terms_and_conditions_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.terms_and_conditions: ~3 rows (approximately)
INSERT INTO `terms_and_conditions` (`id`, `quotation_id`, `terms`, `invoice_id`) VALUES
	(2, 23, 'tc', NULL),
	(3, 24, 'tc', NULL),
	(4, 25, 'tc', NULL);

-- Dumping structure for table db_cignadlte.test_crud
CREATE TABLE IF NOT EXISTS `test_crud` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table db_cignadlte.test_crud: ~2 rows (approximately)
INSERT INTO `test_crud` (`id`, `name`, `about`, `created_at`) VALUES
	(1, 'John Doe', 'Just human being', '2024-03-01 06:09:35'),
	(4, 'John Doe', 'Just human being', '2024-03-01 06:20:54');

-- Dumping structure for table db_cignadlte.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_username` (`username`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_cignadlte.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
