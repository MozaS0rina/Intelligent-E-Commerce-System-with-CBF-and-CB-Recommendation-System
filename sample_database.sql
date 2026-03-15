-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Gazdă: localhost:3306
-- Timp de generare: mart. 15, 2026 la 12:09 PM
-- Versiune server: 8.0.43
-- Versiune PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `rh643_jewelry_shop`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `sample_cumparaturi`
--

CREATE TABLE `sample_cumparaturi` (
  `c_id` int NOT NULL,
  `c_prod_id` int NOT NULL,
  `c_qty` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `sample_favorites`
--

CREATE TABLE `sample_favorites` (
  `id` int NOT NULL,
  `u_id` int NOT NULL,
  `prod_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `sample_istoric`
--

CREATE TABLE `sample_istoric` (
  `i_id` int NOT NULL,
  `i_user_id` int NOT NULL,
  `i_prod_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `sample_produse`
--

CREATE TABLE `sample_produse` (
  `prod_id` int NOT NULL DEFAULT '0',
  `prod_qty` int NOT NULL,
  `prod_material` varchar(100) NOT NULL,
  `prod_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prod_price` int NOT NULL,
  `prod_desc` text NOT NULL,
  `prod_spec` text NOT NULL,
  `prod_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prod_category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Eliminarea datelor din tabel `sample_produse`
--

INSERT INTO `sample_produse` (`prod_id`, `prod_qty`, `prod_material`, `prod_name`, `prod_price`, `prod_desc`, `prod_spec`, `prod_image`, `prod_category`) VALUES
(8, 12, 'YELLOW SILVER', 'Silver Golden Moonstone Bracelet', 120, 'Material:925 sterling silver\r\nPlating: 18K 1 micron vermeil\r\nBracelet length: 20 + 5 cm\r\nStone: natural moonstone\r\nThe Moonstone is specific to the Gemini and Cancer.\r\n', 'Color:Multicolor \r\nDetail:Natural Stone \r\nApproximate weight:7.2 \r\nMaterial:Silver \r\nFor:For her \r\nStones:Semi-precious stones \r\nPlating:Vermeil 1 micron 18K \r\nType:Bracelet \r\nTheme:Glamour \r\nBracelet type:Chain\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-argint-golden-moonstone-bracelet.jpg', 'Bracelets'),
(7, 12, 'WHITE SILVER', 'Silver bracelet Sparkling Tennis clear', 150, 'Material: 925 sterling silver\r\nPlating: Rhodium\r\nBracelet thickness: 1,80 mm \r\nAdjustable\r\nWeight approx: 3,32 g     \r\nClasp: Silver ball with silicone \r\nStone: Zirconium \r\n', 'Colour:Silver \r\nMaterial:Silver \r\nFor:For her\r\nStones:Crystals \r\nPlating:Rhodium \r\nType:Bracelet \r\nTheme:Love \r\nBracelet type:Tennis\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-argint-sparkling-tennis-clear.jpg', 'Bracelets'),
(6, 11, 'YELLOW GOLD', '14 K Gold Bracelet with butterfly outline', 500, '14 K gold bracelet with 7x9.3 mm butterfly outline.\r\nMaterial: 14K gold (585)\r\nBracelet chain length: 15.9 cm + 3 cm (extension)\r\nElements size: 7x9.3 mm\r\nBracelet weight: 1.01 gr\r\n', 'Colour:Gold \r\nMaterial:Gold \r\nFor:For her \r\nStones:No stones \r\nType:Bracelet \r\nTheme:Nature \r\nBracelet type:Chain\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-aur-14-k-cu-fluturas-contur.jpg', 'Bracelets'),
(9, 4, 'YELLOW SILVER', 'Silver Golden Mystic Crystal Bangle', 150, 'Material:925 sterling silver\r\nBracelet length: 17.5 cm\r\nBracelet width: 3.2 mm\r\nClosure: Clips with safety system\r\nPlating: Vermeil 1 micron 18K\r\n', 'Colour:Gold \r\nApproximate weight: 9.6 \r\nMaterial:Silver \r\nFor:For her \r\nStones:Crystals \r\nPlating:Vermeil 1 micron 18K \r\nType:Bracelet \r\nTheme:Simple \r\nBracelet type:Tennis\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-argint-golden-mystic-crystal-bangle.jpg', 'Bracelets'),
(10, 16, 'WHITE SILVER', 'Silver Sparkling Heart Bracelet', 100, 'Material:925 sterling silver\r\nPlating: Rhodium\r\nCentre element size: 12,21 X 10,44 mm\r\nClosure: clips\r\nStone: Zirconium\r\nMeasurements 17 and 19 represent wrist circumference in centimeters!\r\n', 'Colour:Silver \r\nApproximate weight:8,42 \r\nMaterial:Silver \r\nFor:For her \r\nStones:Crystals \r\nPlating:Rhodium \r\nType:Bracelet\r\nTheme:Love \r\nBracelet type:Fixed\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-argint-sparkling-heart.jpg', 'Bracelets'),
(11, 7, 'YELLOW GOLD', '14k Crystal Dot gold and string bracelet', 200, 'Material:14k gold (585) / Textile bezel\r\nItem size: 6.5 x 6.5 mm\r\nElement weight: 0.51 g\r\nClosure: Adjustable knot\r\nStone: Crystal\r\n', 'Colour:Gold \r\nApproximate weight:0.87 \r\nMaterial:Gold \r\nFor:For her \r\nStones:Crystals \r\nType:Bracelet\r\nTheme:Simple \r\nBracelet type:String\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-snur-si-aur-14k-crystal-dot.jpg', 'Bracelets'),
(12, 7, 'WHITE SILVER', 'Silver Shiny Blue Eye Bracelet', 180, 'Material:925 sterling silver\r\nPlating: Rhodium\r\nBracelet length: 16cm\r\nAdjustable\r\nBracelet width: 2mm\r\nExtension element length: 7cm\r\nElement size: L x W = 10mm x 10mm \r\nWeight approx: 5.32g\r\nClosure: carbine\r\nStone: Zirconium \r\n', 'Colour:Blue \r\nMaterial:Silver \r\nFor:For her \r\nStones:Crystals \r\nPlating:Rhodium \r\nType:Bracelet \r\nTheme:Glamour \r\nBracelet type:Tennis\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-argint-shiny-blue-eye.jpg', 'Bracelets'),
(13, 9, 'PINK GOLD', 'Rose Gold Little Hearts Silver Bracelet', 250, 'Material:925 sterling silver\r\nPlating: 18 K Rose Gold\r\nBracelet length: L= 16,5cm\r\nAdjustable\r\nLength extension element: L=5cm\r\nElement size 1: L x W = 5mm x 5mm  \r\nElement size 2: L x W = 4mm X 4mm\r\nWeight approx: 1.95g\r\nClosure: carbine\r\nStone: Zirconium\r\n', 'Color:Pink \r\nMaterial:Silver \r\nFor:For her \r\nStones:Crystals \r\nPlating:18k rose gold \r\nType:Bracelet \r\nTheme:Love \r\nBracelet type:Chain\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-argint-rose-gold-little-hearts.jpg', 'Bracelets'),
(14, 16, 'PINK GOLD', 'Rose Gold Crystal Chain Silver Ankle Bracelet', 230, 'Material: sterling silver\r\nPlating: 18 K Rose Gold\r\nBracelet length: cm\r\nClosure: carbine\r\nStone: Zirconium\r\n', 'Colour:Pink \r\nMaterial:Silver \r\nFor:For her \r\nStones:Crystals \r\nPlating:18k rose gold \r\nType:Bracelet \r\nTheme:Simple\r\nBracelet type:Chain\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-de-glezna-din-argint-rose-gold-crystal-chain.jpg', 'Bracelets'),
(15, 3, 'PINK SILVER', 'Pink Safety fixed silver bracelet', 199, 'Material:925 sterling silver\r\nPlating: Rhodium\r\nItem size 1: L x W =10mm x 10mm \r\nItem size 2: L x W = 9mm x 9mm\r\nItem size 3: L x W =18mm x 6mm \r\nElement size closure : L x W = 11mm x 11mm\r\nChain size: 2.5cm\r\nWeight approx: 13.2g\r\nClosure: clips\r\nStone: Zirconium\r\nBracelet type: for talismans\r\n', 'Color:Pink \r\nMaterial:Silver \r\nFor:For her \r\nStones:Crystals \r\nPlating:Rhodium \r\nType:Bracelet \r\nTheme:Love \r\nBracelet type:  For talismans\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27bratara-din-argint-fixa-pink-safety.jpg', 'Bracelets'),
(16, 6, 'WHITE SILVER', 'Little Crystals Heart silver earrings', 110, 'Material: Silver 925\r\nPlywood: Rhodium \r\nClosure: Rod and flyer\r\nEarring size: 4.70 mm x 5.20 mm x 1.20 mm \r\nWeight: 0.76 g\r\n', 'Color: Silver\r\nClosure: Rod and screw\r\nEarring type: On lobe \r\nMaterial: Silver \r\nFor: For kids \r\nStones: crystals\r\nPlywood: Rhodium\r\nType: Earrings \r\nTheme: Love\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-argint-little-crystals-heart.jpg', 'Earrings'),
(17, 7, 'PINK GOLD', 'Rose Gold silver earrings with Earring and Crystals', 240, 'Material: Silver 925\r\nPlywood: 18K Rose Gold\r\nClosure: Rod and flyer\r\nEarring size: cm\r\nStones: Zirconium\r\n', 'Color:Pink\r\n Approximate weight: 1.78\r\n Closure:Rod and screw \r\nEarring type:On lobe\r\n Material:Silver\r\n Stones:No stones\r\nPlywood:Rose gold18k \r\nType: Earrings\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-argint-rose-gold-cu-cerculeti-si-cristale.jpg', 'Earrings'),
(18, 19, 'YELLOW GOLD', '14K Blue Drop Gold Earrings', 300, '\"14K Blue Drop Gold Earrings\" are part of the precious Gold Woman collection.\r\nImpeccable details make earrings suitable for any occasion, both for ladies and ladies.\r\nMaterial: 14K Gold (585)\r\nDimensions: 8 x 18 mm\r\nWeight: 1.16 gr\r\n', 'Color:Gold\r\nApproximate gram: 1.16\r\n Closing:Tortita\r\n Earring Type:Long \r\nMaterial:Gold \r\nFor:For her \r\nStones:Crystals \r\nType:Earrings\r\n Theme:Simple\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-aur-14k-picatura-albastra.jpg', 'Earrings'),
(19, 10, 'YELLOW GOLD', 'Golden Garnet Drop silver earrings', 289, 'Material: Silver 925\r\nPlywood: Vermeil 1 micron 18K\r\nSize: 7.68 x 5.82 mm\r\nStone: Natural garnet\r\nGarnet is specific to Aries and Capricorn\r\n', 'Color:Multicolor \r\nDetail:Natural stone \r\nApproximate gram:1.18 \r\nClosure:Rod and screw \r\nEarring type:On lobe \r\nMaterial:Silver \r\nFor:For her \r\nStones:Semiprecious stones \r\nPlywood:Vermeil 1 micron 18K \r\nType:Earrings \r\nTheme:Glamour\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-argint-golden-garnet-drop.jpg', 'Earrings'),
(20, 3, 'YELLOW SILVER', 'Golden Dreamy Moonstone silver earrings', 198, 'Material: Silver 925\r\nPlywood: Vermeil 1 micron 18K\r\nSize: 7.65 mm\r\nStone: Natural Moon Stone\r\nMoonstone is specific to Gemini and Cancer.\r\n', 'Color: Multicolor\r\n Detail: Natural stone \r\nApproximate gram: 1.6 \r\nClosure: Rod and screw\r\n Earring type: On lobe\r\n Material: Silver\r\n For: For her \r\nStones: Semiprecious stones\r\n Plywood: Vermeil 1 micron 18K\r\n Type: Earrings \r\nTheme: Glamour\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-argint-golden-dreamy-moonstone.jpg', 'Earrings'),
(21, 14, 'YELLOW GOLD', 'Gold Earrings 14k Crystals Circle', 200, '14k Gold Earrings \"Circle Crystals\" are part of the precious Gold Woman collection.\r\nBeautiful details make earrings suitable for any occasion, both for ladies and ladies.\r\nMaterial: 14K Gold(585)\r\nDimensions: 14 x 2.5 mm\r\nLocking system: Rod and screw\r\nWeight: 1.13 gr\r\nThe jewelry we sell is not sold per gram. They have a fixed price, per model.\r\n', 'Color:Gold \r\nApproximate gram:1.13  \r\nType of earrings:Simple\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-aur-14k-cristale-cerc.jpg', 'Earrings'),
(22, 13, 'WHITE SILVER', 'Silver Green Tear silver earrings', 145, 'Material: Silver 925\r\nPlywood: Rhodium\r\nClosing: Tortita\r\nEarring size: cm\r\nStone: Zirconium\r\n', 'Color:Green \r\nApproximate gram:1.64 \r\nEarring Type:Long \r\nMaterial:Silver \r\nStones:Crystals \r\nPlywood:Rhodium \r\nType:Earrings\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-argint-silver-green-tear.jpg', 'Earrings'),
(23, 4, 'YELLOW GOLD', '14k Pearl Large Gold Earrings', 296, '\"14k Pearl Great Gold Earrings\" are part of the precious Gold Woman collection.\r\nBeautiful details make earrings suitable for any occasion, both for ladies and ladies.\r\nMaterial: 14K Gold(585)\r\nDimensions: 24 x 9 mm\r\nRod length: 8mm\r\nWeight: 2.76 gr (weight may vary)\r\nDetail: Cultured pearls \r\n', 'Color:Gold \r\nApproximate Gram:2.76 \r\nEarring Type:Long \r\nMaterial:Gold \r\nFor:For her\r\nStones:Pearls \r\nType:Earrings \r\nTheme:Simple\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-aur-14k-perla-mare.jpg', 'Earrings'),
(24, 16, 'YELLOW GOLD', '14K Square Large Crystal Gold Earrings', 310, '\"14K Square Large Crystal Gold Earrings\" are part of the precious Gold Woman collection.\r\nBeautiful details make earrings suitable for any occasion, both for ladies and ladies.\r\nMaterial: 14K Gold(585)\r\nDimensions: 8.5 mm\r\nRod length: 8 mm\r\nLocking system: Rod and screw\r\nWeight: 2.17 g\r\n', 'Color:Gold \r\nApproximate Gram:2.17 \r\nClosure:Rod and screw \r\nEarring type:On lobe \r\nMaterial:Gold \r\nFor:For her \r\nStones:Crystals \r\nType:Earrings\r\nTheme:Simple\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-aur-14k-patrat-cristal-mare.jpg', 'Earrings'),
(25, 5, 'YELLOW GOLD', '14K Gold Earrings Double Chain and Pearls', 320, '\"14K gold double chain earrings and pearls\" are part of the precious Gold Woman collection.\r\nBeautiful details make earrings suitable for any occasion, both for ladies and ladies.\r\nMaterial: 14K Gold (585)\r\nDimensions: 37x4mm\r\nRod length: 8 mm\r\nLocking System: Thread and Protection\r\nWeight: 0.86 gr\r\n', 'Color:Gold \r\nApproximate gram:0.86 g \r\nClosure:Rod and screw \r\nEarring Type:Long \r\nMaterial:Gold\r\nFor:For her \r\nStones:Pearls \r\nType:Earrings\r\nTheme:Simple\r\n', 'product_image/962b71e38ba13e25cc51ab8fae700e27cercei-din-aur-14k-lant-dublu-si-perle.jpg', 'Earrings');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `sample_review`
--

CREATE TABLE `sample_review` (
  `r_id` int NOT NULL,
  `r_prod_id` int NOT NULL,
  `r_user_id` int NOT NULL,
  `r_rev` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `sample_utilizatori`
--

CREATE TABLE `sample_utilizatori` (
  `u_id` int NOT NULL DEFAULT '0',
  `u_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `u_surname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `u_username` varchar(20) NOT NULL,
  `u_password` varchar(100) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Eliminarea datelor din tabel `sample_utilizatori`
--

INSERT INTO `sample_utilizatori` (`u_id`, `u_name`, `u_surname`, `u_username`, `u_password`, `u_email`, `u_phone`) VALUES
(1, 'Moza', 'Sorina', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'rebecamihoc@yahoo.com', '0757959095'),
(2, 'Mihoc', 'Rebeca', 'rebeca', '202cb962ac59075b964b07152d234b70', 'rebecamihoc@yahoo.com', '0757959095'),
(3, 'Moza', 'Sorina', 'sorina', '827ccb0eea8a706c4c34a16891f84e7b', 'sorina.dana19@gmail.com', '0771305874'),
(4, 'Sorlei ', 'Cristian', 'cristi', '827ccb0eea8a706c4c34a16891f84e7b', 'sorina.dana19@gmail.com', '0771305874'),
(5, 'Moza', 'Daniel', 'daniel', 'e10adc3949ba59abbe56e057f20f883e', 'daniel@gmail.com', '0771305874'),
(6, 'Bota', 'Bianca', 'bia', '827ccb0eea8a706c4c34a16891f84e7b', 'bia@gmail.com', '0771305874'),
(7, 'Popescu', 'Maria', 'maria_popescu', '827ccb0eea8a706c4c34a16891f84e7b', 'pop_maria@gmail.com', '0771305892'),
(8, 'Ionescu', 'Matei', 'matei_ionescu', '827ccb0eea8a706c4c34a16891f84e7b', 'matei@gmail.com', '0721305892'),
(9, 'Magdal', 'Andreea', 'adre123', '827ccb0eea8a706c4c34a16891f84e7b', 'andre_magdal@gmail.com', '0725405874'),
(10, 'Misc', 'Ionel', 'ionel', '827ccb0eea8a706c4c34a16891f84e7b', 'ioni1819@gmail.com', '0771305874');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `sample_cumparaturi`
--
ALTER TABLE `sample_cumparaturi`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexuri pentru tabele `sample_favorites`
--
ALTER TABLE `sample_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `sample_istoric`
--
ALTER TABLE `sample_istoric`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexuri pentru tabele `sample_review`
--
ALTER TABLE `sample_review`
  ADD PRIMARY KEY (`r_id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `sample_cumparaturi`
--
ALTER TABLE `sample_cumparaturi`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `sample_favorites`
--
ALTER TABLE `sample_favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `sample_istoric`
--
ALTER TABLE `sample_istoric`
  MODIFY `i_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `sample_review`
--
ALTER TABLE `sample_review`
  MODIFY `r_id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
