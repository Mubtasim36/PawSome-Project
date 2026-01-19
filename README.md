🐾 PawSome – Pet Adoption Web Application
📌 Project Overview

PawSome is a role-based pet adoption web platform designed to connect adopters, animal shelters, and administrators in a structured, transparent, and efficient adoption process. The system allows shelters to manage pets and adoption requests, adopters to browse and apply for pets, and admins to oversee users and adoption data.

This project is developed as part of the Web Technologies course (Fall 2025–2026) and follows standard full‑stack web development practices.

🎯 Objectives

Simplify the pet adoption process

Provide separate dashboards for different user roles

Maintain secure authentication and role‑based access control

Ensure clean data handling using a relational SQL database

👥 User Roles

The system supports three distinct user types, each with unique permissions and features:

Admin

Adopter

Shelter

⚙️ Core Features (All Users)

These features are available to every registered user, regardless of role:

🔐 Authentication

User registration

Secure login

Logout

👤 Account Management

View profile information

Edit profile details

Change or reset password

Delete account

📊 Dashboard

Personalized dashboard after login

Role‑specific navigation and actions

Image upload for pets and user profiles

🛠️ Role‑Specific Features
👑 Admin Features

View overall user statistics

Manage user accounts (view/update/remove)

Manage adoption records and statuses

🐶 Adopter Features

Browse available pets

View detailed pet profiles

Send adoption requests

Track adoption request status

🏠 Shelter Features

Add, update, and remove pets (CRUD operations)

Manage incoming adoption requests (approve/reject)

Daycare system management for pets

Note: Each user role contains at least three unique features distinct from the others, as required.

🧱 Technology Stack
Frontend

HTML5

CSS3

JavaScript 

Backend

PHP

Database

MySQL (SQL-based relational database)

🗃️ Database Design (High Level)

users – stores user credentials and roles (Admin, Adopter, Shelter)

pets – stores pet details linked to shelters

adoptions – manages adoption requests and statuses

(Relationships are enforced using foreign keys.)

🔐 Security Considerations

Session-based authentication

Role-based access control

Server-side validation

Password hashing

🚀 How to Run the Project

Clone the repository

git clone https://github.com/Mubtasim36/PawSome-Project

Place the project inside your local server directory (e.g., htdocs for XAMPP)

Import the SQL database into phpMyAdmin

Update database credentials in the PHP config file

Start Apache & MySQL

Access the project via browser

👨‍💻 Team Members

Group 4 – Web Technologies

Student ID	Name
22-48990-3	Shahriar Hossain
22-49002-3	Al Mubtasim
22-49012-3	Adiba Tanzila
📄 License

This project is developed for academic purposes only.

📬 Future Enhancements (Optional)



Email notifications for adoption updates

Advanced search and filtering

UI/UX improvements

PawSome – Helping pets find their forever homes 🐾
