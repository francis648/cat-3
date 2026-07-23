CREATE DATABASE IF NOT EXISTS secure_contact_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE secure_contact_portal;

DROP TABLE IF EXISTS submissions;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_username (username),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

CREATE TABLE submissions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(160) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_submissions_created_at (created_at),
    CONSTRAINT fk_submissions_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Sample password for demo.user@example.com is: password
INSERT INTO users (username, email, password_hash) VALUES
('demo_user', 'demo.user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC4.1VxY3kY6n6Qx3Y6');

INSERT INTO submissions (user_id, name, email, subject, message) VALUES
(1, 'Amina Rahman', 'amina@example.com', 'Partnership question', 'Could we schedule a short call next week to discuss the partnership details?'),
(1, 'Jon Bell', 'jon@example.com', 'Follow-up', 'Thanks for the quick response. I have included the remaining information here.');
