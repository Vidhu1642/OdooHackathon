CREATE DATABASE IF NOT EXISTS TravelLoop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE TravelLoop;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    language VARCHAR(50) DEFAULT 'English',
    bio TEXT DEFAULT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    public_profile TINYINT(1) DEFAULT 1,
    email_notifications TINYINT(1) DEFAULT 1,
    dark_mode TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    destination VARCHAR(255) DEFAULT NULL,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    travelers INT DEFAULT 1,
    budget DECIMAL(10,2) DEFAULT 0.00,
    description TEXT DEFAULT NULL,
    cover_photo VARCHAR(255) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'Upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS itineraries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trip_id INT DEFAULT NULL,
    title VARCHAR(255) DEFAULT NULL,
    summary TEXT DEFAULT NULL,
    public_token VARCHAR(64) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS itinerary_stops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    itinerary_id INT NOT NULL,
    city VARCHAR(255) NOT NULL,
    arrival_date DATE DEFAULT NULL,
    departure_date DATE DEFAULT NULL,
    ordering INT DEFAULT 0,
    FOREIGN KEY (itinerary_id) REFERENCES itineraries(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS itinerary_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stop_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    duration VARCHAR(100) DEFAULT NULL,
    cost DECIMAL(10,2) DEFAULT 0.00,
    ordering INT DEFAULT 0,
    FOREIGN KEY (stop_id) REFERENCES itinerary_stops(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trip_id INT DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT DEFAULT NULL,
    tag VARCHAR(100) DEFAULT NULL,
    last_edited TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS budgets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trip_id INT DEFAULT NULL,
    total_budget DECIMAL(10,2) DEFAULT 0.00,
    spent_amount DECIMAL(10,2) DEFAULT 0.00,
    notes TEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS activities_catalog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT NULL,
    location VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    duration VARCHAR(100) DEFAULT NULL,
    cost DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT IGNORE INTO activities_catalog (name, category, location, description, duration, cost) VALUES
('Beach Day', 'Leisure', 'Bali', 'Relax on the beach with snorkeling and sunset views.', '4 Hours', 60.00),
('City Tour', 'Sightseeing', 'Paris', 'Guided walking tour through iconic landmarks and museums.', '5 Hours', 120.00),
('Food Crawl', 'Dining', 'Tokyo', 'Taste local specialties in popular food districts.', '3 Hours', 80.00);
