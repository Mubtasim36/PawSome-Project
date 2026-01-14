-- Creating users database
CREATE DATABASE IF NOT EXISTS PawSome;
USE PawSome;

-- USER TABLE (All Roles)


CREATE TABLE IF NOT EXISTS `User Table` (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'adopter', 'shelter') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pre defined users
INSERT INTO `User Table`
(full_name, username, email, phone, password, role)
VALUES
('Admin User', 'admin1', 'admin@gmail.com', '01700000000', 'admin123', 'admin'),
('John Doe', 'johndoe', 'john@gmail.com', '01800000000', 'john123', 'adopter'),
('Paw Rescue Bangladesh', 'pawrescue', 'shelter@gmail.com', '01900000000', 'shelter123', 'shelter');