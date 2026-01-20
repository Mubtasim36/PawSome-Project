# PawSome (PHP MVC) - Shelter Features

This project adds the Shelter module:
- **Manage Available Pets (CRUD)** + pet profile image upload
- **Manage Adoption Requests** (status update via AJAX/JSON)
- **Daycare system**: Slots, Bookings, Check-in/Check-out, Daily Activity & Health Logs
- **Shelter Profile** update + shelter profile image upload

Tech rules followed:
- Pure HTML/CSS (no external UI libraries)
- Sessions for auth
- JS validation + PHP validation
- AJAX + JSON endpoints
- MVC structure

## 1) Database
1. Create a database named `pawsome`.
2. Import your current tables (users, pets, adoptions, activity_log).
3. Run the migration file:
   - `sql/updates.sql`

## 2) Configure DB + Base URL
Edit:
- `app/config/database.php` (host, user, pass)
- `app/config/config.php`

**Important**: set `BASE_URL` to match your folder.
Examples:
- If your project is `http://localhost/pawsome/public` then:
  - `define('BASE_URL', '/pawsome/public');`
- If your project is `http://localhost/Expeditioners_Project/public` then:
  - `define('BASE_URL', '/Expeditioners_Project/public');`

## 3) Run the project
### Option A: XAMPP/WAMP
1. Put the project folder in `htdocs` (XAMPP).
2. Start Apache + MySQL.
3. Open:
   - `http://localhost/<your-folder>/public/index.php?r=shelter/dashboard`

### Option B: PHP built-in server
From the project root:
```bash
php -S localhost:8000 -t public
```
Then open:
- `http://localhost:8000/index.php?r=shelter/dashboard`

## 4) Login/session
This build includes a demo session user in `public/index.php` for easy testing.
If you already have login, remove the demo block and ensure:
```php
$_SESSION['user'] = ['user_id'=>..., 'role'=>'shelter', 'full_name'=>...];
```

## 5) Upload folders
Uploads go to:
- `public/uploads/shelters/`
- `public/uploads/pets/`

Make sure they are writable by PHP.

