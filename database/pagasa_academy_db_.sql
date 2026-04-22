-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 08:16 AM
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
-- Database: `pagasa_academy_db.`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `target_audience` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `posted_by` varchar(100) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `description`, `target_audience`, `message`, `posted_by`, `date_created`, `date_posted`) VALUES
(2, 'ANNOUNCEMENT ', NULL, NULL, 'Welcome to Pag-asa Bible Baptist Academy Information System!', 'Admin Joshua', '2026-03-29 01:52:49', '2026-04-01 06:25:00'),
(4, 'CAPSTONE 1 DEADLINE', 'DATE : APRIL 30 2026\r\n', 'All', '', NULL, '2026-04-05 03:45:15', '2026-04-05 03:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `status` enum('Present','Absent','Late','Excuse') DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `final_grade` int(3) NOT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_name`, `subject`, `final_grade`, `status`) VALUES
(1, 'Joshua Mabanglo', 'Web Development', 95, 'Active'),
(2, 'Jhoana Reofrir', 'Database Management', 94, 'Active'),
(3, 'Joshua Garcia', 'Software Engineering', 93, 'Active'),
(4, 'James Reid', 'System Analysis', 96, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `pending_registrations`
--

CREATE TABLE `pending_registrations` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `grade_to_enter` varchar(50) DEFAULT NULL,
  `lrn` varchar(20) DEFAULT NULL,
  `last_school_attended` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_registrations`
--

INSERT INTO `pending_registrations` (`id`, `first_name`, `middle_name`, `last_name`, `age`, `sex`, `address`, `phone`, `email`, `image`, `birthdate`, `place_of_birth`, `grade_to_enter`, `lrn`, `last_school_attended`, `father_name`, `mother_name`, `status`, `created_at`) VALUES
(1, 'Joshua', 'Sual', 'Mabanglo', 25, 'Male', 'Pasay City Barangay178', '09876546897', 'joshuamabanlo123@gmail.com', NULL, NULL, NULL, 'Grade 10', 'NONE', NULL, NULL, NULL, 'Pending', '2026-03-29 05:12:30'),
(2, 'dadad', 'dad', 'adad', 10, 'Male', 'dada', '324234', 'dad@gmail.com', NULL, NULL, NULL, 'dsad', 'dada', NULL, NULL, NULL, 'Pending', '2026-03-29 05:32:36'),
(3, 'Jonathan ', 'Suarez', 'Mabanglo ', 12, 'Male', 'Molino IV, Bacoor, Cavite City', '0987665432', 'mabanglo01@gmail.com', NULL, NULL, NULL, 'Grade7', 'N/A', NULL, NULL, NULL, 'Pending', '2026-03-29 12:17:14'),
(4, 'dadad', 'ddad', 'Kinston', 34, 'Male', 'fafsdfsfsdf', '423423542354', 'dadadad@gmail.com', NULL, NULL, NULL, 'dada', 'dada', NULL, NULL, NULL, 'Pending', '2026-03-29 12:18:52'),
(5, 'ddada', 'dada', 'dadad', 23, 'Female', 'dadsasfaf', '09432423423', 'josh3232@gmail.com', NULL, NULL, NULL, 'Grade 10', '3432423423', NULL, NULL, NULL, 'Pending', '2026-03-29 12:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `day` varchar(20) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `day_of_week` varchar(20) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `roll_number` varchar(20) DEFAULT NULL,
  `grade_level` varchar(20) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `batch` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `parent_name` varchar(100) DEFAULT NULL,
  `parent_contact` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `application_type` enum('Registration','Re-enrollment') DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `roll_number`, `grade_level`, `section`, `batch`, `gender`, `parent_name`, `parent_contact`, `address`, `status`, `application_type`, `password`, `email`, `image`, `contact_no`) VALUES
(1, NULL, '', 'Grade7', NULL, NULL, 'Male', 'dasd dada', NULL, 'dasdasdasd', 'Rejected', NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, 'Grade 10', NULL, NULL, 'Female', 'Jay Joshua', NULL, 'fsfsfsfss', 'Pending', NULL, NULL, NULL, NULL, NULL),
(5, NULL, 'PBA - 2027', 'Grade 11', NULL, NULL, 'Female', 'Trisha Santos Agoncillio', NULL, 'Molino 3, Espeleta 3 Cavite City', 'Approved', 'Re-enrollment', NULL, NULL, NULL, NULL),
(6, NULL, NULL, 'Grade 10', NULL, NULL, 'Male', 'Joshua  Mabanglo', NULL, 'Barangay Molino 5, Bacoor Cavite Espeleta Street', 'Pending', NULL, NULL, NULL, NULL, NULL),
(7, NULL, 'PBA-2026-1218', 'Grade 11', NULL, NULL, 'Female', 'Amanda J. Bracken', '09778635789', 'Santa Mesa Bukidnon, Samar Leyte ', 'Approved', NULL, NULL, NULL, NULL, NULL),
(8, NULL, 'PBA-2026-6984', 'Grade 8', NULL, NULL, 'Male', 'Mike B. Suarez', '09765447893', 'Blk 1 LT 19 Camel Street. Pasay, City ', 'Approved', 'Re-enrollment', NULL, NULL, NULL, NULL),
(9, 1, '202110777', 'Grade 12 - SHS', 'Section A', NULL, 'Male', NULL, NULL, NULL, 'Approved', NULL, NULL, NULL, NULL, NULL),
(10, 3, '202110777', 'Grade 12 - SHS', 'Section A', NULL, 'Male', NULL, NULL, NULL, 'Approved', NULL, NULL, NULL, NULL, NULL),
(11, 2, '202110777', 'Grade 12 - SHS', 'Section A', NULL, 'Male', NULL, NULL, NULL, 'Approved', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`id`, `student_id`, `subject_id`, `semester`, `school_year`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 1, NULL, NULL),
(3, 1, 2, NULL, NULL),
(4, 1, 3, NULL, NULL),
(5, 10, 1, NULL, NULL),
(6, 10, 2, NULL, NULL),
(7, 10, 3, NULL, NULL),
(8, 11, 1, NULL, NULL),
(9, 11, 2, NULL, NULL),
(10, 11, 3, NULL, NULL),
(11, 11, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `grade_level` varchar(20) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `grade_level`, `teacher_id`) VALUES
(1, 'Mathematics ', 'Grade 10', NULL),
(2, 'Science ', 'Grade 10', NULL),
(3, 'English ', 'Grade 10', NULL),
(4, 'Filipino ', 'Grade 10', NULL),
(5, 'Araling Panlipunan ', 'Grade 10', NULL),
(6, 'Christian Living', 'Grade 10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `user_id`, `employee_id`, `name`, `phone`, `image`, `specialization`) VALUES
(1, NULL, 'PBA-2026', 'Maria Clara ', '09876546897', '1775018528.jpg', 'Programming'),
(2, NULL, 'PBA-2027', 'Telen', '-09998765431', '1775114948.', 'RECESS '),
(3, NULL, 'PBA-2030', 'MIKEY BUSTOS ', '09887690653', '1775115009.jpg', 'CANTEEN ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Teacher','Student') NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `email`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Admin', 'Joshua Mabanglo', NULL, '2026-03-17 23:39:18'),
(2, 'student01', 'student123', 'Student', 'Joshua Mabanglo', NULL, '2026-03-25 05:11:09'),
(3, 'teacher01', 'teacher123', 'Teacher', 'Sample Teacher', NULL, '2026-03-29 04:39:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
