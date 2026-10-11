# SavorNest – Recipe Sharing & Management Platform

A full-stack recipe-sharing web application developed using **Laravel 12**, **PHP**, **MySQL/SQLite**, and **Blade Templates**. SavorNest enables users to discover, create, manage, and share recipes with detailed ingredients, quantities, and step-by-step preparation instructions. It also provides an administrative dashboard for managing recipes, users, categories, cuisines, and ingredients.

---

# Objectives

The main objectives of this project are:

* Provide a centralized platform for discovering and sharing recipes.
* Enable users to create, edit, and manage their own recipes.
* Organize recipes by categories, cuisines, and food types.
* Maintain structured ingredient quantities and preparation steps.
* Implement secure authentication and role-based access control.
* Provide administrative tools for content moderation and platform management.
* Demonstrate Laravel development, MVC architecture, database relationships, and CRUD operations.

---

# Features

## User Module

* User Registration, Login & Logout
* Session-Based Authentication
* User Dashboard and My Recipes
* Create, Edit, View, and Delete Personal Recipes
* Upload Recipe Images
* Add Multiple Ingredients with Quantities and Units
* Add Sequential Preparation Steps
* Like and Unlike Recipes
* Public User Profiles
* Update Profile Information and Avatar
* Ownership-Based Authorization

---

## Recipe Discovery

* Browse All Available Recipes
* Search Recipes by Name
* Filter Recipes by Category
* Filter Recipes by Cuisine
* Filter by Food Type (Vegetarian, Non-Vegetarian, Vegan)
* Sort Recipes by Popularity or Recency
* View Detailed Recipe Information
* Display Ingredients and Preparation Instructions

---

## Admin Module

* Admin Dashboard
* Manage Registered Users
* Ban and Unban User Accounts
* View and Moderate Recipes
* Delete Inappropriate Recipes
* Manage Categories (Add, Edit, Delete)
* Manage Cuisines (Add, Edit, Delete)
* Manage Ingredients (Add, Edit, Delete)
* Protected Administrative Routes
* Role-Based Access Control

---

# Technology Stack

## Backend

* PHP 8.2+
* Laravel 12
* Eloquent ORM
* Laravel Middleware
* Laravel Validation

## Database

* MySQL
* SQLite (Supported through database configuration)

## Frontend

* HTML5
* CSS3
* Blade Templates
* Tailwind CSS 4
* JavaScript

## Development Tools

* Composer
* Node.js & npm
* Vite
* Laravel Pint
* PHPUnit / Pest
* Git & GitHub

---

# PHP & Laravel Concepts Demonstrated

* Object-Oriented Programming (OOP)
* Model-View-Controller (MVC) Architecture
* CRUD Operations
* Eloquent ORM and Database Relationships
* One-to-Many and Many-to-Many Relationships
* Database Transactions using `DB::transaction`
* Form Validation
* Session-Based Authentication
* Middleware and Role-Based Authorization
* CSRF Protection
* Password Hashing
* File Upload Validation and Storage
* Query Builder and Search Filtering
* Blade Layouts and Template Inheritance
* Dynamic Form Fields
* Exception Handling

---

# Project Structure

```text
SavorNest/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Admin/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── css/
│   └── index.php
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── categories/
│       ├── dashboard/
│       ├── layouts/
│       ├── profile/
│       └── recipes/
│
├── routes/
│   └── web.php
│
├── storage/
├── tests/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
├── README.md
└── vite.config.js
```

---

# Database Design

SavorNest uses a relational database structure to organize users, recipes, ingredients, and related information.

## Database Tables

* **Users** – Stores user accounts, roles, and account status.
* **Recipes** – Stores recipe details, descriptions, food types, and associated user information.
* **Categories** – Maintains recipe categories such as breakfast and desserts.
* **Cuisines** – Stores cuisine classifications such as Italian and Mexican.
* **Ingredients** – Maintains a collection of ingredients.
* **Recipe Ingredients** – Connects recipes with ingredients and stores quantities and units.
* **Preparation Steps** – Stores numbered preparation instructions for each recipe.
* **Likes** – Records the recipes liked by individual users.

## Relationships

* One User → Multiple Recipes
* One Recipe → Multiple Preparation Steps
* One Recipe → Multiple Likes
* One User → Multiple Likes
* One Category → Multiple Recipes
* One Cuisine → Multiple Recipes
* One Recipe ↔ Multiple Ingredients
* One Ingredient ↔ Multiple Recipes

## Data Integrity

* Database transactions maintain consistency when saving recipes and their related data.
* Foreign key relationships maintain connections between related records.
* Eloquent ORM manages database interactions and model relationships.
* Validation helps prevent invalid recipe and ingredient data.

---

# Authentication & Authorization

* Session-Based Authentication
* User Registration and Login
* Secure Password Hashing
* Protected Routes using `auth` Middleware
* Guest-Only Routes using `guest` Middleware
* Custom `admin` Middleware for administrative access
* Custom `banned` Middleware for restricting banned accounts
* Ownership Checks for Recipe Updates and Deletions
* Role-Based Access for Users and Administrators

---

# Security & Validation

* Server-Side Form Validation
* CSRF Protection for State-Changing Requests
* Password Hashing using Laravel's hashing facilities
* Image Upload Validation for Supported Formats
* File Size Validation
* Eloquent ORM and Parameter Binding to Help Prevent SQL Injection
* Middleware-Based Route Protection
* Authorization Checks for Restricted Operations

---

# Setup Instructions

## Prerequisites

* PHP 8.2+
* Composer
* Node.js and npm
* MySQL or SQLite
* Git

---

## Clone Repository

```bash
git clone https://github.com/snehabaviskar22/SavorNest.git
```

```bash
cd SavorNest
```

---

## Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

---

## Configure Environment Variables

Create a local `.env` file by copying the example configuration.

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure the database connection in `.env` according to your local setup.

For MySQL, configure the relevant values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=savornest
DB_USERNAME=root
DB_PASSWORD=your_database_password
```

Replace the database credentials with your own local settings.

---

## Database Setup

Create the `savornest` database in MySQL Workbench or your preferred database tool.

Run the migrations:

```bash
php artisan migrate
```

If the application uses database seeders to populate initial categories, cuisines, ingredients, or sample records, run:

```bash
php artisan db:seed
```

---

## Configure Storage

Create the symbolic link for publicly accessible uploaded images:

```bash
php artisan storage:link
```

---

## Run the Project

Start the Vite development server:

```bash
npm run dev
```

Open a separate terminal in the project directory and start Laravel:

```bash
php artisan serve
```

Open the application in your browser:

```text
http://127.0.0.1:8000
```

---

# Application Workflow

1. **Registration:** Users create an account and log in.
2. **Recipe Discovery:** Users browse, search, and filter available recipes.
3. **Recipe Creation:** Authenticated users enter recipe details, upload an image, add ingredients, and provide preparation steps.
4. **Recipe Publication:** Validated recipe information and its related data are saved to the database.
5. **Community Interaction:** Other users discover recipes and like their favorites.
6. **Profile Management:** Users update their profiles and manage their published recipes.
7. **Administration:** Administrators manage users, moderate recipes, and maintain categories, cuisines, and ingredients.

---

# Future Enhancements

* Recipe Rating and Review System
* Comments and Discussions on Recipes
* Follow Other Chefs
* Personalized Recipe Recommendations
* Meal Planning and Grocery List Generation
* Email Notifications
* Recipe Sharing and Social Features

---

# Author

**Sneha Baviskar**

MCA Student  
Savitribai Phule Pune University

---

# License

This project is developed for academic and educational purposes.
