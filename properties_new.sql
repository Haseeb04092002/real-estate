-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 29, 2026 at 08:26 AM
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
-- Database: `properties_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0caavl2n7mv4klv55hjh595h7o8qvboj', '127.0.0.1', 1782229113, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738323232363739353b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31393a2268617365656231323340676d61696c2e636f6d223b757365725f70617373776f72647c733a3137323a226439326538336633396562663239613135333131353634386363363661616661636531613462373733333162323564396238316231663833366266643934343736316138346562386366353434373530626466303837656137376132633264363135643133353339613333626636336335643265653135336239306632386361613044614236676e654a486370524544654758676f6f4949582b414244764c343433776c454a53732f6e673d223b757365725f6e616d657c733a363a22686173656562223b757365725f7468756d627c733a303a22223b636c69656e745f69647c733a313a2231223b636c69656e745f6e616d657c733a363a22686173656562223b706172656e745f73746174696f6e7c4e3b6163746976655f73746174696f6e7c733a313a2231223b757365725f73746174696f6e7c733a313a2231223b757365725f636f6d70616e797c4e3b69735f6163746976657c693a313738323230393139323b6c6f676f7c733a303a22223b6c6f67696e5f74696d657c733a32303a2232332d4a756e2d323032362031353a30363a3332223b6c6f676765645f696e7c623a313b61646d696e5f6c6f676765645f696e7c623a313b),
('4m648afvd8phume9idr7vs6j4j443er5', '127.0.0.1', 1782221405, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738323232313430353b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31393a2268617365656231323340676d61696c2e636f6d223b757365725f70617373776f72647c733a3137323a226439326538336633396562663239613135333131353634386363363661616661636531613462373733333162323564396238316231663833366266643934343736316138346562386366353434373530626466303837656137376132633264363135643133353339613333626636336335643265653135336239306632386361613044614236676e654a486370524544654758676f6f4949582b414244764c343433776c454a53732f6e673d223b757365725f6e616d657c733a363a22686173656562223b757365725f7468756d627c733a303a22223b636c69656e745f69647c733a313a2231223b636c69656e745f6e616d657c733a363a22686173656562223b706172656e745f73746174696f6e7c4e3b6163746976655f73746174696f6e7c733a313a2231223b757365725f73746174696f6e7c733a313a2231223b757365725f636f6d70616e797c4e3b69735f6163746976657c693a313738323230393139323b6c6f676f7c733a303a22223b6c6f67696e5f74696d657c733a32303a2232332d4a756e2d323032362031353a30363a3332223b6c6f676765645f696e7c623a313b61646d696e5f6c6f676765645f696e7c623a313b),
('dct9uessmlvh572iukp3r7ad2gnncgvc', '127.0.0.1', 1782714132, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738323731323531333b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31393a2268617365656231323340676d61696c2e636f6d223b757365725f70617373776f72647c733a3137323a226439326538336633396562663239613135333131353634386363363661616661636531613462373733333162323564396238316231663833366266643934343736316138346562386366353434373530626466303837656137376132633264363135643133353339613333626636336335643265653135336239306632386361613044614236676e654a486370524544654758676f6f4949582b414244764c343433776c454a53732f6e673d223b757365725f6e616d657c733a363a22686173656562223b757365725f7468756d627c733a303a22223b636c69656e745f69647c733a313a2231223b636c69656e745f6e616d657c733a363a22686173656562223b706172656e745f73746174696f6e7c4e3b6163746976655f73746174696f6e7c733a313a2231223b757365725f73746174696f6e7c733a313a2231223b757365725f636f6d70616e797c4e3b69735f6163746976657c693a313738323731333233323b6c6f676f7c733a303a22223b6c6f67696e5f74696d657c733a32303a2232392d4a756e2d323032362031313a30373a3132223b6c6f676765645f696e7c623a313b70726f70657274795f736573735f646174617c613a32323a7b733a31333a2250726f70657274795469746c65223b733a31343a22746573742070726f706572742032223b733a31343a2250726f7065727479547970654964223b733a313a2233223b733a31313a224f776e6572736869704964223b733a313a2231223b733a31313a22436f766572656441726561223b733a323a223435223b733a31343a2250726f7065727479537461747573223b733a383a226f63637570696564223b733a31393a2250726f70657274794465736372697074696f6e223b733a3139343a2274686973206973206465736372697074696f6e206f6620746573742070726f706572747920322074686973206973206465736372697074696f6e206f6620746573742070726f706572747920322074686973206973206465736372697074696f6e206f6620746573742070726f706572747920322074686973206973206465736372697074696f6e206f6620746573742070726f706572747920322074686973206973206465736372697074696f6e206f6620746573742070726f70657274792032223b733a31343a224d61696c696e6741646472657373223b4e3b733a373a22436f756e747279223b733a393a224175737472616c6961223b733a373a225a6970436f6465223b733a353a223438383030223b733a363a22537562757262223b733a323a223435223b733a353a225374617465223b733a373a226368616b77616c223b733a31303a22556e69744e756d626572223b733a323a223431223b733a31343a224275696c64696e674e756d626572223b4e3b733a31323a225374726565744e756d626572223b733a323a223432223b733a31303a225374726565744e616d65223b733a323a223536223b733a393a224c6f6e676974756465223b4e3b733a383a224c61746974756465223b4e3b733a383a22436c69656e744964223b733a313a2231223b733a31303a224f776e6572456d61696c223b733a31393a2268617365656231323340676d61696c2e636f6d223b733a393a22557064617465644279223b733a313a2231223b733a393a22557064617465644f6e223b733a31393a22323032362d30362d32392031313a30383a3236223b733a31313a22506f7374696e6744617465223b733a31393a22323032362d30362d32392031313a30383a3236223b7d),
('djpibus8ac1r6rh7vec8rr1rhram6lf8', '127.0.0.1', 1782375886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738323337353836303b),
('dugrk39eba8bvott543guhkr5ejvqq8g', '127.0.0.1', 1782226795, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738323232363739353b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31393a2268617365656231323340676d61696c2e636f6d223b757365725f70617373776f72647c733a3137323a226439326538336633396562663239613135333131353634386363363661616661636531613462373733333162323564396238316231663833366266643934343736316138346562386366353434373530626466303837656137376132633264363135643133353339613333626636336335643265653135336239306632386361613044614236676e654a486370524544654758676f6f4949582b414244764c343433776c454a53732f6e673d223b757365725f6e616d657c733a363a22686173656562223b757365725f7468756d627c733a303a22223b636c69656e745f69647c733a313a2231223b636c69656e745f6e616d657c733a363a22686173656562223b706172656e745f73746174696f6e7c4e3b6163746976655f73746174696f6e7c733a313a2231223b757365725f73746174696f6e7c733a313a2231223b757365725f636f6d70616e797c4e3b69735f6163746976657c693a313738323230393139323b6c6f676f7c733a303a22223b6c6f67696e5f74696d657c733a32303a2232332d4a756e2d323032362031353a30363a3332223b6c6f676765645f696e7c623a313b61646d696e5f6c6f676765645f696e7c623a313b),
('n00i17d1ro36g4k7e3unutc5rjo0a723', '127.0.0.1', 1782631250, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738323632383431363b61646d696e5f6c6f676765645f696e7c623a313b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31393a2268617365656231323340676d61696c2e636f6d223b757365725f70617373776f72647c733a3137323a226439326538336633396562663239613135333131353634386363363661616661636531613462373733333162323564396238316231663833366266643934343736316138346562386366353434373530626466303837656137376132633264363135643133353339613333626636336335643265653135336239306632386361613044614236676e654a486370524544654758676f6f4949582b414244764c343433776c454a53732f6e673d223b757365725f6e616d657c733a363a22686173656562223b757365725f7468756d627c733a303a22223b636c69656e745f69647c733a313a2231223b636c69656e745f6e616d657c733a363a22686173656562223b706172656e745f73746174696f6e7c4e3b6163746976655f73746174696f6e7c733a313a2231223b757365725f73746174696f6e7c733a313a2231223b757365725f636f6d70616e797c4e3b69735f6163746976657c693a313738323632383435373b6c6f676f7c733a303a22223b6c6f67696e5f74696d657c733a32303a2232382d4a756e2d323032362031313a33343a3137223b6c6f676765645f696e7c623a313b);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clients_view`
-- (See below for the actual view)
--
CREATE TABLE `clients_view` (
`ClientId` int(11)
,`ClientName` varchar(255)
,`EmailAddress` varchar(255)
,`Password` varchar(255)
,`PhoneNumber` varchar(50)
,`StationId` int(11)
,`CompanyId` int(11)
,`StationParentId` int(11)
,`DOB` varchar(255)
,`CardNumber` varchar(255)
,`CardIssueDate` varchar(255)
,`CardExpiryDate` varchar(255)
,`IsDeleted` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ads`
--

CREATE TABLE `tbl_ads` (
  `AdId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `AdType` enum('Banner','Sidebar','Featured Property') NOT NULL DEFAULT 'Banner',
  `ReferenceId` int(11) DEFAULT NULL,
  `TargetUrl` varchar(500) DEFAULT NULL,
  `ImagePath` varchar(500) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Status` enum('Active','Paused','Expired') NOT NULL DEFAULT 'Active',
  `Impressions` int(11) NOT NULL DEFAULT 0,
  `Clicks` int(11) NOT NULL DEFAULT 0,
  `CreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedOn` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ads`
--

INSERT INTO `tbl_ads` (`AdId`, `Title`, `AdType`, `ReferenceId`, `TargetUrl`, `ImagePath`, `StartDate`, `EndDate`, `Status`, `Impressions`, `Clicks`, `CreatedOn`, `UpdatedOn`) VALUES
(1, 'Summer Sale Banner', 'Banner', NULL, 'https://example.com/summer-sale', NULL, '2026-06-02', '2026-07-02', 'Active', 1450, 120, '2026-06-12 16:47:39', NULL),
(2, 'Featured Villa 101', 'Featured Property', 101, '', NULL, '2026-06-07', '2026-06-17', 'Active', 890, 45, '2026-06-12 16:47:39', NULL),
(3, 'Winter Promo Sidebar', 'Sidebar', NULL, 'https://example.com/winter', NULL, '2026-04-13', '2026-05-13', 'Expired', 5000, 400, '2026-06-12 16:47:39', NULL),
(4, 'New Year Special', 'Banner', NULL, 'https://example.com/new-year', NULL, '2026-01-13', '2026-02-12', 'Expired', 12000, 950, '2026-06-12 16:47:39', NULL),
(5, 'Paused Campaign X', 'Banner', NULL, 'https://example.com/campaign-x', NULL, '2026-06-07', '2026-07-07', 'Paused', 200, 15, '2026-06-12 16:47:39', NULL),
(6, 'Luxury Condo Promotion', 'Featured Property', 250, '', NULL, '2026-06-10', '2026-06-22', 'Active', 340, 22, '2026-06-12 16:47:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogs`
--

CREATE TABLE `tbl_blogs` (
  `BlogId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Content` longtext DEFAULT NULL,
  `ImageName` varchar(255) NOT NULL,
  `Status` enum('Published','Draft') NOT NULL DEFAULT 'Draft',
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blogs`
--

INSERT INTO `tbl_blogs` (`BlogId`, `Title`, `Description`, `Content`, `ImageName`, `Status`, `CreatedAt`) VALUES
(1, 'Nature\'s Hidden Beauty', 'Discover untouched gems around the world in this exclusive travel blog.', 'This is the full content of the blog. In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document.', 'property-1.jpg', 'Published', '2026-06-12 17:21:38'),
(2, 'Urban Architecture Wonders', 'Explore modern architectural designs shaping our cities today.', 'Urban architecture is a combination of engineering, art, and environmental science. From skyscrapers to green buildings, the landscape of our cities is constantly evolving.', 'property-2.jpg', 'Published', '2026-06-12 17:21:38'),
(3, 'Interior Design Trends', 'Top trends that define contemporary home interiors in 2025.', 'Minimalism combined with smart home technology is taking over. Let us explore the colors, textures, and materials dominating 2025.', 'property-3.jpg', 'Published', '2026-06-12 17:21:38'),
(4, 'Green Homes Revolution', 'How sustainability is transforming residential real estate.', 'Solar panels, rainwater harvesting, and smart energy management are not just luxury items anymore—they are becoming the standard.', 'property-4.jpg', 'Published', '2026-06-12 17:21:38'),
(5, 'Investment Hotspots', 'Best cities to invest in real estate this year.', 'Looking for the best ROI? These up-and-coming neighborhoods offer incredible value and potential for exponential growth.', 'property-5.jpg', 'Published', '2026-06-12 17:21:38'),
(6, 'Luxury Villas Showcase', 'A glimpse into the worlds most luxurious villas.', 'Infinity pools, private beaches, and helicopter pads. Take a tour inside the most expensive real estate listings available right now.', 'property-6.jpg', 'Published', '2026-06-12 17:21:38'),
(7, 'Affordable Housing Plans', 'New government schemes for affordable living.', 'Understanding the new zoning laws and subsidies that are making homeownership accessible for first-time buyers.', 'property-1.jpg', 'Draft', '2026-06-12 17:21:38'),
(8, 'Smart Homes Technology', 'Future of home automation and smart living.', 'Voice assistants, AI-driven thermostats, and automated security systems. Here is what the home of the future looks like today.', 'property-4.jpg', 'Draft', '2026-06-12 17:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cities`
--

CREATE TABLE `tbl_cities` (
  `CityId` int(11) NOT NULL,
  `CityName` varchar(255) DEFAULT NULL,
  `CountryCode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cities`
--

INSERT INTO `tbl_cities` (`CityId`, `CityName`, `CountryCode`) VALUES
(1, 'Sydney', '28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clients`
--

CREATE TABLE `tbl_clients` (
  `ClientId` int(11) NOT NULL,
  `ClientName` varchar(255) DEFAULT NULL,
  `EmailAddress` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(50) DEFAULT NULL,
  `StationId` int(11) DEFAULT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `StationParentId` int(11) DEFAULT NULL,
  `DOB` varchar(255) DEFAULT NULL,
  `CardNumber` varchar(255) DEFAULT NULL,
  `CardIssueDate` varchar(255) DEFAULT NULL,
  `CardExpiryDate` varchar(255) DEFAULT NULL,
  `IsDeleted` int(11) DEFAULT 0,
  `UserType` varchar(50) DEFAULT 'Buyer',
  `AccountStatus` varchar(50) DEFAULT 'Pending Verification',
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `CNIC_Number` varchar(100) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `RegistrationDate` datetime DEFAULT current_timestamp(),
  `LastLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_clients`
--

INSERT INTO `tbl_clients` (`ClientId`, `ClientName`, `EmailAddress`, `Password`, `PhoneNumber`, `StationId`, `CompanyId`, `StationParentId`, `DOB`, `CardNumber`, `CardIssueDate`, `CardExpiryDate`, `IsDeleted`, `UserType`, `AccountStatus`, `ProfilePicture`, `CNIC_Number`, `City`, `Country`, `RegistrationDate`, `LastLogin`) VALUES
(1, 'haseeb', 'haseeb123@gmail.com', 'd92e83f39ebf29a153115648cc66aaface1a4b77331b25d9b81b1f836bfd944761a84eb8cf544750bdf087ea77a2c2d615d13539a33bf63c5d2ee153b90f28caa0DaB6gneJHcpREDeGXgooIIX+ABDvL443wlEJSs/ng=', '3368438235', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Buyer', 'Pending Verification', NULL, NULL, NULL, NULL, '2026-06-11 12:09:46', NULL),
(2, 'John Doe', 'john@example.com', 'pass', '123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Buyer', 'Pending Verification', NULL, NULL, NULL, NULL, '2026-06-12 18:34:11', NULL),
(3, 'Jane Smith', 'jane@example.com', 'pass', '654321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Buyer', 'Pending Verification', NULL, NULL, NULL, NULL, '2026-06-12 18:34:11', NULL),
(4, 'mano', 'mano@gmail.com', '6fe24fb2056165bd2e5f229882985b81dff66193946c04d99cb1b471278e175b2175a5c761999798244a3b5cd5dcd576201931596c5f792ff274ef5920dfbb3eJ7siTedP0LqkrXd2RS+k7aqph/9XTqD3gBPRK/YjFLo=', '3368438235', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Buyer', 'Pending Verification', NULL, NULL, NULL, NULL, '2026-06-25 13:24:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_companies`
--

CREATE TABLE `tbl_companies` (
  `CompanyId` int(11) NOT NULL,
  `CompanyName` varchar(255) DEFAULT NULL,
  `IsDeleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_companies`
--

INSERT INTO `tbl_companies` (`CompanyId`, `CompanyName`, `IsDeleted`) VALUES
(3, 'Default Company', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contract_clauses`
--

CREATE TABLE `tbl_contract_clauses` (
  `ClauseId` int(11) NOT NULL,
  `ClauseTitle` varchar(255) NOT NULL,
  `ClauseContent` text DEFAULT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contract_clauses`
--

INSERT INTO `tbl_contract_clauses` (`ClauseId`, `ClauseTitle`, `ClauseContent`, `AddedOn`, `AddedBy`) VALUES
(25, 'Severability Clause', '<p>If any provision of this Agreement is held illegal or unenforceable in a judicial proceeding, such provision shall be severed and shall be inoperative, and the remainder of this Agreement shall remain operative and binding on the Parties.</p>', '2026-06-12 18:37:07', 1),
(26, 'Force Majeure', '<p>Neither party shall be held liable or responsible to the other party nor be deemed to have defaulted under or breached this Agreement for failure or delay in fulfilling or performing any term of this Agreement to the extent, and for so long as, such failure or delay is caused by or results from causes beyond the reasonable control of the affected party.</p>', '2026-06-12 18:37:07', 1),
(27, 'Dispute Resolution', '<p>Any dispute arising out of or in connection with this contract, including any question regarding its existence, validity or termination, shall be referred to and finally resolved by arbitration.</p>', '2026-06-12 18:37:07', 1),
(28, 'Default and Termination', '<p>If either party defaults in the performance of any of its obligations hereunder and fails to cure such default within thirty (30) days after written notice thereof, the non-defaulting party shall have the right to terminate this Agreement.</p>', '2026-06-12 18:37:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contract_templates`
--

CREATE TABLE `tbl_contract_templates` (
  `TemplateId` int(11) NOT NULL,
  `ContractTypeId` int(11) DEFAULT NULL,
  `TemplateTitle` varchar(255) NOT NULL,
  `TemplateContent` longtext DEFAULT NULL,
  `Version` int(11) DEFAULT 1,
  `Status` enum('Draft','Active','Archived') DEFAULT 'Draft',
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contract_templates`
--

INSERT INTO `tbl_contract_templates` (`TemplateId`, `ContractTypeId`, `TemplateTitle`, `TemplateContent`, `Version`, `Status`, `AddedOn`, `AddedBy`, `UpdatedOn`, `UpdatedBy`) VALUES
(19, 1, 'Standard Residential Sale', '<h3>Standard Sale Agreement</h3><p>This agreement is made on <strong>{{contract_date}}</strong> between the Seller <strong>{{seller_name}}</strong> and the Buyer <strong>{{buyer_name}}</strong>.</p><p>The Seller agrees to sell the property located at <strong>{{property_address}}</strong> in <strong>{{city}}</strong>.</p><h4>Financial Terms</h4><ul><li>Total Price: ${{property_price}}</li><li>Advance Payment: ${{advance_amount}}</li><li>Remaining Balance: ${{remaining_amount}}</li></ul><br><h4>Severability</h4><p>If any provision of this Agreement is held illegal or unenforceable in a judicial proceeding, such provision shall be severed and shall be inoperative, and the remainder of this Agreement shall remain operative and binding on the Parties.</p>', 1, 'Active', '2026-06-12 18:37:07', 1, NULL, NULL),
(20, 2, 'Standard Residential Lease', '<h3>Residential Lease Agreement</h3><p>This lease agreement is entered into on <strong>{{contract_date}}</strong> between Landlord <strong>{{landlord_name}}</strong> and Tenant <strong>{{tenant_name}}</strong>.</p><p>Property Leased: <strong>{{property_address}}</strong>, <strong>{{city}}</strong>.</p><p>Lease Term: <strong>{{lease_term_months}} months</strong>.</p><p>Monthly Rent: ${{property_price}}</p><p>Security Deposit: ${{security_deposit}}</p>', 1, 'Active', '2026-06-12 18:37:07', 1, NULL, NULL),
(21, 3, 'Draft Commercial Lease', '<p>Commercial Lease terms to be determined...</p>', 1, 'Draft', '2026-06-12 18:37:07', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contract_variables`
--

CREATE TABLE `tbl_contract_variables` (
  `VarId` int(11) NOT NULL,
  `VarKey` varchar(255) NOT NULL,
  `AddedOn` datetime NOT NULL,
  `AddedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contract_variables`
--

INSERT INTO `tbl_contract_variables` (`VarId`, `VarKey`, `AddedOn`, `AddedBy`) VALUES
(101, 'buyer_name', '2026-06-12 18:37:07', 1),
(102, 'seller_name', '2026-06-12 18:37:07', 1),
(103, 'landlord_name', '2026-06-12 18:37:07', 1),
(104, 'tenant_name', '2026-06-12 18:37:07', 1),
(105, 'property_title', '2026-06-12 18:37:07', 1),
(106, 'property_address', '2026-06-12 18:37:07', 1),
(107, 'property_price', '2026-06-12 18:37:07', 1),
(108, 'advance_amount', '2026-06-12 18:37:07', 1),
(109, 'remaining_amount', '2026-06-12 18:37:07', 1),
(110, 'contract_date', '2026-06-12 18:37:07', 1),
(111, 'property_area', '2026-06-12 18:37:07', 1),
(112, 'city', '2026-06-12 18:37:07', 1),
(113, 'commission_rate', '2026-06-12 18:37:07', 1),
(114, 'lease_term_months', '2026-06-12 18:37:07', 1),
(115, 'security_deposit', '2026-06-12 18:37:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_countries`
--

CREATE TABLE `tbl_countries` (
  `CountryId` int(11) NOT NULL,
  `CountryName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_countries`
--

INSERT INTO `tbl_countries` (`CountryId`, `CountryName`) VALUES
(28, 'Australia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents`
--

CREATE TABLE `tbl_documents` (
  `DocumentId` int(11) NOT NULL,
  `ReferenceId` int(11) DEFAULT NULL,
  `Reference` varchar(100) DEFAULT NULL,
  `ReferenceName` varchar(100) DEFAULT NULL,
  `StationId` int(11) DEFAULT NULL,
  `FileName` varchar(255) DEFAULT NULL,
  `FileSize` varchar(50) DEFAULT NULL,
  `DocumentTitle` varchar(150) DEFAULT NULL,
  `DocumentTypeId` varchar(50) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `ReferenceNumber` varchar(100) DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL,
  `UploadedBy` int(11) DEFAULT NULL,
  `UploadTime` datetime DEFAULT NULL,
  `VerificationStatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_documents`
--

INSERT INTO `tbl_documents` (`DocumentId`, `ReferenceId`, `Reference`, `ReferenceName`, `StationId`, `FileName`, `FileSize`, `DocumentTitle`, `DocumentTypeId`, `Remarks`, `ReferenceNumber`, `ExpiryDate`, `UploadedBy`, `UploadTime`, `VerificationStatus`) VALUES
(1, 179, 'Properties', 'Properties', 1, 'd7cfc98b109582835d18dc416d5c5830.jpg', '172.89', NULL, NULL, NULL, NULL, NULL, 1, '2026-06-29 11:11:35', 'Pending'),
(2, 179, 'Properties', 'Properties', 1, '0bbe171e6a8d46a923c34ab58c3a3eee.jpg', '3312.26', NULL, NULL, NULL, NULL, NULL, 1, '2026-06-29 11:11:35', 'Pending'),
(3, 179, 'Properties', 'Properties', 1, 'da0a680f455c9886fcd7e5ccda04f052.jpg', '10.14', NULL, NULL, NULL, NULL, NULL, 1, '2026-06-29 11:11:35', 'Pending'),
(4, 179, 'Properties', 'Properties', 1, 'eeded50e6b30d4a80339950b0a0c0b9c.mp4', '2346.23', NULL, NULL, NULL, NULL, NULL, 1, '2026-06-29 11:11:35', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_flooring_types`
--

CREATE TABLE `tbl_flooring_types` (
  `FlooringTypeId` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inquiries`
--

CREATE TABLE `tbl_inquiries` (
  `InquiryId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `BuyerId` int(11) NOT NULL,
  `SellerId` int(11) NOT NULL,
  `Message` text NOT NULL,
  `ContactNumber` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Pending',
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_power_backup_types`
--

CREATE TABLE `tbl_power_backup_types` (
  `PowerBackupTypeId` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties`
--

CREATE TABLE `tbl_properties` (
  `PropertyId` int(11) NOT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `StationId` int(11) DEFAULT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL,
  `Rooms` int(11) DEFAULT NULL,
  `BathRooms` int(11) DEFAULT NULL,
  `ClientId` int(11) DEFAULT NULL,
  `OwnershipId` int(11) DEFAULT NULL,
  `PropertyTypeId` int(11) DEFAULT NULL,
  `PropertyTitle` text DEFAULT NULL,
  `PropertyDescription` text DEFAULT NULL,
  `PropertyStatus` enum('occupied','rented','vacant') DEFAULT NULL,
  `ListType` enum('Sale','Rent') DEFAULT NULL,
  `PostingDate` date DEFAULT NULL,
  `PossessionDate` date DEFAULT NULL,
  `AreaUnitId` int(11) DEFAULT NULL,
  `CoveredArea` int(11) DEFAULT NULL,
  `CountryId` int(11) DEFAULT NULL,
  `CityId` int(11) DEFAULT NULL,
  `StreetName` varchar(20) DEFAULT NULL,
  `StreetNumber` varchar(20) DEFAULT NULL,
  `BuildingNumber` varchar(20) DEFAULT NULL,
  `UnitNumber` varchar(20) DEFAULT NULL,
  `MailingAddress` text DEFAULT NULL,
  `RegionId` int(11) DEFAULT NULL,
  `ZipCode` varchar(15) DEFAULT NULL,
  `TotalPrice` decimal(20,2) DEFAULT NULL,
  `SecurityBond` decimal(20,2) DEFAULT NULL,
  `AdvanceAmount` decimal(20,2) DEFAULT NULL,
  `IsPossession` tinyint(1) DEFAULT 0,
  `IsInstallment` tinyint(1) DEFAULT 0,
  `InstallmentAmount` int(5) DEFAULT NULL,
  `Installments` int(5) DEFAULT 0,
  `OwnerEmail` varchar(50) DEFAULT NULL,
  `MobileNum` varchar(50) DEFAULT NULL,
  `Landline` varchar(50) DEFAULT NULL,
  `FederalTaxNo` varchar(50) DEFAULT NULL,
  `RegionalTax` varchar(50) DEFAULT NULL,
  `FilerStatus` tinyint(1) DEFAULT 0,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `Country` varchar(100) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `Suburb` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_properties`
--

INSERT INTO `tbl_properties` (`PropertyId`, `CompanyId`, `StationId`, `Latitude`, `Longitude`, `Rooms`, `BathRooms`, `ClientId`, `OwnershipId`, `PropertyTypeId`, `PropertyTitle`, `PropertyDescription`, `PropertyStatus`, `ListType`, `PostingDate`, `PossessionDate`, `AreaUnitId`, `CoveredArea`, `CountryId`, `CityId`, `StreetName`, `StreetNumber`, `BuildingNumber`, `UnitNumber`, `MailingAddress`, `RegionId`, `ZipCode`, `TotalPrice`, `SecurityBond`, `AdvanceAmount`, `IsPossession`, `IsInstallment`, `InstallmentAmount`, `Installments`, `OwnerEmail`, `MobileNum`, `Landline`, `FederalTaxNo`, `RegionalTax`, `FilerStatus`, `AddedOn`, `AddedBy`, `UpdatedOn`, `UpdatedBy`, `IsDeleted`, `Country`, `State`, `Suburb`) VALUES
(178, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, 2, 'test property', 'this is description of the property this is description of the property this is description of the property this is description of the property this is description of the property this is description of the property this is description of the property', 'occupied', 'Sale', '2026-06-14', '2020-01-01', NULL, 15, NULL, NULL, '55', '74', NULL, '78', NULL, NULL, '48800', 750000.00, NULL, NULL, 0, 0, NULL, NULL, 'haseeb123@gmail.com', NULL, NULL, NULL, NULL, 0, '2026-06-14 09:40:55', 1, '2026-06-14 09:42:01', 1, 0, 'Australia', '12', '33'),
(179, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, 3, 'test propert 2', 'this is description of test property 2 this is description of test property 2 this is description of test property 2 this is description of test property 2 this is description of test property 2', 'occupied', 'Rent', '2026-06-29', '2020-01-01', NULL, 45, NULL, NULL, '56', '42', NULL, '41', NULL, NULL, '48800', 500.00, 200.00, NULL, 0, 0, NULL, NULL, 'haseeb123@gmail.com', NULL, NULL, NULL, NULL, 0, '2026-06-29 11:08:26', 1, '2026-06-29 11:09:40', 1, 0, 'Australia', 'chakwal', '45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_analytics`
--

CREATE TABLE `tbl_properties_analytics` (
  `ItemId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `UserAction` enum('View','Post Click','Call Click','Whatsapp Click','Email Click') NOT NULL,
  `DeviceType` enum('Desktop','Mobile','Tablet') DEFAULT 'Desktop',
  `IPAddress` varchar(45) DEFAULT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_contracts`
--

CREATE TABLE `tbl_properties_contracts` (
  `ContractId` int(11) UNSIGNED NOT NULL,
  `ContractDate` date DEFAULT NULL,
  `PropertyId` int(11) DEFAULT NULL,
  `ContractTypeId` int(11) DEFAULT NULL,
  `BuyerId` int(11) DEFAULT NULL,
  `SellerId` int(11) DEFAULT NULL,
  `BuyerCase` enum('Individual','Joint','Corporate') DEFAULT NULL,
  `TotalAmount` decimal(20,2) DEFAULT NULL,
  `DepositAmount` decimal(20,2) DEFAULT NULL,
  `TotalTax` decimal(20,2) DEFAULT 0.00,
  `AdjustmentType` enum('Land Tax Adjustable','GST Taxable Supply','Margin Scheme') NOT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0,
  `ContractStatus` enum('Draft','Pending','Approved','Rejected','Completed','Cancelled','Expired','Terminated') DEFAULT 'Draft',
  `TemplateId` int(11) DEFAULT NULL,
  `ContractHTML` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_properties_contracts`
--

INSERT INTO `tbl_properties_contracts` (`ContractId`, `ContractDate`, `PropertyId`, `ContractTypeId`, `BuyerId`, `SellerId`, `BuyerCase`, `TotalAmount`, `DepositAmount`, `TotalTax`, `AdjustmentType`, `AddedOn`, `AddedBy`, `UpdatedOn`, `UpdatedBy`, `ContractStatus`, `TemplateId`, `ContractHTML`) VALUES
(373, NULL, 175, 1, 2, 1, NULL, 500000.00, NULL, 0.00, 'Land Tax Adjustable', '2026-06-07 18:37:07', 0, NULL, 0, 'Completed', NULL, '<p>Dummy Signed Sale Contract Content</p>'),
(374, NULL, 176, 2, 1, 2, NULL, 200000.00, NULL, 0.00, 'Land Tax Adjustable', '2026-06-11 18:37:07', 0, NULL, 0, 'Pending', NULL, '<p>Dummy Signed Lease Contract Content</p>'),
(375, NULL, 175, 1, 2, 1, NULL, 550000.00, NULL, 0.00, 'Land Tax Adjustable', '2026-06-12 18:37:07', 0, NULL, 0, 'Draft', NULL, '<p>Draft Contract Content</p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_contracts_type`
--

CREATE TABLE `tbl_properties_contracts_type` (
  `TypeId` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) NOT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0,
  `IsActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_properties_contracts_type`
--

INSERT INTO `tbl_properties_contracts_type` (`TypeId`, `Title`, `AddedOn`, `AddedBy`, `UpdatedOn`, `UpdatedBy`, `IsActive`) VALUES
(33, 'Sale Agreement', '2026-06-12 18:37:07', 1, NULL, 0, 1),
(34, 'Rental/Lease Agreement', '2026-06-12 18:37:07', 1, NULL, 0, 1),
(35, 'Commercial Lease', '2026-06-12 18:37:07', 1, NULL, 0, 1),
(36, 'Property Management Agreement', '2026-06-12 18:37:07', 1, NULL, 0, 1),
(37, 'Exclusive Right to Sell', '2026-06-12 18:37:07', 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_favourites`
--

CREATE TABLE `tbl_properties_favourites` (
  `FavouriteId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `AddedOn` datetime NOT NULL,
  `AddedBy` int(11) NOT NULL,
  `UpdatedOn` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `IsFavourite` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_features`
--

CREATE TABLE `tbl_properties_features` (
  `FeatureId` int(11) UNSIGNED NOT NULL,
  `PropertyId` int(11) DEFAULT NULL,
  `FlooringTypeId` int(11) DEFAULT NULL,
  `PowerBackupTypeId` int(11) DEFAULT NULL,
  `BuiltInYear` date DEFAULT NULL,
  `ParkingSpaces` int(11) DEFAULT NULL,
  `Floors` int(11) DEFAULT NULL,
  `OtherRooms` int(11) DEFAULT NULL,
  `Bedrooms` int(11) DEFAULT NULL,
  `ServantQuarters` int(11) DEFAULT NULL,
  `Kitchens` int(11) DEFAULT NULL,
  `StoreRooms` int(11) DEFAULT NULL,
  `View` text DEFAULT NULL,
  `OtherMainFeatures` text NOT NULL,
  `CommunicationFacilities` text DEFAULT NULL,
  `OtherCommunityFacilities` text DEFAULT NULL,
  `OtherHealthcare` text DEFAULT NULL,
  `IsMedicalCentre` tinyint(1) DEFAULT 0,
  `IsDoubleGlazedWindows` tinyint(1) DEFAULT 0,
  `IsCentralAirConditioning` tinyint(1) DEFAULT 0,
  `IsCentralHeating` tinyint(1) DEFAULT 0,
  `IsWasteDisposal` tinyint(1) DEFAULT 0,
  `IsFurnished` tinyint(1) DEFAULT 0,
  `IsDrawingRoom` tinyint(1) DEFAULT 0,
  `IsDiningRoom` tinyint(1) DEFAULT 0,
  `IsStudyRoom` tinyint(1) DEFAULT 0,
  `IsPrayerRoom` tinyint(1) DEFAULT 0,
  `IsPowderRoom` tinyint(1) DEFAULT 0,
  `IsGym` tinyint(1) DEFAULT 0,
  `IsSteamRoom` tinyint(1) DEFAULT 0,
  `IsLoungeRoom` tinyint(1) DEFAULT 0,
  `IsLaundryRoom` tinyint(1) DEFAULT 0,
  `IsBroadbandInternetAccess` tinyint(1) DEFAULT 0,
  `IsTVReady` tinyint(1) DEFAULT 0,
  `IsIntercom` tinyint(1) DEFAULT 0,
  `IsConferenceRoom` tinyint(1) DEFAULT 0,
  `IsCommunityLawn` tinyint(1) DEFAULT 0,
  `IsCommunitySwimmingPool` tinyint(1) DEFAULT 0,
  `IsCommunityGym` tinyint(1) DEFAULT 0,
  `IsFirstAid` tinyint(1) DEFAULT 0,
  `IsDayCareCenter` tinyint(1) DEFAULT 0,
  `IsKidsPlayArea` tinyint(1) DEFAULT 0,
  `IsBarbequeArea` tinyint(1) DEFAULT 0,
  `IsMosque` tinyint(1) DEFAULT 0,
  `IsCommunityCentre` tinyint(1) DEFAULT 0,
  `IsLawnGarden` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_features_lists`
--

CREATE TABLE `tbl_properties_features_lists` (
  `FeatureId` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) NOT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_inspection`
--

CREATE TABLE `tbl_properties_inspection` (
  `InspectionId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `RequestedBy` int(11) NOT NULL,
  `RequestedOn` datetime DEFAULT NULL,
  `SellerId` int(11) NOT NULL,
  `SimilarProperties` tinyint(1) DEFAULT 0,
  `Rates` tinyint(1) DEFAULT 0,
  `PriceInformation` tinyint(1) DEFAULT 0,
  `ScheduleInspection` tinyint(1) DEFAULT 0,
  `Remarks` text DEFAULT NULL,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `TourType` enum('virtual','physical') DEFAULT NULL,
  `MeetTime` time DEFAULT NULL,
  `MeetDate` date DEFAULT NULL,
  `InspectionStatus` enum('Pending','Accepted','Rejected','Cancelled','Available') DEFAULT 'Pending',
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_inspection_availabilities`
--

CREATE TABLE `tbl_properties_inspection_availabilities` (
  `AvailabilityId` int(11) NOT NULL,
  `SellerId` int(11) DEFAULT NULL,
  `PropertyId` int(11) DEFAULT NULL,
  `AvailableDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `IsBooked` tinyint(1) DEFAULT 0,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_messages`
--

CREATE TABLE `tbl_properties_messages` (
  `MessageId` int(11) NOT NULL,
  `ReceiverId` int(11) DEFAULT NULL,
  `SenderId` int(11) DEFAULT NULL,
  `InspectionId` int(11) DEFAULT NULL,
  `Message` text NOT NULL,
  `IsRead` tinyint(1) DEFAULT 0,
  `AddedOn` datetime NOT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_news`
--

CREATE TABLE `tbl_properties_news` (
  `NewsId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `CategoryId` int(11) DEFAULT NULL,
  `AuthorId` int(11) DEFAULT NULL,
  `Tags` text DEFAULT NULL,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `PublishedOn` datetime DEFAULT NULL,
  `AddedOn` datetime NOT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `UpdatedOn` datetime NOT NULL,
  `UpdatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_news_media`
--

CREATE TABLE `tbl_properties_news_media` (
  `MediaId` int(11) NOT NULL,
  `NewsId` int(11) NOT NULL,
  `MediaType` text DEFAULT NULL,
  `MediaPath` varchar(255) NOT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `IsDeleted` tinyint(1) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_ownership_status`
--

CREATE TABLE `tbl_properties_ownership_status` (
  `OwnershipId` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `StationId` int(11) DEFAULT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_postcodes`
--

CREATE TABLE `tbl_properties_postcodes` (
  `PostCodeId` int(11) UNSIGNED NOT NULL,
  `PostCode` int(10) DEFAULT NULL,
  `Suburb` varchar(100) DEFAULT NULL,
  `State` varchar(10) DEFAULT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL,
  `CityId` int(11) UNSIGNED DEFAULT NULL,
  `StateId` int(11) UNSIGNED DEFAULT NULL,
  `CountryId` int(11) UNSIGNED DEFAULT NULL,
  `IsDeleted` tinyint(1) DEFAULT 0 COMMENT '0 = false; 1 = true',
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_types`
--

CREATE TABLE `tbl_properties_types` (
  `TypeId` int(11) UNSIGNED NOT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `StationId` int(11) DEFAULT NULL,
  `Title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PropertyGroup` enum('Home','Land','Commercial','Other') DEFAULT NULL,
  `PropertyIcon` varchar(50) DEFAULT NULL,
  `SortOrder` int(11) DEFAULT 1,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_properties_types`
--

INSERT INTO `tbl_properties_types` (`TypeId`, `CompanyId`, `StationId`, `Title`, `PropertyGroup`, `PropertyIcon`, `SortOrder`, `AddedOn`, `AddedBy`, `UpdatedOn`, `UpdatedBy`) VALUES
(1, NULL, NULL, 'Villa', '', 'fa-solid fa-house-chimney-window', 1, NULL, 0, NULL, 0),
(2, NULL, NULL, 'Unit', '', 'fa fa-building', 2, NULL, 0, NULL, 0),
(3, NULL, NULL, 'Townhouse', '', 'fa-solid fa-city', 3, NULL, 0, NULL, 0),
(4, NULL, NULL, 'House', '', 'fa-solid fa-house', 4, NULL, 0, NULL, 0),
(5, NULL, NULL, 'Rural', '', 'fa-solid fa-tractor', 5, NULL, 0, NULL, 0),
(6, NULL, NULL, 'Acreage', '', 'fa-solid fa-tree', 6, NULL, 0, NULL, 0),
(7, NULL, NULL, 'Block Of Units', '', 'fa-solid fa-building', 7, NULL, 0, NULL, 0),
(8, NULL, NULL, 'Guest House', '', 'fa-solid fa-bed', 8, NULL, 0, NULL, 0),
(9, NULL, NULL, 'Apartment', '', 'fa-solid fa-building', 9, NULL, 0, NULL, 0),
(10, NULL, NULL, 'Retirement Living', '', 'fa-solid fa-tree', 10, NULL, 0, NULL, 0),
(11, NULL, NULL, 'Land', '', 'fa-solid fa-map', 11, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_properties_units`
--

CREATE TABLE `tbl_properties_units` (
  `UnitId` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `StationId` int(11) DEFAULT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT 0,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property_documents`
--

CREATE TABLE `tbl_property_documents` (
  `DocumentId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `SellerId` int(11) NOT NULL,
  `DocTypeId` int(11) NOT NULL,
  `FilePath` varchar(255) NOT NULL,
  `UploadedDate` datetime DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL,
  `VerificationStatus` enum('Pending','Approved','Rejected','Re-upload') NOT NULL DEFAULT 'Pending',
  `AdminNotes` text DEFAULT NULL,
  `NotificationStatus` enum('None','90','30','7','Expired') NOT NULL DEFAULT 'None'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property_document_types`
--

CREATE TABLE `tbl_property_document_types` (
  `DocTypeId` int(11) NOT NULL,
  `DocumentTitle` varchar(255) NOT NULL,
  `PropertyType` enum('Sale','Rent','Both') NOT NULL DEFAULT 'Both',
  `IsMandatory` tinyint(1) NOT NULL DEFAULT 0,
  `RequiresExpiryTracking` tinyint(1) NOT NULL DEFAULT 0,
  `AddedOn` datetime DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_property_document_types`
--

INSERT INTO `tbl_property_document_types` (`DocTypeId`, `DocumentTitle`, `PropertyType`, `IsMandatory`, `RequiresExpiryTracking`, `AddedOn`, `UpdatedOn`) VALUES
(1, 'Certificate of Title', 'Sale', 1, 0, '2026-06-11 19:07:33', NULL),
(2, 'Contract of Sale', 'Sale', 1, 0, '2026-06-11 19:07:33', NULL),
(3, 'Owner ID', 'Both', 1, 1, '2026-06-11 19:07:33', NULL),
(4, 'Building Approval', 'Sale', 0, 0, '2026-06-11 19:07:33', NULL),
(5, 'Survey Plan', 'Sale', 0, 0, '2026-06-11 19:07:33', NULL),
(6, 'Proof of Ownership', 'Rent', 1, 0, '2026-06-11 19:07:33', NULL),
(7, 'Smoke Alarm Compliance', 'Rent', 1, 1, '2026-06-11 19:07:33', NULL),
(8, 'Rental Compliance', 'Rent', 1, 1, '2026-06-11 19:07:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property_feature_mapping`
--

CREATE TABLE `tbl_property_feature_mapping` (
  `MappingId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `FeatureId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_regions`
--

CREATE TABLE `tbl_regions` (
  `RegionId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `CountryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_regions`
--

INSERT INTO `tbl_regions` (`RegionId`, `Title`, `CountryId`) VALUES
(1, 'NSW', 28);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saved_properties`
--

CREATE TABLE `tbl_saved_properties` (
  `SavedId` int(11) NOT NULL,
  `ClientId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `SavedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stations`
--

CREATE TABLE `tbl_stations` (
  `StationId` int(11) NOT NULL,
  `CountryId` int(11) DEFAULT NULL,
  `CityId` int(11) DEFAULT NULL,
  `RegionId` int(11) DEFAULT NULL,
  `IsDeleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_stations`
--

INSERT INTO `tbl_stations` (`StationId`, `CountryId`, `CityId`, `RegionId`, `IsDeleted`) VALUES
(1, 28, 1, 1, 0),
(9, 28, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_activity_logs`
--

CREATE TABLE `tbl_user_activity_logs` (
  `LogId` int(11) NOT NULL,
  `ClientId` int(11) NOT NULL,
  `Action` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `IpAddress` varchar(100) DEFAULT NULL,
  `Device` varchar(255) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_verifications`
--

CREATE TABLE `tbl_user_verifications` (
  `VerificationId` int(11) NOT NULL,
  `ClientId` int(11) NOT NULL,
  `EmailVerified` tinyint(1) DEFAULT 0,
  `PhoneVerified` tinyint(1) DEFAULT 0,
  `CNICDocument` varchar(255) DEFAULT NULL,
  `SelfieDocument` varchar(255) DEFAULT NULL,
  `VerificationStatus` varchar(50) DEFAULT 'Unverified',
  `RequestedAt` datetime DEFAULT current_timestamp(),
  `ResolvedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_verification_rules`
--

CREATE TABLE `tbl_user_verification_rules` (
  `RuleId` int(11) NOT NULL,
  `DocumentTitle` varchar(255) NOT NULL,
  `IsMandatory` tinyint(1) NOT NULL DEFAULT 0,
  `AddedOn` datetime DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_verification_rules`
--

INSERT INTO `tbl_user_verification_rules` (`RuleId`, `DocumentTitle`, `IsMandatory`, `AddedOn`, `UpdatedOn`) VALUES
(1, 'License Front', 1, '2026-06-11 19:21:02', NULL),
(2, 'License Back', 1, '2026-06-11 19:21:02', NULL),
(3, 'Passport', 0, '2026-06-11 19:21:02', NULL),
(4, 'Address Details', 1, '2026-06-11 19:21:02', NULL),
(5, 'profile picture', 0, '2026-06-13 18:54:23', NULL);

-- --------------------------------------------------------

--
-- Structure for view `clients_view`
--
DROP TABLE IF EXISTS `clients_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clients_view`  AS SELECT `tbl_clients`.`ClientId` AS `ClientId`, `tbl_clients`.`ClientName` AS `ClientName`, `tbl_clients`.`EmailAddress` AS `EmailAddress`, `tbl_clients`.`Password` AS `Password`, `tbl_clients`.`PhoneNumber` AS `PhoneNumber`, `tbl_clients`.`StationId` AS `StationId`, `tbl_clients`.`CompanyId` AS `CompanyId`, `tbl_clients`.`StationParentId` AS `StationParentId`, `tbl_clients`.`DOB` AS `DOB`, `tbl_clients`.`CardNumber` AS `CardNumber`, `tbl_clients`.`CardIssueDate` AS `CardIssueDate`, `tbl_clients`.`CardExpiryDate` AS `CardExpiryDate`, `tbl_clients`.`IsDeleted` AS `IsDeleted` FROM `tbl_clients` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `tbl_ads`
--
ALTER TABLE `tbl_ads`
  ADD PRIMARY KEY (`AdId`);

--
-- Indexes for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  ADD PRIMARY KEY (`BlogId`);

--
-- Indexes for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  ADD PRIMARY KEY (`CityId`);

--
-- Indexes for table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  ADD PRIMARY KEY (`ClientId`);

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`CompanyId`);

--
-- Indexes for table `tbl_contract_clauses`
--
ALTER TABLE `tbl_contract_clauses`
  ADD PRIMARY KEY (`ClauseId`);

--
-- Indexes for table `tbl_contract_templates`
--
ALTER TABLE `tbl_contract_templates`
  ADD PRIMARY KEY (`TemplateId`);

--
-- Indexes for table `tbl_contract_variables`
--
ALTER TABLE `tbl_contract_variables`
  ADD PRIMARY KEY (`VarId`);

--
-- Indexes for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  ADD PRIMARY KEY (`CountryId`);

--
-- Indexes for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD PRIMARY KEY (`DocumentId`);

--
-- Indexes for table `tbl_flooring_types`
--
ALTER TABLE `tbl_flooring_types`
  ADD PRIMARY KEY (`FlooringTypeId`);

--
-- Indexes for table `tbl_inquiries`
--
ALTER TABLE `tbl_inquiries`
  ADD PRIMARY KEY (`InquiryId`),
  ADD KEY `BuyerId` (`BuyerId`),
  ADD KEY `SellerId` (`SellerId`);

--
-- Indexes for table `tbl_power_backup_types`
--
ALTER TABLE `tbl_power_backup_types`
  ADD PRIMARY KEY (`PowerBackupTypeId`);

--
-- Indexes for table `tbl_properties`
--
ALTER TABLE `tbl_properties`
  ADD PRIMARY KEY (`PropertyId`);

--
-- Indexes for table `tbl_properties_analytics`
--
ALTER TABLE `tbl_properties_analytics`
  ADD PRIMARY KEY (`ItemId`),
  ADD KEY `tbl_properties_analytics_ibfk_1` (`PropertyId`);

--
-- Indexes for table `tbl_properties_contracts`
--
ALTER TABLE `tbl_properties_contracts`
  ADD PRIMARY KEY (`ContractId`);

--
-- Indexes for table `tbl_properties_contracts_type`
--
ALTER TABLE `tbl_properties_contracts_type`
  ADD PRIMARY KEY (`TypeId`);

--
-- Indexes for table `tbl_properties_favourites`
--
ALTER TABLE `tbl_properties_favourites`
  ADD PRIMARY KEY (`FavouriteId`);

--
-- Indexes for table `tbl_properties_features`
--
ALTER TABLE `tbl_properties_features`
  ADD PRIMARY KEY (`FeatureId`);

--
-- Indexes for table `tbl_properties_features_lists`
--
ALTER TABLE `tbl_properties_features_lists`
  ADD PRIMARY KEY (`FeatureId`);

--
-- Indexes for table `tbl_properties_inspection`
--
ALTER TABLE `tbl_properties_inspection`
  ADD PRIMARY KEY (`InspectionId`);

--
-- Indexes for table `tbl_properties_inspection_availabilities`
--
ALTER TABLE `tbl_properties_inspection_availabilities`
  ADD PRIMARY KEY (`AvailabilityId`);

--
-- Indexes for table `tbl_properties_messages`
--
ALTER TABLE `tbl_properties_messages`
  ADD PRIMARY KEY (`MessageId`);

--
-- Indexes for table `tbl_properties_news`
--
ALTER TABLE `tbl_properties_news`
  ADD PRIMARY KEY (`NewsId`);

--
-- Indexes for table `tbl_properties_news_media`
--
ALTER TABLE `tbl_properties_news_media`
  ADD PRIMARY KEY (`MediaId`),
  ADD KEY `tbl_properties_news_media_ibfk_1` (`NewsId`);

--
-- Indexes for table `tbl_properties_ownership_status`
--
ALTER TABLE `tbl_properties_ownership_status`
  ADD PRIMARY KEY (`OwnershipId`);

--
-- Indexes for table `tbl_properties_postcodes`
--
ALTER TABLE `tbl_properties_postcodes`
  ADD PRIMARY KEY (`PostCodeId`);

--
-- Indexes for table `tbl_properties_types`
--
ALTER TABLE `tbl_properties_types`
  ADD PRIMARY KEY (`TypeId`);

--
-- Indexes for table `tbl_properties_units`
--
ALTER TABLE `tbl_properties_units`
  ADD PRIMARY KEY (`UnitId`);

--
-- Indexes for table `tbl_property_documents`
--
ALTER TABLE `tbl_property_documents`
  ADD PRIMARY KEY (`DocumentId`);

--
-- Indexes for table `tbl_property_document_types`
--
ALTER TABLE `tbl_property_document_types`
  ADD PRIMARY KEY (`DocTypeId`);

--
-- Indexes for table `tbl_property_feature_mapping`
--
ALTER TABLE `tbl_property_feature_mapping`
  ADD PRIMARY KEY (`MappingId`);

--
-- Indexes for table `tbl_regions`
--
ALTER TABLE `tbl_regions`
  ADD PRIMARY KEY (`RegionId`);

--
-- Indexes for table `tbl_saved_properties`
--
ALTER TABLE `tbl_saved_properties`
  ADD PRIMARY KEY (`SavedId`),
  ADD KEY `ClientId` (`ClientId`);

--
-- Indexes for table `tbl_stations`
--
ALTER TABLE `tbl_stations`
  ADD PRIMARY KEY (`StationId`);

--
-- Indexes for table `tbl_user_activity_logs`
--
ALTER TABLE `tbl_user_activity_logs`
  ADD PRIMARY KEY (`LogId`),
  ADD KEY `ClientId` (`ClientId`);

--
-- Indexes for table `tbl_user_verifications`
--
ALTER TABLE `tbl_user_verifications`
  ADD PRIMARY KEY (`VerificationId`),
  ADD KEY `ClientId` (`ClientId`);

--
-- Indexes for table `tbl_user_verification_rules`
--
ALTER TABLE `tbl_user_verification_rules`
  ADD PRIMARY KEY (`RuleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_ads`
--
ALTER TABLE `tbl_ads`
  MODIFY `AdId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  MODIFY `BlogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  MODIFY `CityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  MODIFY `ClientId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `CompanyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_contract_clauses`
--
ALTER TABLE `tbl_contract_clauses`
  MODIFY `ClauseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_contract_templates`
--
ALTER TABLE `tbl_contract_templates`
  MODIFY `TemplateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_contract_variables`
--
ALTER TABLE `tbl_contract_variables`
  MODIFY `VarId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  MODIFY `CountryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  MODIFY `DocumentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_flooring_types`
--
ALTER TABLE `tbl_flooring_types`
  MODIFY `FlooringTypeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_inquiries`
--
ALTER TABLE `tbl_inquiries`
  MODIFY `InquiryId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_power_backup_types`
--
ALTER TABLE `tbl_power_backup_types`
  MODIFY `PowerBackupTypeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_properties`
--
ALTER TABLE `tbl_properties`
  MODIFY `PropertyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `tbl_properties_analytics`
--
ALTER TABLE `tbl_properties_analytics`
  MODIFY `ItemId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_properties_contracts`
--
ALTER TABLE `tbl_properties_contracts`
  MODIFY `ContractId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `tbl_properties_contracts_type`
--
ALTER TABLE `tbl_properties_contracts_type`
  MODIFY `TypeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_properties_favourites`
--
ALTER TABLE `tbl_properties_favourites`
  MODIFY `FavouriteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tbl_properties_features`
--
ALTER TABLE `tbl_properties_features`
  MODIFY `FeatureId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_properties_features_lists`
--
ALTER TABLE `tbl_properties_features_lists`
  MODIFY `FeatureId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tbl_properties_inspection`
--
ALTER TABLE `tbl_properties_inspection`
  MODIFY `InspectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_properties_inspection_availabilities`
--
ALTER TABLE `tbl_properties_inspection_availabilities`
  MODIFY `AvailabilityId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_properties_messages`
--
ALTER TABLE `tbl_properties_messages`
  MODIFY `MessageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_properties_news`
--
ALTER TABLE `tbl_properties_news`
  MODIFY `NewsId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_properties_news_media`
--
ALTER TABLE `tbl_properties_news_media`
  MODIFY `MediaId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_properties_ownership_status`
--
ALTER TABLE `tbl_properties_ownership_status`
  MODIFY `OwnershipId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_properties_postcodes`
--
ALTER TABLE `tbl_properties_postcodes`
  MODIFY `PostCodeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16743;

--
-- AUTO_INCREMENT for table `tbl_properties_types`
--
ALTER TABLE `tbl_properties_types`
  MODIFY `TypeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_properties_units`
--
ALTER TABLE `tbl_properties_units`
  MODIFY `UnitId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_property_documents`
--
ALTER TABLE `tbl_property_documents`
  MODIFY `DocumentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_property_document_types`
--
ALTER TABLE `tbl_property_document_types`
  MODIFY `DocTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_property_feature_mapping`
--
ALTER TABLE `tbl_property_feature_mapping`
  MODIFY `MappingId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_regions`
--
ALTER TABLE `tbl_regions`
  MODIFY `RegionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_saved_properties`
--
ALTER TABLE `tbl_saved_properties`
  MODIFY `SavedId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stations`
--
ALTER TABLE `tbl_stations`
  MODIFY `StationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_user_activity_logs`
--
ALTER TABLE `tbl_user_activity_logs`
  MODIFY `LogId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_verifications`
--
ALTER TABLE `tbl_user_verifications`
  MODIFY `VerificationId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_verification_rules`
--
ALTER TABLE `tbl_user_verification_rules`
  MODIFY `RuleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_inquiries`
--
ALTER TABLE `tbl_inquiries`
  ADD CONSTRAINT `tbl_inquiries_ibfk_1` FOREIGN KEY (`BuyerId`) REFERENCES `tbl_clients` (`ClientId`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_inquiries_ibfk_2` FOREIGN KEY (`SellerId`) REFERENCES `tbl_clients` (`ClientId`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_saved_properties`
--
ALTER TABLE `tbl_saved_properties`
  ADD CONSTRAINT `tbl_saved_properties_ibfk_1` FOREIGN KEY (`ClientId`) REFERENCES `tbl_clients` (`ClientId`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_user_activity_logs`
--
ALTER TABLE `tbl_user_activity_logs`
  ADD CONSTRAINT `tbl_user_activity_logs_ibfk_1` FOREIGN KEY (`ClientId`) REFERENCES `tbl_clients` (`ClientId`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_user_verifications`
--
ALTER TABLE `tbl_user_verifications`
  ADD CONSTRAINT `tbl_user_verifications_ibfk_1` FOREIGN KEY (`ClientId`) REFERENCES `tbl_clients` (`ClientId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
