# SavorNest

SavorNest is a comprehensive web application for discovering, creating, and sharing culinary recipes.

## Overview

SavorNest provides a platform for food enthusiasts to share their favorite recipes and discover new ones. It solves the problem of organizing recipes with detailed ingredients, quantities, and step-by-step instructions. The application is intended for both casual home cooks looking for inspiration and experienced chefs wanting to catalog and share their creations. At a high level, users can browse categorized recipes, filter by cuisine or food type, and registered members can contribute their own recipes to the platform's growing database.

## Key Features

* **Recipe Discovery & Search**: Users can search for recipes by name and filter results by category, cuisine, and food type (Vegetarian, Non-Vegetarian, Vegan). Results can be sorted by popularity or recency.
* **Recipe Management**: Authenticated users can create, edit, and delete their own recipes. The creation process supports adding an image, dynamic ingredients with specific quantities and units, and sequential preparation steps.
* **User Profiles**: Every user has a profile page displaying their bio, profile image, and a gallery of recipes they have published.
* **Liking System**: Users can like their favorite recipes, which contributes to the recipe's overall popularity score.
* **Admin Dashboard**: A dedicated administrative interface for managing platform content. Admins can oversee all recipes, manage users (including banning functionality), and maintain the taxonomies for Categories, Cuisines, and Ingredients.

## User Roles

* **Guest (Unauthenticated)**
  * Can view the home page and browse the recipe catalog.
  * Can use search and filter functionalities.
  * Can view detailed recipe pages and user profiles.
  * Must register or log in to interact further.

* **User (Authenticated)**
  * Has all Guest privileges.
  * Can access a personal dashboard ("My Recipes").
  * Can create, edit, and delete their own recipes.
  * Can like and unlike recipes.
  * Can update their profile information and avatar.

* **Admin**
  * Has all User privileges.
  * Has access to the protected `/admin` dashboard.
  * Can view and manage all registered users (including banning and unbanning accounts).
  * Can delete any recipe on the platform for moderation purposes.
  * Can create, update, and delete Categories, Cuisines, and Ingredients.

## Complete Project Flow

1. **Discovery**: A user opens the application and lands on the home page, viewing featured popular recipes and categories.
2. **Exploration**: The user navigates to the recipe catalog, using filters to find specific types of meals (e.g., Vegan Italian dishes).
3. **Authentication**: To save a favorite recipe or add their own, the user creates an account or logs in.
4. **Contribution**: The user goes to their dashboard and clicks "Create Recipe".
5. **Data Entry**: The user fills out a comprehensive form including the recipe name, description, category, cuisine, food type, uploads an image, adds a dynamic list of ingredients with measurements, and writes out the preparation steps.
6. **Publication**: The data is processed within a database transaction to ensure integrity, and the recipe becomes publicly available.
7. **Interaction**: Other users discover the new recipe, view the steps, and can "like" it.
8. **Moderation**: Administrators periodically log into the admin panel to manage taxonomies, review content, and handle user moderation if necessary.

## Application Modules

* **Authentication**: Handles user registration, login, and logout flows.
* **Home**: The landing page showcasing top content and categories.
* **Recipe Module**: Core functionality including the recipe listing page, detailed recipe view, and the creation/editing interfaces.
* **Profile Module**: Public-facing user profile pages and private profile editing settings.
* **Dashboard (My Recipes)**: A private management area for users to oversee their submitted content.
* **Admin Panel**: A restricted area containing modules for User Management, Recipe Moderation, Category Management, Cuisine Management, and Ingredient Management.

## Functional Details

* **Search/Filter Functionality**: The recipe listing page uses Eloquent queries to filter results based on `category_id`, `cuisine_id`, and `food_type`. A search bar uses `LIKE` queries against the recipe name.
* **Dynamic Forms**: The recipe creation/edit forms support adding multiple ingredients and preparation steps dynamically.
* **Data Processing (Transactions)**: When saving a recipe, `DB::transaction` is utilized to ensure that the core recipe, its pivot table relations (ingredients), and its related models (steps) are all saved successfully, preventing orphaned data if an error occurs mid-process.
* **Relationships**:
  * One-to-Many: User -> Recipes, Recipe -> Preparation Steps, Recipe -> Likes, User -> Likes.
  * Many-to-Many: Recipe <-> Ingredients (via `recipe_ingredient` pivot table tracking `quantity` and `unit`).
  * Belongs-To: Recipe -> Category, Recipe -> Cuisine.
* **Image Uploads**: Recipe and profile images are validated for mime type and size, then stored securely in the `public` storage disk.

## Technology Stack

* **Backend**: PHP 8.2+, Laravel 12.0
* **Frontend**: Blade Templates, Tailwind CSS 4.0
* **Development Tools**: Vite (Asset Bundling), Laravel Pint (Code Styling), Pest/PHPUnit (Testing)
* **Database**: SQLite (Default configuration, compatible with MySQL/PostgreSQL)

## System Architecture

The application follows a standard monolithic Model-View-Controller (MVC) architecture using the Laravel framework:
1. **Frontend (Views)**: Blade templates styled with Tailwind CSS render the user interface.
2. **Routing**: `routes/web.php` directs incoming HTTP requests through appropriate middleware.
3. **Controllers**: Handle business logic, process incoming request data, interact with models, and return views or redirects (e.g., `RecipeController`, `AdminUserController`).
4. **Models (Eloquent ORM)**: Represent database tables and define relationships (e.g., `Recipe`, `User`, `Ingredient`).
5. **Database**: Relational database storing the application state.

## Database Structure

| Table | Main Fields | Relationships / Purpose |
| :--- | :--- | :--- |
| `users` | `id`, `name`, `email`, `password`, `role`, `status`, `banned_at` | Stores user accounts, roles, and moderation status. |
| `recipes` | `id`, `user_id`, `category_id`, `cuisine_id`, `name`, `food_type` | Core recipe entity. Belongs to User, Category, Cuisine. |
| `categories` | `id`, `name`, `description` | Taxonomy for grouping recipes (e.g., Breakfast, Dessert). |
| `cuisines` | `id`, `name`, `description` | Taxonomy for origin of recipes (e.g., Italian, Mexican). |
| `ingredients` | `id`, `name` | Dictionary of unique ingredients. |
| `recipe_ingredient` | `recipe_id`, `ingredient_id`, `quantity`, `unit` | Pivot table linking recipes to ingredients with measurements. |
| `preparation_steps`| `id`, `recipe_id`, `step_number`, `instruction` | Sequential instructions for a specific recipe. |
| `likes` | `id`, `user_id`, `recipe_id` | Tracks which users have liked which recipes. |

## API Documentation

This project does not currently expose a public API. All interactions are handled via standard server-side rendered web routes and form submissions.

## Project Structure

* `app/Http/Controllers/`: Contains the application logic. Subdirectory `Admin/` holds controllers specific to the admin panel.
* `app/Models/`: Contains Eloquent ORM classes defining data structure and relationships.
* `database/migrations/`: PHP classes that define and construct the database schema.
* `resources/views/`: Contains all Blade templates, organized into folders like `admin`, `auth`, `recipes`, `profile`, and `layouts`.
* `routes/web.php`: The central file where all application URLs are registered and assigned to controllers.
* `public/`: The web root directory containing the `index.php` entry point and compiled CSS/JS assets.

## Authentication & Authorization

* **Authentication**: Handled via Laravel's built-in session-based authentication system. Users register with an email and password.
* **Roles**: The system relies on a `role` column on the `users` table, which can be `user` or `admin`.
* **Status**: A `status` column tracks if a user is `active` or `banned`.
* **Middleware Protection**:
  * `auth`: Restricts routes (like dashboard, recipe creation) to logged-in users only.
  * `guest`: Restricts routes (like login/register forms) to unauthenticated users.
  * `admin`: A custom middleware ensuring only users with the `admin` role can access the `/admin` prefix.
  * `banned`: A custom middleware that prevents users with a `banned` status from accessing protected routes.
* **Ownership Authorization**: Controllers manually verify ownership before allowing updates or deletions (e.g., ensuring a user can only edit their own recipe).

## Validation & Security

* **Input Validation**: All incoming data from forms (registration, recipe creation, profile updates) is strictly validated in controllers using Laravel's validation rules (e.g., ensuring arrays are not empty, strings meet length requirements, numbers are positive).
* **CSRF Protection**: All POST, PUT, and DELETE requests are protected against Cross-Site Request Forgery using automatic token generation and verification.
* **Password Handling**: Passwords are securely hashed using bcrypt before being stored in the database.
* **File Upload Security**: Uploaded files are validated against allowed mime types (`jpg`, `jpeg`, `png`, `webp`) and file sizes before being accepted and stored in the application.
* **SQL Injection Prevention**: The use of Eloquent ORM and query builder methods automatically uses PDO parameter binding, preventing SQL injection vulnerabilities.

## Installation & Setup

To run SavorNest locally, you need PHP 8.2+, Composer, and Node.js installed.

1. **Clone the repository**
2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
3. **Install frontend dependencies:**
   ```bash
   npm install
   ```
4. **Environment Setup:**
   Copy the example environment file and create your own `.env` file.
   ```bash
   cp .env.example .env
   ```
5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```
6. **Database Setup:**
   By default, the `.env.example` is configured for SQLite. Create an empty SQLite database file, then run migrations.
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```
7. **Storage Link:**
   Create a symbolic link to make uploaded images publicly accessible.
   ```bash
   php artisan storage:link
   ```
8. **Run the Application:**
   Start the Vite development server for frontend assets and the Laravel server.
   ```bash
   npm run dev
   # In a separate terminal window:
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`.

## Configuration

Important configuration variables in the `.env` file:

* **Required:**
  * `DB_CONNECTION`: Set your database type (sqlite, mysql, pgsql).
  * `APP_URL`: Set to your local development URL (e.g., `http://localhost:8000`).
* **Optional:**
  * `MAIL_MAILER` / `MAIL_HOST`: Configure these if you wish to implement email sending for password resets (currently uses `log` driver).

## Usage

* **Standard User Workflow**: Register an account. Navigate to the "Recipes" tab to browse. Click on your profile dropdown to go to "My Recipes", then click "Create Recipe". Fill out the form, adding ingredients and steps one by one. Submit the form to publish your recipe.
* **Admin Workflow**: Register an account. You will need to manually change your role to `admin` in the database to gain initial access. Once granted, an "Admin Dashboard" link will appear in the navigation. Click it to manage the platform's taxonomies and moderate users.

## Future Scope

* Implementation of a rating and review system for recipes.
* Ability for users to comment on recipes.
* Social features such as following other chefs and a customized activity feed.
* Meal planning and grocery list generation based on selected recipes.

## Project Status

SavorNest is fully functional with core features implemented. The platform supports user authentication, complex recipe creation (with dynamic ingredients and steps), a complete categorization system, and a robust administrative panel for moderation and taxonomy management. All described features are currently operational.
