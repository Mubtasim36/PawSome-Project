# PawSome (Adiba) – Adopter Module (PHP MVC)

This is a simple **academic PHP + MySQL MVC** project that implements the **complete Adopter user-flow**:

- Authentication: Login, Register, Logout
- Account Management: View/Edit Profile, Change Password, Delete Account
- Reset Password (demo/local): Generates a reset link and shows it on-screen
- Dashboard (personalized)
- Browse Pets / Pet Details
- Send Adoption Request
- Track Adoption Requests
- Complete Adoption (only if request is **Approved**)

## Tech Stack

- PHP 8+
- MySQL/MariaDB
- MVC (no framework)
- Pure HTML/CSS
- AJAX + JSON (for dynamic flows)

---

## 1) Setup Database

1. Create a database named `pawsome` (or import the schema which creates it).
2. Import these SQL files in order:
   - `sql/schema.sql`
   - `sql/seed.sql`

> `seed.sql` adds a demo adopter and some pets.

Demo account:

- Email: `adopter@example.com`
- Password: `123456`

---

## 2) Configure DB Credentials

Edit:

`app/config/database.php`

```php
return [
    'host' => 'localhost',
    'db'   => 'pawsome',
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4',
];
```

---

## 3) Run on Apache (XAMPP/WAMP/Laragon)

### Option A: Put project inside `htdocs`

- Put the project folder in `htdocs` (XAMPP)
- The **public** folder is the web root

Example:

- `C:/xampp/htdocs/Adiba/public`

Then open:

- `http://localhost/Adiba/public/`

### Option B: Create a VirtualHost

Set the document root to:

- `.../Adiba/public`

Ensure `mod_rewrite` is enabled.

---

## 4) Routes

### Web routes

- `/auth/login`
- `/auth/register`
- `/auth/forgot`
- `/auth/reset`

- `/adopter/dashboard`
- `/adopter/pets`
- `/adopter/petdetails?pet_id=1`
- `/adopter/requests`
- `/adopter/profile`
- `/adopter/editprofile`
- `/adopter/changepassword`

### API routes (AJAX)

- `/api/auth/login`
- `/api/auth/register`
- `/api/auth/requestReset`
- `/api/auth/resetPassword`

- `/api/adopter/sendRequest`
- `/api/adopter/loadRequests`
- `/api/adopter/completeAdoption`
- `/api/adopter/updateProfile`
- `/api/adopter/changePassword`
- `/api/adopter/deleteProfile`

---

## Notes

- Password reset is implemented as a **local demo flow** (no email service).
- Adoption completion is only allowed if the request is **Approved**.
  - In this adopter-only module, approvals are typically done by an admin/shelter in a full system.
  - For testing, you can manually set a request to Approved in phpMyAdmin:
    - `adoption_requests.status = 'Approved'`
