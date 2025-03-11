<?php

use core\Router;
use src\Controllers\ArticleController;
use src\Controllers\LoginController;
use src\Controllers\LogoutController;
use src\Controllers\RegistrationController;
use src\Controllers\SettingsController;

// Root / Home
Router::get('/', [ArticleController::class, 'index']);

// Authentication: Login
Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'login']);

// Registration
Router::get('/register', [RegistrationController::class, 'index']);
Router::post('/register', [RegistrationController::class, 'register']);

// Logout
Router::get('/logout', [LogoutController::class, 'logout']);

// Settings (User Profile)
Router::get('/settings', [SettingsController::class, 'index']);
Router::post('/settings', [SettingsController::class, 'update']);

// Articles (Create, Read, Update, Delete)
Router::get('/articles', [ArticleController::class, 'list']);
Router::get('/articles/create', [ArticleController::class, 'create']);
Router::post('/articles', [ArticleController::class, 'store']);
Router::get('/articles/edit/{id}', [ArticleController::class, 'edit']);
Router::post('/articles/update', [ArticleController::class, 'update']);
Router::get('/articles/edit', [ArticleController::class, 'edit']);
Router::post('/articles/delete', [ArticleController::class, 'delete']);