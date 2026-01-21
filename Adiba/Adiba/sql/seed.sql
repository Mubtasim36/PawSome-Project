USE pawsome;

-- Demo adopter (email: adopter@example.com, password: 123456)
INSERT INTO users (full_name, username, email, phone, password, profile_picture, role, pets_adopted)
VALUES ('Demo Adopter', 'demo_adopter', 'adopter@example.com', '01700000000', '$2y$10$Flvb60tFYlkck7jxept3v./SAhUEQYr6YFAwJEoiOSrvs0uWcGeqq', NULL, 'adopter', 0)
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name);

-- Sample pets
INSERT INTO pets
(shelter_id, name, species, breed, age_years, gender, location, personality, rescued_on, rescued_by, health_status, adoption_fee, adoption_status)
VALUES
(10, 'Charlie', 'Dog', 'Beagle', 3, 'Male', 'Gulshan, Dhaka', 'Curious, Active', '2024-02-15', 'Safe Paws Shelter', 'Vaccinated', 2800.00, 'Available'),
(10, 'Misty', 'Cat', 'Siamese', 2, 'Female', 'Gulshan, Dhaka', 'Quiet, Loving', '2024-03-10', 'Safe Paws Shelter', 'Healthy', 2200.00, 'Available'),
(5, 'Rocky', 'Dog', 'Boxer', 4, 'Male', 'Uttara, Dhaka', 'Loyal, Playful', '2023-12-05', 'Hope Animal Care', 'Vaccinated', 3200.00, 'Available'),
(5, 'Coco', 'Cat', 'British Shorthair', 1, 'Female', 'Mirpur, Dhaka', 'Calm, Friendly', '2024-01-20', 'Hope Animal Care', 'Healthy', 2500.00, 'Available'),
(7, 'Luna', 'Cat', 'Domestic', 1, 'Female', 'Dhanmondi, Dhaka', 'Affectionate, Gentle', '2024-04-08', 'City Rescue', 'Dewormed', 1800.00, 'Available'),
(7, 'Max', 'Dog', 'Labrador', 2, 'Male', 'Banani, Dhaka', 'Smart, Social', '2024-05-19', 'City Rescue', 'Vaccinated', 3500.00, 'Available')
;
