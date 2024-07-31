<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PathController;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Path;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return Inertia::render('Home');
})->name('home');




Route::middleware(['auth'])->group(function () {
//    Route::get('/home', function () {
//        return inertia('Home');
//    });

    Route::get('/courses', [CourseController::class, 'index'])->name('course.index');



    Route::get('/paths/{id}',[PathController::class,'show'])->name('path.show');
    Route::get('/course',[PathController::class,'index'])->name('path.index');

    Route::get('/courses/{id}',[CourseController::class,'show'])->name('course.show');

    Route::get('/lessons/{id}',[LessonController::class,'show'])->name('lesson.show');

    Route::post('/api/slides/complete', [LessonController::class, 'completeSlide']);
    Route::post('/api/lessons/complete', [LessonController::class, 'completeLesson']);
    Route::post('/lessons/{lesson}/slides/{slide}/complete', [LessonController::class, 'completeSlide'])
        ->name('slides.complete');

    Route::get('/apply',[CheckoutController::class,'index'])->name('checkout');
    Route::post('/payment',[CheckoutController::class,'store'])->name('checkout.store');
    Route::get('/payment-status',[CheckoutController::class,'handlePaymentCallback'])->name('status');


    Route::post('/bookmark', [BookmarkController::class, 'store'])->name('bookmark.store');
    Route::delete('/bookmark', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');

    Route::get('/contact-us',[ContactController::class,'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/feedback', [ContactController::class, 'feedback'])->name('feedback.store');


    Route::get('/courses/lesson', function () {
        return inertia('Courses/Lesson');
    });

});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
