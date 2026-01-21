CREATE TABLE IF NOT EXISTS activity_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('user', 'adoption', 'system') NOT NULL,
    description VARCHAR(255) NOT NULL,
    performed_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (performed_by) REFERENCES `User Table`(user_id)
);