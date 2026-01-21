DROP TABLE IF EXISTS `Adoptions Table`;

CREATE TABLE IF NOT EXISTS `adoptions` (
    adoption_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    pet_name VARCHAR(50) NOT NULL,
    adopter_id INT NOT NULL,
    shelter_id INT NOT NULL,
    adoption_status ENUM('Pending', 'Approved', 'Rejected', 'Completed') DEFAULT 'Pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

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

INSERT INTO `adoptions`
(pet_id, pet_name, adopter_id, shelter_id, adoption_status)
VALUES
(1, 'Buddy', 2, 3, 'Pending'),
(1, 'Buddy', 2, 3, 'Approved'),
(2, 'Luna', 2, 3, 'Completed'),
(2, 'Luna', 2, 3, 'Rejected');