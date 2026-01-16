-- =========================
-- ADOPTIONS TABLE
-- =========================
CREATE TABLE IF NOT EXISTS `pets` (
    adoption_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    adopter_id INT NOT NULL,
    shelter_id INT NOT NULL,
    adoption_status ENUM('Pending', 'Approved', 'Rejected', 'Completed') DEFAULT 'Pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reviewed_at TIMESTAMP NULL,

    CONSTRAINT fk_adoption_pet
        FOREIGN KEY (pet_id)
        REFERENCES `Pets Table`(pet_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_adoption_adopter
        FOREIGN KEY (adopter_id)
        REFERENCES `User Table`(user_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_adoption_shelter
        FOREIGN KEY (shelter_id)
        REFERENCES `User Table`(user_id)
        ON DELETE CASCADE
);

-- =========================
-- SAMPLE ADOPTION DATA
-- =========================
INSERT INTO `pets`
(pet_id, adopter_id, shelter_id, adoption_status, reviewed_at)
VALUES
-- Pending adoption for Buddy
(1, 102, 3, 'Pending', NULL),

-- Approved adoption for Buddy
(1, 36, 3, 'Approved', '2025-12-20 14:30:00'),

-- Completed adoption for Luna
(2, 102, 3, 'Completed', '2025-12-18 11:00:00'),

-- Rejected adoption attempt
(2, 36, 3, 'Rejected', '2025-12-17 16:45:00');
