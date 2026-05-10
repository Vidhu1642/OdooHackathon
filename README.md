# OdooHackathon

## TravelLoop Backend Setup

This project now includes a PHP backend for XAMPP/MySQL using the `TravelLoop` database.

### Steps

1. Start XAMPP and enable Apache + MySQL.
2. Open phpMyAdmin and run `TravelLoop.sql` to create the database and tables.
3. Place the project folder under `xampp/htdocs` or configure your virtual host to point to `e:/OdooHackathon`.
4. Use the new API files in `backend/`:
   - `backend/config.php`
   - `backend/auth.php`
   - `backend/trips.php`
   - `backend/profile.php`
   - `backend/notes.php`
   - `backend/itinerary.php`
   - `backend/budget.php`
   - `backend/search.php`
   - `backend/admin.php`
5. Access the app in your browser through XAMPP, for example `http://localhost/OdooHackathon/index.html`.

### Notes

- The backend uses `root` as the MySQL user with no password by default. If your XAMPP MySQL user differs, update `backend/config.php`.
- The backend supports authentication, trip CRUD, itinerary save/load, profile updates, notes, budgets, search, and admin stats.
