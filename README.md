# e-LapFa Complaint Management System

Simple ready-to-run PHP/MySQL complaint management system using **pure CSS** (no Bootstrap).
Compatible with PHP 7.4+ and XAMPP.

## Setup
1. Copy the project folder into `htdocs/` (e.g. `C:\xampp\htdocs\e-lapfa-complaint-system`).
2. Create a MySQL database named `e_lapfa`.
3. Import `database.sql` into the `e_lapfa` database (phpMyAdmin or MySQL CLI).
4. Edit `includes/db.php` if your DB credentials differ.
5. Run `http://localhost/e-lapfa-complaint-system/setup/create_admin.php` once to create the default admin.
   - Default admin: **admin@example.com / admin123**
6. Open `http://localhost/e-lapfa-complaint-system/` in your browser.

## Notes
- File uploads are validated (PNG,JPEG,PDF) and limited to 2MB.
- AJAX polling is used for real-time complaint status updates and simple chat.
- Theme (Light/Dark/Custom) saved in `localStorage` for demonstration.
- This is a compact educational project — feel free to extend.

