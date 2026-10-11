<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRecipeController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCuisineController;
use App\Http\Controllers\Admin\AdminIngredientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->where('recipe', '[0-9]+')->name('recipes.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->where('category', '[0-9]+')->name('categories.show');
Route::get('/users/{user}', [ProfileController::class, 'show'])->where('user', '[0-9]+')->name('profile.show');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated User
Route::middleware(['auth', 'banned'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', function () {
        return redirect()->route('profile.show', auth()->id());
    })->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes'])->name('my-recipes');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    
    Route::post('/recipes/{recipe}/like', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/recipes/{recipe}/like', [LikeController::class, 'destroy'])->name('likes.destroy');
});

// Admin
Route::middleware(['auth', 'banned', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');
    
    Route::get('/recipes', [AdminRecipeController::class, 'index'])->name('recipes.index');
    Route::delete('/recipes/{recipe}', [AdminRecipeController::class, 'destroy'])->name('recipes.destroy');
    
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('cuisines', AdminCuisineController::class)->except(['show']);
    Route::resource('ingredients', AdminIngredientController::class)->except(['show']);
});
