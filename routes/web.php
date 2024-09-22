<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminQuestionController;

// Route::get('/', [QuizController::class, 'index'])->name('home');
// Route::get('/exam/{category}', [QuizController::class, 'startExam'])->name('start.exam');
// Route::post('/submit-exam', [QuizController::class, 'submitExam'])->name('submit.exam');
// Route::get('/result/{attempt}', [QuizController::class, 'showResult'])->name('show.result');
Route::prefix('quiz')->group(function () {
    Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/start/{category}', [QuizController::class, 'startExam'])->name('quiz.start');
    Route::post('/submit', [QuizController::class, 'submitExam'])->name('quiz.submit');
    // Add other quiz-related routes here
});
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    // Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/questions', [AdminController::class, 'questions'])->name('admin.questions');
    Route::get('/results', [AdminController::class, 'results'])->name('admin.results');
    Route::get('/add-question', [AdminController::class, 'addQuestion'])->name('admin.add_question');
    Route::post('/store-question', [AdminController::class, 'storeQuestion'])->name('admin.store_question');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/add-category', [AdminController::class, 'addCategory'])->name('admin.add_category');
    Route::post('/store-category', [AdminController::class, 'storeCategory'])->name('admin.store_category');
    Route::post('/delete-category', [AdminController::class, 'deleteCategory'])->name('admin.delete_category');
    Route::post('/delete-category', [AdminController::class, 'deleteCategory'])->name('admin.delete_category');
    Route::post('/publish-category', [AdminController::class, 'publishCategory'])->name('admin.publish_category');
});
