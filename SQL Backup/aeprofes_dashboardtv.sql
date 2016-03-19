-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 09, 2015 at 10:54 AM
-- Server version: 5.5.42-37.1-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aeprofes_dashboardtv`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessing`
--

DROP TABLE IF EXISTS `accessing`;
CREATE TABLE IF NOT EXISTS `accessing` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NOT NULL,
  `refresh_token` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `expires` varchar(30) NOT NULL,
  PRIMARY KEY (`token_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `accessing`
--

INSERT INTO `accessing` (`token_id`, `token`, `refresh_token`, `created_at`, `expires`) VALUES
(2, '2e99d4ef-5b4e-4914-b5ad-737408d4226c', '81947277-9668-4847-a73e-5215035da7f4', '11/24/2015 6:30 AM', '11/24/2015 2:30 PM'),
(4, '767ac1ab-19d9-4d09-ae33-4578a3fb80dd', 'd6e82d0e-eb56-4c16-afc3-5890498294ef', '11/25/2015 6:20 AM', '11/25/2015 2:20 PM'),
(6, '18e5f9e2-00e3-4efa-8c22-d677974e96d8', 'eec26069-c000-4f24-b8d5-6ac5cdfef384', '11/26/2015 6:16 AM', '11/26/2015 2:16 PM'),
(7, 'bd638854-24b0-4f38-aade-b9ae44db1877', 'eec26069-c000-4f24-b8d5-6ac5cdfef384', '11/26/2015 3:12 PM', '11/26/2015 11:12 PM'),
(8, '59e08c15-3b53-4c5f-af2a-e02a49892db3', '747faebd-9d59-4eb1-82b6-daf94c592321', '11/27/2015 7:12 AM', '11/27/2015 3:12 PM'),
(9, 'f71be0bc-4a2b-4c04-9d85-7f8af5cdeb60', '747faebd-9d59-4eb1-82b6-daf94c592321', '11/27/2015 6:00 PM', '11/28/2015 2:00 AM'),
(10, 'be8ee60f-f4e9-427a-a67f-ec00d330b587', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '11/28/2015 6:17 AM', '11/28/2015 2:17 PM'),
(11, 'c1a87375-7394-4acf-810b-c515ebc01945', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '11/28/2015 7:00 AM', '11/28/2015 3:00 PM'),
(12, 'aeafea26-003a-4d9b-83ff-648085f81611', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '11/29/2015 6:00 AM', '11/29/2015 2:00 PM'),
(13, 'b3f8d852-47ac-4db2-9d80-ea8c7f7dcd41', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '11/29/2015 6:15 PM', '11/30/2015 2:15 AM'),
(14, 'a1ed2807-1ef1-4fb9-b140-0f613681d830', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '11/30/2015 12:00 AM', '11/30/2015 8:00 AM'),
(15, 'f97c90ff-d02e-462f-aadf-fb8498a8b8ab', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '11/30/2015 6:00 AM', '11/30/2015 2:00 PM'),
(16, '0967d3db-b498-4f2f-bb84-4578b741f2bf', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/01/2015 12:00 AM', '12/01/2015 8:00 AM'),
(17, 'caeef51b-6d5e-4841-b024-7d6b82d56e98', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/01/2015 6:00 AM', '12/01/2015 2:00 PM'),
(18, 'bcd252d3-c3cd-4c37-9ff4-5bc92237a178', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/01/2015 5:15 PM', '12/02/2015 1:15 AM'),
(19, '8cf27d5f-484f-4a5b-9411-e8158d5c1239', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/02/2015 3:00 AM', '12/02/2015 11:00 AM'),
(20, '3743d10c-9371-4720-903c-63b6831909cd', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/02/2015 9:00 AM', '12/02/2015 5:00 PM'),
(21, '2250c403-b6bd-4a6c-bf93-9a8f69b66042', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/02/2015 5:01 PM', '12/03/2015 1:01 AM'),
(22, '6b2005af-7c79-450b-b462-0b3b9e1ed367', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/03/2015 3:00 AM', '12/03/2015 11:00 AM'),
(23, '1d59e3ad-4d70-4f01-be4e-b9b0ad66e5bf', 'd2490f09-1e7d-44fb-b2aa-d5cc48056187', '12/03/2015 9:00 AM', '12/03/2015 5:00 PM'),
(29, '8e6be118-3263-4a89-88f5-75e20abb2480', 'fda4ceb2-e85e-46ce-a251-d32d107c5671', '12/04/2015 4:26 PM', '12/05/2015 12:26 AM'),
(30, '455b2f53-7c5c-4036-9c69-c20e504db509', 'fda4ceb2-e85e-46ce-a251-d32d107c5671', '12/05/2015 3:00 AM', '12/05/2015 11:00 AM'),
(31, '42d0ac32-a9cf-4af4-a128-fac15de30ad5', 'fda4ceb2-e85e-46ce-a251-d32d107c5671', '12/05/2015 9:00 AM', '12/05/2015 5:00 PM'),
(32, 'd5768eb2-0757-4d58-b955-489a8030bc64', 'fda4ceb2-e85e-46ce-a251-d32d107c5671', '12/06/2015 3:00 AM', '12/06/2015 11:00 AM'),
(33, 'd11bcc8f-3488-474e-9644-d2cb30974835', 'fda4ceb2-e85e-46ce-a251-d32d107c5671', '12/06/2015 9:00 AM', '12/06/2015 5:00 PM'),
(36, 'e2d759ef-af26-4094-b4a1-3a0463fab1ce', 'f8c81d8d-447f-4ad8-9310-1555c23fc462', '12/07/2015 11:11 AM', '12/07/2015 7:11 PM'),
(37, '4eb1db02-5618-46f9-a74f-332ffd1b6aa0', 'f8c81d8d-447f-4ad8-9310-1555c23fc462', '12/08/2015 3:00 AM', '12/08/2015 11:00 AM'),
(38, 'a1c379d4-7611-43f9-bf3f-8f3015589155', 'f8c81d8d-447f-4ad8-9310-1555c23fc462', '12/08/2015 9:00 AM', '12/08/2015 5:00 PM'),
(39, '2bde7477-10ef-402f-bab4-5c948e52d1a2', 'f8c81d8d-447f-4ad8-9310-1555c23fc462', '12/08/2015 5:01 PM', '12/09/2015 1:01 AM'),
(40, '3267e63a-663a-4501-b5fc-27eee9a26adb', 'f8c81d8d-447f-4ad8-9310-1555c23fc462', '12/09/2015 3:00 AM', '12/09/2015 11:00 AM'),
(41, '212222b2-9b12-47bd-8ee0-69b08123cde3', 'f8c81d8d-447f-4ad8-9310-1555c23fc462', '12/09/2015 9:00 AM', '12/09/2015 5:00 PM');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
