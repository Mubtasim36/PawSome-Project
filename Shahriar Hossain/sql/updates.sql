-- Run this after importing your current pawsome database

-- 1) Add profile images
ALTER TABLE users
  ADD COLUMN profile_image VARCHAR(255) NULL;

ALTER TABLE pets
  ADD COLUMN pet_profile_image VARCHAR(255) NULL;

-- 2) Daycare tables
CREATE TABLE IF NOT EXISTS daycare_slots (
  slot_id INT AUTO_INCREMENT PRIMARY KEY,
  shelter_id INT NOT NULL,
  slot_date DATE NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  capacity INT NOT NULL DEFAULT 5,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_daycare_slots_shelter FOREIGN KEY (shelter_id)
    REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS daycare_bookings (
  booking_id INT AUTO_INCREMENT PRIMARY KEY,
  slot_id INT NOT NULL,
  pet_id INT NOT NULL,
  owner_id INT NOT NULL,
  shelter_id INT NOT NULL,
  status ENUM('Booked','CheckedIn','CheckedOut','Cancelled') NOT NULL DEFAULT 'Booked',
  checkin_at DATETIME NULL,
  checkout_at DATETIME NULL,
  notes VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_daycare_booking_slot FOREIGN KEY (slot_id)
    REFERENCES daycare_slots(slot_id) ON DELETE CASCADE,
  CONSTRAINT fk_daycare_booking_pet FOREIGN KEY (pet_id)
    REFERENCES pets(pet_id) ON DELETE CASCADE,
  CONSTRAINT fk_daycare_booking_owner FOREIGN KEY (owner_id)
    REFERENCES users(user_id) ON DELETE CASCADE,
  CONSTRAINT fk_daycare_booking_shelter FOREIGN KEY (shelter_id)
    REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS daycare_logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT NOT NULL,
  shelter_id INT NOT NULL,
  activity_notes TEXT NOT NULL,
  health_notes TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_daycare_logs_booking FOREIGN KEY (booking_id)
    REFERENCES daycare_bookings(booking_id) ON DELETE CASCADE,
  CONSTRAINT fk_daycare_logs_shelter FOREIGN KEY (shelter_id)
    REFERENCES users(user_id) ON DELETE CASCADE
);
