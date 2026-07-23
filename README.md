# Signal Desk

Signal Desk is a secure, database-driven PHP/MySQL contact management portal. It includes account registration, login/logout, a protected dashboard, profile page, contact form, submissions directory, and information hub.

## Requirements

- PHP 8.1+ with PDO MySQL enabled
- MySQL 8.0+ or MariaDB 10.5+
- Apache, nginx, or PHP's development server

## Installation

1. Create the database and sample records:

   ```bash
   mysql -u root -p < database.sql
   ```

2. Update the database constants in `config.php` for the local MySQL host, database, username, and password.
3. From the project directory, start PHP's development server:

   ```bash
   php -S localhost:8000
   ```

4. Open `http://localhost:8000` and register an account, or use the sample account shown in `database.sql`.

## Security notes

- PDO prepared statements are used for all SQL values.
- Passwords are stored with `password_hash()` and verified with `password_verify()`.
- Sessions use HttpOnly, SameSite cookies and regenerate their identifier after login.
- POST forms use a session-backed CSRF token.
- Server-side validation checks required values, email formats, and lengths.
- HTML output is escaped with `htmlspecialchars()`.

See `TECHNICAL_DOCUMENTATION.md` for the architecture, ERD, validation strategy, and deployment notes.
