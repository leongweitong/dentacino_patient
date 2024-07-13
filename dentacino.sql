-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024 年 07 月 13 日 18:30
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `dentacino`
--

-- --------------------------------------------------------

--
-- 資料表結構 `appointment`
--

CREATE TABLE `appointment` (
  `Appointment_ID` varchar(11) NOT NULL,
  `Patient_Name` varchar(100) NOT NULL,
  `Patient_Email` varchar(100) NOT NULL,
  `Patient_Contact` varchar(13) NOT NULL,
  `Appointment_Date` date NOT NULL,
  `Appointment_Status` varchar(1) NOT NULL,
  `ServiceType_ID` varchar(3) NOT NULL,
  `Operatinghours_ID` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `appointment`
--

INSERT INTO `appointment` (`Appointment_ID`, `Patient_Name`, `Patient_Email`, `Patient_Contact`, `Appointment_Date`, `Appointment_Status`, `ServiceType_ID`, `Operatinghours_ID`) VALUES
('A2udIyPm2S1', 'Lau Wen Xiang', 'lauwenxiang@yahoo.com', '012-3945302', '2024-06-24', '9', '4', '10'),
('A3jwUMSBSeD', 'Leong Wei Tong', 'kahchong456@gmail.com', '018-2930485', '2024-06-24', '1', '5', '15'),
('A5MV8morJD7', 'Leong Wei Tong', 'kahchong456@gmail.com', '018-3924023', '2024-06-24', '1', '5', '16'),
('A8yYNOoBeKA', 'Yau Zi Hao', 'yauzihao@gmail.com', '012-4923042', '2024-06-26', '9', '6', '11'),
('A9YxiN7VXRn', 'Lau Wen Xiang', 'kahchong456@gmail.com', '018-3923893', '2024-06-24', '1', '4', '9'),
('AA0qo6VukRB', 'Wong Kah Chung', 'kahchonguni@gmail.com', '012-39423942', '2024-06-28', '1', '8', '9'),
('ADuxG7xBvWI', 'TESTING', 'weitong0724@gmail.com', '011-28735339', '2024-07-05', '0', '1', '9'),
('AfY9sdx2yrP', 'Wong Kah Chung', 'kahchong456@gmail.com', '018-2389402', '2024-06-18', '2', '1', '10'),
('AG5iJyK4r2r', 'weitong', 'weitong0724@gmail.com', '011-28735339', '2024-07-19', '1', '1', '8'),
('AHN5ZqaQ6Ha', 'Wong Kah Chung', 'kahchong456@gmail.com', '018-9402868', '2024-06-21', '0', '1', '8'),
('AI26BbphLRG', 'Foong Han Le', 'kahchong456@gmail.com', '019-3904023', '2024-06-24', '1', '9', '14'),
('AjWuAmp4HWq', 'Leong Wei Tong', 'weitong@gmail.com', '011-2345960', '2024-06-19', '9', '3', '14'),
('AlWHoaN8aRK', 'weitong', 'weitong0724@gmail.com', '011-28735339', '2024-06-21', '0', '2', '8'),
('ANmtq6dLLSh', 'LEONG WEI TONG', 'weitong0724@gmail.com', '011-28735339', '2024-06-28', '0', '3', '8'),
('AoK1xtcIsne', 'Yau Zi Hao', 'kahchong456@gmail.com', '012-3924923', '2024-06-18', '2', '4', '15'),
('ApWJspvvS3A', 'Catherine Wong', 'catherinewong@gmail.com', '012-3942032', '2024-06-18', '2', '2', '14'),
('Argp1FwyQXB', 'Duncan', 'kahchong456@gmail.com', '012-3456789', '2024-06-24', '1', '2', '8'),
('ARx3O2V8bXu', 'TESTING', 'weitong0724@gmail.com', '011-28735339', '2024-06-21', '9', '4', '8'),
('ArYA2QOdxp7', 'Wong Kah Chung', 'kahchong456@gmail.com', '018-9402868', '2024-06-21', '1', '2', '9'),
('AW61QVlqSN7', 'Lau Wen Xiang', 'kahchong456@gmail.com', '012-9327450', '2024-06-18', '2', '5', '11'),
('AWpuyU3c17C', 'Yip Chi Fong', 'kahchong456@gmail.com', '012-3943234', '2024-06-24', '1', '7', '11');

-- --------------------------------------------------------

--
-- 資料表結構 `cancellation_tokens`
--

CREATE TABLE `cancellation_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `Appointment_ID` varchar(11) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `closure_date`
--

CREATE TABLE `closure_date` (
  `ClosureDate_ID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `ClosureDate_Label` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `closure_date`
--

INSERT INTO `closure_date` (`ClosureDate_ID`, `Date`, `ClosureDate_Label`) VALUES
(1, '2024-06-20', 'Hari Raya Haji'),
(2, '2024-07-07', 'Awal Muharram'),
(3, '2024-08-24', 'Melaka Governor’s Birthday'),
(4, '2024-08-31', 'Merdeka Day'),
(5, '2024-09-16', 'Malaysia Day'),
(6, '2024-10-31', 'Deepavali'),
(7, '2024-12-25', 'Christmas Day'),
(8, '2025-01-01', 'New Year\'s Day'),
(9, '2025-01-29', 'Chinese New Year'),
(10, '2025-01-30', 'Chinese New Year'),
(11, '2025-03-31', 'Hari Raya Aidilfitri'),
(12, '2025-04-01', 'Hari Raya Aidilfitri'),
(13, '2025-05-01', 'Labour Day'),
(14, '2025-05-12', 'Wesak Day'),
(15, '2025-06-02', 'Agong\'s Birthday'),
(16, '2025-06-07', 'Hari Raya Haji');

-- --------------------------------------------------------

--
-- 資料表結構 `feedback`
--

CREATE TABLE `feedback` (
  `Feedback_ID` int(11) NOT NULL,
  `Feedback_Title` varchar(100) NOT NULL,
  `Feedback_Star` int(1) NOT NULL,
  `Feedback_Comment` text DEFAULT NULL,
  `Feedback_Status` varchar(1) NOT NULL,
  `Appointment_ID` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `feedback`
--

INSERT INTO `feedback` (`Feedback_ID`, `Feedback_Title`, `Feedback_Star`, `Feedback_Comment`, `Feedback_Status`, `Appointment_ID`) VALUES
(1, 'Exceptional Dental Care Experience', 5, 'Dr. Lau and his team were incredible! From the moment I walked in, I felt at ease. The procedure was painless and quick, and they took the time to explain everything. Highly recommend for anyone looking for top-notch dental care.', '1', 'AfY9sdx2yrP'),
(2, 'Friendly and Professional Staff', 4, 'The staff at Dentacino office are very welcoming and professional. They made sure I was comfortable throughout my visit. The only downside was a bit of a wait, but the service made up for it. Will definitely come back!', '1', 'ApWJspvvS3A'),
(3, 'Best Dentist in Town', 5, 'I’ve been to many dentists over the years, but Dr. Wong is by far the best. His attention to detail and patient care are outstanding. My teeth have never felt cleaner. The clinic is also very modern and clean.', '1', 'AW61QVlqSN7'),
(4, 'Pain Free and Pleasant Visit', 5, 'I usually dread going to the dentist, but this was a surprisingly pleasant experience. Dr. Patel was gentle and thorough. I didn’t feel any pain during my filling. The staff is also very caring and friendly. Highly recommended!', '1', 'AoK1xtcIsne');

-- --------------------------------------------------------

--
-- 資料表結構 `operating_hours`
--

CREATE TABLE `operating_hours` (
  `Operatinghours_ID` int(3) NOT NULL,
  `Start_Time` time NOT NULL,
  `End_Time` time NOT NULL,
  `Operatinghours_Status` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `operating_hours`
--

INSERT INTO `operating_hours` (`Operatinghours_ID`, `Start_Time`, `End_Time`, `Operatinghours_Status`) VALUES
(1, '01:00:00', '02:00:00', '0'),
(2, '02:00:00', '03:00:00', '0'),
(3, '03:00:00', '04:00:00', '0'),
(4, '04:00:00', '05:00:00', '0'),
(5, '05:00:00', '06:00:00', '0'),
(6, '06:00:00', '07:00:00', '0'),
(7, '07:00:00', '08:00:00', '0'),
(8, '08:00:00', '09:00:00', '2'),
(9, '09:00:00', '10:00:00', '2'),
(10, '10:00:00', '11:00:00', '2'),
(11, '11:00:00', '12:00:00', '2'),
(12, '12:00:00', '13:00:00', '1'),
(13, '13:00:00', '14:00:00', '1'),
(14, '14:00:00', '15:00:00', '2'),
(15, '15:00:00', '16:00:00', '2'),
(16, '16:00:00', '17:00:00', '2'),
(17, '17:00:00', '18:00:00', '2'),
(18, '18:00:00', '19:00:00', '0'),
(19, '19:00:00', '20:00:00', '0'),
(20, '20:00:00', '21:00:00', '0'),
(21, '21:00:00', '22:00:00', '0'),
(22, '22:00:00', '23:00:00', '0'),
(23, '23:00:00', '23:59:00', '0');

-- --------------------------------------------------------

--
-- 資料表結構 `patient_inquiry`
--

CREATE TABLE `patient_inquiry` (
  `Inquiry_ID` int(11) NOT NULL,
  `Patient_Name` varchar(100) NOT NULL,
  `Patient_Email` varchar(100) NOT NULL,
  `Patient_Contact` varchar(13) NOT NULL,
  `QuestionType` varchar(1) NOT NULL,
  `Patient_Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `patient_inquiry`
--

INSERT INTO `patient_inquiry` (`Inquiry_ID`, `Patient_Name`, `Patient_Email`, `Patient_Contact`, `QuestionType`, `Patient_Message`) VALUES
(1, 'John Doe', 'john.doe@example.com', '018-9402868', '1', 'Hello, I am interested in learning more about the dental services your clinic offers. Could you please provide me with information on the types of treatments available and their respective costs? Additionally, do you offer any packages or discounts for new patients? Thank you.'),
(2, 'Jane Smith', 'jane.smith@example.com', '012-3456789', '1', 'Hi, I would like to book an appointment for a dental check-up and cleaning. Could you please let me know your availability for next week? I am available any day in the afternoon. Also, do you accept new patients and what should I bring for my first visit? Thank you!'),
(3, 'Jane Smith', 'jane.smith@example.com', '012-3456789', '1', 'Hi, I would like to book an appointment for a dental check-up and cleaning. Could you please let me know your availability for next week? I am available any day in the afternoon. Also, do you accept new patients and what should I bring for my first visit? Thank you!'),
(4, 'Michael Brown', 'michael.brown@example.com', '019-9402868', '1', 'Hello, I am experiencing severe tooth pain and I believe I might need an emergency appointment. Could you please let me know if you have any available slots today or tomorrow morning? Additionally, what are the procedures and costs associated with emergency dental services? Thank you for your prompt response.'),
(5, 'Lisa Williams', 'lisa.williams@example.com', '012-3948523', '1', 'Hello, I recently had a dental procedure at your clinic and need to schedule a follow-up appointment. Could you please let me know the available dates and times for the follow-up check-up? Also, are there any specific instructions I should follow before the appointment? Thank you.'),
(6, 'Wong Kah Chung', 'kahchong456@gmail.com', '018-9402868', '1', 'Hi, I am interested in improving my smile and would like to know more about the cosmetic dentistry options you offer, such as teeth whitening and veneers. Could you please provide details on the procedures, duration, and costs involved? Also, are there any financing options available? Thank you.');

-- --------------------------------------------------------

--
-- 資料表結構 `service_type`
--

CREATE TABLE `service_type` (
  `ServiceType_ID` int(3) NOT NULL,
  `ServiceType_Name` varchar(50) NOT NULL,
  `ServiceType_Picture` text NOT NULL,
  `ServiceType_Status` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `service_type`
--

INSERT INTO `service_type` (`ServiceType_ID`, `ServiceType_Name`, `ServiceType_Picture`, `ServiceType_Status`) VALUES
(1, 'Braces', 'Braces.webp', '1'),
(2, 'Dental Implants', 'Dental Implants.webp', '1'),
(3, 'Dental Bridges', 'Dental Bridges.webp', '1'),
(4, 'Dentures', 'Dentures.webp', '1'),
(5, 'Invisalign', 'Invisalign.webp', '1'),
(6, 'Routine Check Up', 'Routine Check Up.webp', '1'),
(7, 'Scaling and Polishing', 'Scaling and Polishing.webp', '1'),
(8, 'Teeth Whitening', 'Teeth Whitening.webp', '1'),
(9, 'Tooth Removal', 'Tooth Removal.webp', '1'),
(10, 'Veneers', 'Veneers.webp', '1');

-- --------------------------------------------------------

--
-- 資料表結構 `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` varchar(11) NOT NULL,
  `Staff_Name` varchar(100) NOT NULL,
  `Staff_Email` varchar(100) NOT NULL,
  `Staff_Password` varchar(256) NOT NULL,
  `Staff_Type` varchar(1) NOT NULL,
  `Staff_Status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `staff`
--

INSERT INTO `staff` (`Staff_ID`, `Staff_Name`, `Staff_Email`, `Staff_Password`, `Staff_Type`, `Staff_Status`) VALUES
('DEN00001', 'LAU WEN XIANG', 'lauwenxiang@yahoo.com', '$2y$10$y/3VQz9OI1.bXrCLtDWVPexoj7uc..aJcn1HgWr9m65UuXNk0trEK', '1', '1'),
('DEN00002', 'WONG KAH CHONG', 'kahchong456@gmail.com', '$2y$10$zc8DT.AscNeW4Zx0XfBWku/dJi5wZn9nszahwuOEcm53/d1n2RnWC', '1', '1'),
('DEN00003', 'LEONG WEI TONG', 'weitong0724@gmail.com', '$2y$10$ypeNHk7LRksab5yNXw159ONmK0v4/jTJ66b5Qlo3hrH0jwchhRfIi', '1', '1'),
('DEN00004', 'YAU ZI HAO', 'yauzihao@gmail.com', '$2y$10$0uCeafxmXV65zTtPvLg/4.jYJFlb4/FUftzkXKiH8tuiShS84RkYK', '1', '1');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`Appointment_ID`),
  ADD KEY `ServiceType_ID` (`ServiceType_ID`),
  ADD KEY `Operatinghours_ID` (`Operatinghours_ID`);

--
-- 資料表索引 `cancellation_tokens`
--
ALTER TABLE `cancellation_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- 資料表索引 `closure_date`
--
ALTER TABLE `closure_date`
  ADD PRIMARY KEY (`ClosureDate_ID`);

--
-- 資料表索引 `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedback_ID`),
  ADD KEY `Appointment_ID` (`Appointment_ID`);

--
-- 資料表索引 `operating_hours`
--
ALTER TABLE `operating_hours`
  ADD PRIMARY KEY (`Operatinghours_ID`);

--
-- 資料表索引 `patient_inquiry`
--
ALTER TABLE `patient_inquiry`
  ADD PRIMARY KEY (`Inquiry_ID`);

--
-- 資料表索引 `service_type`
--
ALTER TABLE `service_type`
  ADD PRIMARY KEY (`ServiceType_ID`);

--
-- 資料表索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cancellation_tokens`
--
ALTER TABLE `cancellation_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `closure_date`
--
ALTER TABLE `closure_date`
  MODIFY `ClosureDate_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `operating_hours`
--
ALTER TABLE `operating_hours`
  MODIFY `Operatinghours_ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `patient_inquiry`
--
ALTER TABLE `patient_inquiry`
  MODIFY `Inquiry_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `service_type`
--
ALTER TABLE `service_type`
  MODIFY `ServiceType_ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
