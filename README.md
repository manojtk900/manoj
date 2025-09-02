# Student Result Portal (PHP + MySQL)

## Setup
1. Move this folder to your XAMPP `htdocs/` directory.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create the database and tables in MySQL:

   ```sql
   CREATE DATABASE studentdb;
   USE studentdb;

   CREATE TABLE students (
       usn VARCHAR(20) PRIMARY KEY,
       name VARCHAR(100),
       dept VARCHAR(50),
       sem INT,
       marks INT
   );

   CREATE TABLE admin (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) UNIQUE,
       password VARCHAR(255)
   );

   INSERT INTO admin (username, password) VALUES ('admin', MD5('1234'));
   ```

4. Visit `http://localhost/student-result/`
   - Use the form to view results by USN (once data exists).
   - Admin login at `Admin Login` (username: `admin`, password: `1234`).

## Notes
- Change DB credentials in `config.php` if needed.
- For production, store passwords using stronger hashing (e.g., `password_hash` / `password_verify`).
