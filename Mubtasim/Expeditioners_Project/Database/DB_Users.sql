-- Creating users database
CREATE DATABASE IF NOT EXISTS PawSome;
USE PawSome;

-- USER TABLE (All Roles)


CREATE TABLE IF NOT EXISTS `users` (
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
INSERT INTO `users`
(full_name, username, email, phone, password, role)
VALUES
('Admin User', 'admin1', 'admin@gmail.com', '01700000000', 'admin123', 'admin'),
('Wayne Foundation', 'WayneF', 'wayne@gmail.com', '01800000000', 'wayne123', 'adopter'),
('Gotham Shelter', 'GothamS', 'shelter@gmail.com', '01900000000', 'shelter123', 'shelter'),
('Krypton Adopters', 'KryptonA', 'krypton@gmail.com', '01900000000', 'krypton123', 'adopter'),
('Metropolis Shelter', 'MetroS', 'metropolis@gmail.com', '01900000000', 'metropolis123', 'shelter'),
('PetVengers', 'PetV', 'petvengers@gmail.com', '01900000000', 'petvengers123', 'shelter'),
('Tony Stark', 'IronMan', 'tony@gmail.com', '01900000000', 'ironman123', 'adopter'),
('Natasha Romanoff', 'BlackWidow', 'natasha@gmail.com', '01900000000', 'blackwidow123', 'adopter'),
('Bruce Banner', 'Hulk', 'hulk@gmail.com', '01900000000', 'hulk123', 'adopter');