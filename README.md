🐾 PawSome

A Role-Based Pet Adoption Web Platform

Helping pets find their forever homes

📖 Table of Contents

Project Overview

Objectives

User Roles

Features

Common Features

Admin Features

Adopter Features

Shelter Features

Technology Stack

System Architecture

Database Design

Security

Installation & Setup

Team Members

Future Enhancements

License

🐕 Project Overview

PawSome is a full-stack pet adoption web application that connects adopters, animal shelters, and administrators through a structured, role-based system. Each user type has a dedicated dashboard and feature set, ensuring clarity, security, and efficiency throughout the adoption process.

The platform is built using HTML, CSS, JavaScript, PHP, and MySQL, following standard web development and database design principles.

🎯 Objectives

Create a transparent and structured pet adoption workflow

Provide separate dashboards for Admin, Shelter, and Adopter

Enforce role-based access control

Maintain secure authentication and data integrity

Apply full-stack web technologies learned in the course

👥 User Roles

Role

Description

Admin

Oversees users, pets, and adoption data

Adopter

Browses pets and submits adoption requests

Shelter

Manages pets and handles adoption requests

🚀 Features

Common Features

Available to all authenticated users:

Secure user registration and login

Session-based authentication

Profile management (view, edit, delete)

Password change / reset

Pet image uploads

Personalized dashboard

Admin Features

View platform-wide user statistics

Manage user accounts (Admin, Adopter, Shelter)

Monitor and manage adoption records

Adopter Features

Browse available pets

View detailed pet profiles

Submit adoption requests

Track adoption request status

Shelter Features

Add, update, and delete pet listings (CRUD)

Manage incoming adoption requests

Approve or reject adoption applications

Manage daycare system for pets

✅ Each user role includes at least three unique features, fulfilling project requirements.

🧰 Technology Stack

Frontend

HTML5

CSS3

JavaScript (Vanilla)

Backend

PHP

Database

MySQL (Relational Database)

Tools

XAMPP / WAMP

phpMyAdmin

Git & GitHub

🏗 System Architecture

Client (Browser)
     ↓
Frontend (HTML / CSS / JS)
     ↓
Backend (PHP)
     ↓
Database (MySQL)

🗄 Database Design

Key Tables:

users – stores user credentials and roles

pets – stores pet information linked to shelters

adoptions – manages adoption requests and statuses

Relationships:

One shelter → many pets

One adopter → many adoption requests

One pet → many adoption requests

🔐 Security

Password hashing

Session-based authentication

Role-based access control (RBAC)

Server-side validation

⚙️ Installation & Setup

Clone the repository

git clone https://github.com/Mubtasim36/PawSome-Project

Move the project to your local server directory

htdocs/ (XAMPP)

Import the SQL file into phpMyAdmin

Configure database credentials in PHP config file

Start Apache and MySQL

Open the project in your browser

http://localhost/PawSome

👨‍💻 Team Members

Group 4 – Web Technologies (Fall 2025–2026)

Student ID

Name

22-48990-3

Shahriar Hossain

22-49002-3

Al Mubtasim

22-49012-3

Adiba Tanzila

🔮 Future Enhancements



Email notifications

Advanced search & filters

UI/UX improvements

Adoption history analytics

📄 License

This project is developed strictly for academic purposes as part of the Web Technologies course.

🐾 PawSome — Building bridges between pets and people
