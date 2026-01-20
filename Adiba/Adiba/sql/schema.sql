-- PawSome (Adiba) - Academic MVC Schema
-- Compatible with MariaDB/MySQL

CREATE DATABASE IF NOT EXISTS pawsome CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pawsome;

-- -----------------------------
-- users
-- -----------------------------
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS adoption_requests;
DROP TABLE IF EXISTS pets;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  username VARCHAR(60) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(40) NOT NULL,
  password VARCHAR(255) NOT NULL,
  profile_picture VARCHAR(255) NULL,
  role ENUM('adopter','admin','shelter') NOT NULL DEFAULT 'adopter',
  pets_adopted INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------
-- pets
-- -----------------------------
CREATE TABLE pets (
  pet_id INT AUTO_INCREMENT PRIMARY KEY,
  shelter_id INT NULL,
  name VARCHAR(100) NOT NULL,
  species VARCHAR(50) NOT NULL,
  breed VARCHAR(80) NOT NULL,
  age_years INT NOT NULL DEFAULT 0,
  gender ENUM('Male','Female','Unknown') NOT NULL DEFAULT 'Unknown',
  location VARCHAR(120) NOT NULL,
  personality VARCHAR(255) NULL,
  rescued_on DATE NULL,
  rescued_by VARCHAR(120) NULL,
  health_status VARCHAR(120) NULL,
  adoption_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  adoption_status ENUM('Available','Pending','Adopted') NOT NULL DEFAULT 'Available',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------
-- adoption_requests
-- -----------------------------
CREATE TABLE adoption_requests (
  request_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  pet_id INT NOT NULL,
  note TEXT NULL,
  status ENUM('Pending','Approved','Rejected','Completed') NOT NULL DEFAULT 'Pending',
  created_at DATETIME NOT NULL,
  CONSTRAINT fk_adoption_user FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_adoption_pet FOREIGN KEY (pet_id) REFERENCES pets(pet_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_ar_user (user_id),
  INDEX idx_ar_pet (pet_id),
  INDEX idx_ar_status (status)
) ENGINE=InnoDB;

-- -----------------------------
-- adoption_request_details (form data for request page)
-- -----------------------------
DROP TABLE IF EXISTS adoption_request_details;
CREATE TABLE adoption_request_details (
  request_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT NOT NULL UNIQUE,
  adopter_id INT NOT NULL,
  username VARCHAR(60) NOT NULL,
  full_name VARCHAR(150) NOT NULL,
  address TEXT NOT NULL,
  phone VARCHAR(20) NOT NULL,
  pet_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_req_details_req FOREIGN KEY (request_id) REFERENCES adoption_requests(request_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_req_details_user FOREIGN KEY (adopter_id) REFERENCES users(user_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_req_details_pet FOREIGN KEY (pet_id) REFERENCES pets(pet_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_rd_user (adopter_id),
  INDEX idx_rd_pet (pet_id)
) ENGINE=InnoDB;

-- -----------------------------
-- password_resets (demo/local)
-- -----------------------------
CREATE TABLE password_resets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(120) NOT NULL,
  token VARCHAR(64) NOT NULL,
  expires_at DATETIME NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_pr_email (email),
  INDEX idx_pr_token (token)
) ENGINE=InnoDB;
