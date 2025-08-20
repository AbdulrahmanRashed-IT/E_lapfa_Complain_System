-- Database: e_lapfa
CREATE DATABASE IF NOT EXISTS `e_lapfa` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `e_lapfa`;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  profile_pic VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE complaints (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  file VARCHAR(255) DEFAULT NULL,
  status ENUM('Pending','In Progress','Resolved') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  sender ENUM('user','admin') NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- sample admin
INSERT INTO users (name, email, password, role) VALUES
('Default Admin', 'admin@example.com', '{PASSWORD_PLACEHOLDER}', 'admin');

-- sample user (password: user123)
INSERT INTO users (name, email, password) VALUES
('Demo User', 'user@example.com', '$2y$10$abcdefghijklmnopqrstuv'); -- replace with real hash

