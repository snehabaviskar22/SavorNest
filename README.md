# SavorNest – Recipe Sharing & Management Platform

A full-stack recipe-sharing web application developed using **Laravel 12, PHP, MySQL, and Blade Templates**. SavorNest allows users to discover, create, manage, and share recipes with ingredients, quantities, images, and step-by-step preparation instructions. It also provides an admin dashboard for managing users, recipes, categories, cuisines, and ingredients.

---

# Objectives

- Provide a platform for discovering and sharing recipes.
- Enable users to create and manage their own recipes.
- Organize recipes by categories, cuisines, and food types.
- Implement secure authentication and role-based access.
- Provide administrative tools for managing platform content.

---

# Features

## User Module

- User Registration, Login & Logout
- User Dashboard and My Recipes
- Create, Edit, View, and Delete Personal Recipes
- Upload Recipe Images
- Add Ingredients with Quantities and Units
- Add Step-by-Step Preparation Instructions
- Like and Unlike Recipes
- Public User Profiles
- Update Profile Information and Avatar
- Ownership-Based Authorization

## Recipe Discovery

- Browse Available Recipes
- Search Recipes by Name
- Filter by Category, Cuisine, and Food Type
- Sort by Popularity or Recency
- View Recipe Details, Ingredients, and Instructions

## Admin Module

- Admin Dashboard
- Manage Registered Users
- Ban and Unban User Accounts
- View and Moderate Recipes
- Manage Categories, Cuisines, and Ingredients
- Protected Administrative Routes

---

# Technology Stack

**Backend:** PHP 8.2+, Laravel 12, Eloquent ORM

**Frontend:** HTML5, CSS3, Blade Templates, Tailwind CSS 4, JavaScript

**Database:** MySQL / SQLite

**Tools:** Composer, Node.js, npm, Vite, Git, GitHub

---

# Key Concepts Demonstrated

- MVC Architecture and Object-Oriented Programming
- CRUD Operations and Eloquent ORM
- Database Relationships
- Session-Based Authentication
- Middleware and Role-Based Authorization
- Form Validation and CSRF Protection
- Password Hashing and File Upload Validation
- Database Transactions and Dynamic Forms

---

# Project Structure

```text
SavorNest/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
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
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── README.md
└── vite.config.js
```

---

# Database Design

The application uses relational tables to manage:

- **Users** – User accounts, roles, and account status.
- **Recipes** – Recipe details and ownership.
- **Categories & Cuisines** – Recipe classifications.
- **Ingredients** – Ingredient information.
- **Recipe Ingredients** – Ingredient quantities and units for each recipe.
- **Preparation Steps** – Ordered cooking instructions.
- **Likes** – User-to-recipe likes.

**Relationships:** Users have multiple recipes and likes; recipes have multiple preparation steps and ingredients; categories and cuisines can each contain multiple recipes.

---

# Authentication & Security

- Session-Based Authentication
- Password Hashing
- Protected Routes using Laravel Middleware
- Admin and Banned-User Middleware
- Ownership Checks for Recipe Updates and Deletions
- Server-Side Validation and CSRF Protection
- Image Format and File Size Validation
- Eloquent ORM and Parameter Binding

---

# Setup Instructions

## Prerequisites

- PHP 8.2+
- Composer
- Node.js and npm
- MySQL or SQLite

## Clone Repository

```bash
git clone https://github.com/snehabaviskar22/SavorNest.git
cd SavorNest
```

## Install Dependencies

```bash
composer install
npm install
```

## Configure Environment

Create the `.env` file:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database settings in `.env`. For MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=savornest
DB_USERNAME=root
DB_PASSWORD=your_database_password
```

Create the `savornest` database, then run:

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Run the application using two terminals.

**Terminal 1 – Frontend assets**

```bash
npm run dev
```

**Terminal 2 – Laravel server**

```bash
php artisan serve
```

Open `http://127.0.0.1:8000` in your browser.

---

# Screenshots

## Home Page

![SavorNest Home Page](https://github.com/user-attachments/assets/d09e461b-ccfb-45e8-80e2-43d30f85aa38)

---

## Recipe Discovery

![SavorNest Recipe Discovery](https://github.com/user-attachments/assets/6b2162dd-5c23-4a74-afc7-05d09b37c012)

---

## Recipe Details

![SavorNest Recipe Details](https://github.com/user-attachments/assets/0368dae8-f3f7-4ec0-9993-62034542ce30)

---

## Create Recipe

![SavorNest Create Recipe](https://github.com/user-attachments/assets/821b7b2a-da06-410c-91ec-929c8ecb26ac)

---

## User Dashboard

![SavorNest User Dashboard](https://github.com/user-attachments/assets/4f9a5055-1c59-4d55-884b-54f8257a7be1)

---

## Admin Dashboard

![SavorNest Admin Dashboard](https://github.com/user-attachments/assets/9b45d04b-0cde-45ae-be17-1232438e6025)

---

## User Management

![SavorNest User Management](https://github.com/user-attachments/assets/93cda668-579e-4ef7-928c-76572bccfa99)

---


# Future Enhancements

- Recipe Ratings and Reviews
- Comments and Discussions
- Personalized Recipe Recommendations
- Meal Planning and Grocery Lists
- Email Notifications

---

# Author

**Sneha Baviskar**

MCA Student  
Savitribai Phule Pune University

---

# License

This project is developed for academic and educational purposes.
