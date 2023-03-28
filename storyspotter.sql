-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2023 at 11:37 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storyspotter`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `thumbnail` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `cta` varchar(20) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `thumbnail`, `description`, `cta`, `image`) VALUES
(1, 'Travel', 'hero-travel.jpg', 'Meet the people, the Food and the Sights', 'Take a Look', 'hero-travel.jpg'),
(2, 'Hidden Gems', 'hero-gems.jpg', 'You do not get to know these places ever existed', 'Take a Look', 'hero-gems.jpg'),
(3, 'Historic Sites', 'hero-historic.jpg', 'History are made possible by our heroes who came out victorious', 'Take a Look', 'hero-historic.jpg'),
(4, 'Urban Exploration', 'hero-urban.jpg', 'Get a feel of the architecture, the culture, and the people that make a place unique', 'Take a Look', 'hero-urban.jpg'),
(5, 'Natural Wonders', 'hero-scenrey.jpg', 'Experience the scenery and wildlife of natural beauties in several places', 'Take a Look', 'hero-scenrey.jpg'),
(6, 'Local Gems', 'hero-local.jpg', 'Get to know the hidden places in a locality, community or city', 'Take a Look', 'hero-local.jpg'),
(7, 'Fiction', 'hero-fiction.jpg', 'Explore imaginary places that will blow your mind', 'Take a Look', 'hero-fiction.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `story_id`, `content`, `likes`, `user_id`, `created_at`) VALUES
(3, 1, 'super nice', 0, 1, '2023-03-27 09:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `country` varchar(20) NOT NULL,
  `coordinate` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `country`, `coordinate`) VALUES
(1, 'Liberia', '9.0820° N, 8.6753° E'),
(3, 'Congo', '127 7272 772'),
(4, 'Liberia', '127 7272 772');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `resource` varchar(20) NOT NULL,
  `ability` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `resource`, `ability`) VALUES
(1, 'story', 'create'),
(2, 'story', 'delete'),
(3, 'story', 'read'),
(4, 'story', 'update'),
(5, 'comment', 'create'),
(6, 'comment', 'delete'),
(7, 'comment', 'read'),
(8, 'comment', 'update'),
(9, 'story', 'all'),
(10, 'comment', 'all'),
(11, 'story', 'publish'),
(12, 'all', 'all'),
(13, 'user', 'create'),
(14, 'user', 'update'),
(15, 'user', 'update');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(3, 'story_seeker'),
(4, 'story_teller'),
(5, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `role_privileges`
--

CREATE TABLE `role_privileges` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_privileges`
--

INSERT INTO `role_privileges` (`id`, `role_id`, `privilege_id`) VALUES
(1, 3, 3),
(5, 3, 4),
(2, 3, 10),
(3, 4, 1),
(4, 4, 3),
(7, 5, 12);

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `location_id` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `user_id`, `title`, `description`, `category_id`, `content`, `location_id`, `image`, `views`, `likes`, `published`, `created_at`, `updated_at`) VALUES
(1, 1, ' The Lottery', NULL, 7, 'The morning of June 27th was clear and sunny, with the fresh warmth of a full-summer day; the flowers were blossoming profusely and the grass was richly green. The people of the village began to gather in the square, between the post office and the bank, around ten o’clock; in some towns there were so many people that the lottery took two days and had to be started on June 20th, but in this village, where there were only about three hundred people, the whole lottery took less than two hours, so it could begin at ten o’clock in the morning and still be through in time to allow the villagers to get home for noon dinner.\r\n\r\nThe children assembled first, of course. School was recently over for the summer, and the feeling of liberty sat uneasily on most of them; they tended to gather together quietly for a while before they broke into boisterous play, and their talk was still of the classroom and the teacher, of books and reprimands. Bobby Martin had already stuffed his pockets full of stones, and the other boys soon followed his example, selecting the smoothest and roundest stones; Bobby and Harry Jones and Dickie Delacroix—the villagers pronounced this name “Dellacroy”—eventually made a great pile of stones in one corner of the square and guarded it against the raids of the other boys. The girls stood aside, talking among themselves, looking over their shoulders at the boys, and the very small children rolled in the dust or clung to the hands of their older brothers or sisters.\r\n\r\nSoon the men began to gather, surveying their own children, speaking of planting and rain, tractors and taxes. They stood together, away from the pile of stones in the corner, and their jokes were quiet and they smiled rather than laughed. The women, wearing faded house dresses and sweaters, came shortly after their menfolk. They greeted one another and exchanged bits of gossip as they went to join their husbands. Soon the women, standing by their husbands, began to call to their children, and the children came reluctantly, having to be called four or five times. Bobby Martin ducked under his mother’s grasping hand and ran, laughing, back to the pile of stones. His father spoke up sharply, and Bobby came quickly and took his place between his father and his oldest brother.\r\n\r\nThe lottery was conducted—as were the square dances, the teen club, the Halloween program—by Mr. Summers, who had time and energy to devote to civic activities. He was a round-faced, jovial man and he ran the coal business, and people were sorry for him because he had no children and his wife was a scold. When he arrived in the square, carrying the black wooden box, there was a murmur of conversation among the villagers, and he waved and called. “Little late today, folks. ” The postmaster, Mr. Graves, followed him, carrying a three-legged stool, and the stool was put in the center of the square and Mr. Summers set the black box down on it. The villagers kept their distance, leaving a space between themselves and the stool, and when Mr. Summers said, “Some of you fellows want to give me a hand?” there was a hesitation before two men. Mr. Martin and his oldest son, Baxter, came forward to hold the box steady on the stool while Mr. Summers stirred up the papers inside it.\r\n\r\nThe original paraphernalia for the lottery had been lost long ago, and the black box now resting on the stool had been put into use even before Old Man Warner, the oldest man in town, was born. Mr. Summers spoke frequently to the villagers about making a new box, but no one liked to upset even as much tradition as was represented by the black box. There was a story that the present box had been made with some pieces of the box that had preceded it, the one that had been constructed when the first people settled down to make a village here. Every year, after the lottery, Mr. Summers began talking again about a new box, but every year the subject was allowed to fade off without anything’s being done. The black box grew shabbier each year: by now it was no longer completely black but splintered badly along one side to show the original wood color, and in some places faded or stained.', 1, 'unuuu.jpg', 0, 0, 1, '2023-03-26 15:14:01', '2023-03-27 04:28:24'),
(2, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png', 0, 0, 0, '2023-03-27 04:48:47', '0000-00-00 00:00:00'),
(3, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png', 0, 0, 0, '2023-03-27 04:48:47', '0000-00-00 00:00:00'),
(4, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png', 0, 0, 0, '2023-03-27 04:53:06', '0000-00-00 00:00:00'),
(6, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png', 0, 0, 0, '2023-03-27 04:55:11', '0000-00-00 00:00:00'),
(18772, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:30:52', '0000-00-00 00:00:00'),
(18773, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:30:52', '0000-00-00 00:00:00'),
(18774, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:30:56', '0000-00-00 00:00:00'),
(18775, 1, 'I am the greatest', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:30:56', '0000-00-00 00:00:00'),
(18776, 1, 'ebuka', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:31:57', '0000-00-00 00:00:00'),
(18777, 1, 'ebuka', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:31:57', '0000-00-00 00:00:00'),
(18778, 1, 'hia', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:33:14', '0000-00-00 00:00:00'),
(18779, 1, 'hia', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:33:14', '0000-00-00 00:00:00'),
(18780, 1, 'hia', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:33:14', '0000-00-00 00:00:00'),
(18781, 1, 'hia', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:33:14', '0000-00-00 00:00:00'),
(18782, 1, 'how many', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:46:01', '0000-00-00 00:00:00'),
(18783, 1, 'how many', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:46:01', '0000-00-00 00:00:00'),
(18784, 1, 'how many', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:46:01', '0000-00-00 00:00:00'),
(18785, 1, 'how many', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:46:01', '0000-00-00 00:00:00'),
(18786, 1, 'how many now', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:52:09', '0000-00-00 00:00:00'),
(18787, 1, 'how many now', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 05:52:09', '0000-00-00 00:00:00'),
(18788, 1, 'hia', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 06:03:34', '0000-00-00 00:00:00'),
(18789, 1, 'hia ka', 'story that talks about my background, achievements', 1, 'tell me the story cos i dont have one now', 1, 'author.png8', 0, 0, 0, '2023-03-27 06:14:20', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `bio` varchar(200) DEFAULT NULL,
  `followers` bigint(20) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `gender`, `dob`, `email`, `image`, `telephone`, `location_id`, `bio`, `followers`, `role_id`, `password`, `email_verified_at`, `created_at`) VALUES
(1, 'David', 'Robinson', 'male', '2013-03-05', 'davidrobinson5616@yahoo.com', 'author-4.png', '+23480999999', 1, 'I am energetic author. I write stories and novels for fun', 0, 4, 'secret', NULL, '2023-03-27 22:33:21'),
(2, 'Mary', 'Robben', 'female', '2014-03-14', 'maryrobben@gamil.com', 'author.png', '2347882828828', 1, 'I love to read stories', 0, 3, 'secret', NULL, '2023-03-27 22:33:21'),
(3, 'Eneje ', 'Everistus', 'male', '2013-03-14', 'enejeeveristus@gmail.com', NULL, '+552525525252', 1, 'I am the owner of storyspotter website.', 0, 5, 'secret', NULL, '2023-03-27 22:33:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `story_id` (`story_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_privileges`
--
ALTER TABLE `role_privileges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_id_2` (`role_id`,`privilege_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `privilege_id` (`privilege_id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_index` (`user_id`),
  ADD KEY `category_index` (`category_id`),
  ADD KEY `location index` (`location_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email index` (`email`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `location index` (`location_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_privileges`
--
ALTER TABLE `role_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18790;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_privileges`
--
ALTER TABLE `role_privileges`
  ADD CONSTRAINT `role_privileges_ibfk_1` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`),
  ADD CONSTRAINT `role_privileges_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `stories_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `stories_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
