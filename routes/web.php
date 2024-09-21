<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Admin\SettingsController;
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



Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/upload-image', [ImageUploadController::class, 'store']);

    Route::get('/admin/courses', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('/admin/courses/show/{chapterId}', [\App\Http\Controllers\Admin\CourseController::class, 'show'])->name('admin.courses.show');

    Route::post('/admin/courses/update/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'update'])->name('admin.courses.update');
    Route::get('/admin/courses/edit/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('admin.courses.edit');




    Route::post('/admin/courses/{course}/chapters', [\App\Http\Controllers\Admin\ChapterController::class, 'store'])->name('admin.chapters.store');

    Route::post('/admin/chapters/{chapter}/lessons', [\App\Http\Controllers\Admin\LessonController::class, 'store'])->name('admin.lessons.store');


    Route::post('/admin/courses/{course}/highlights', [\App\Http\Controllers\Admin\HighlightController::class, 'store'])->name('admin.highlights.store');
    Route::put('/highlights/{highlight}', [\App\Http\Controllers\Admin\HighlightController::class, 'update'])->name('admin.highlights.update');
    Route::delete('/highlights/{highlight}', [\App\Http\Controllers\Admin\HighlightController::class, 'destroy'])->name('admin.highlights.destroy');





    Route::put('/chapters/{chapter}', [\App\Http\Controllers\Admin\ChapterController::class, 'update'])->name('admin.chapters.update');
    Route::delete('/chapters/{chapter}', [\App\Http\Controllers\Admin\ChapterController::class, 'destroy'])->name('admin.chapters.destroy');



    Route::get('/admin/courses/create', [\App\Http\Controllers\Admin\CourseController::class, 'create'])->name('admin.courses.create');
    Route::post('/admin/courses', [\App\Http\Controllers\Admin\CourseController::class, 'store'])->name('admin.courses.store');

    Route::get('/admin/topics', [\App\Http\Controllers\Admin\TopicController::class, 'index'])->name('admin.topics');
    Route::post('/admin/topics', [\App\Http\Controllers\Admin\TopicController::class, 'store'])->name('admin.topics.store');
    Route::put('/admin/topics/{topic}', [\App\Http\Controllers\Admin\TopicController::class, 'update'])->name('admin.topics.update');
    Route::delete('/admin/topics/{topic}', [\App\Http\Controllers\Admin\TopicController::class, 'destroy'])->name('admin.topics.destroy');



    Route::get('/admin/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.contacts');




    Route::get('/admin/lessons/{lesson}/slides/create', [\App\Http\Controllers\Admin\LessonController::class, 'create_slide'])->name('admin.slides.create');
    Route::get('/admin/lessons/{lesson}/slides/{slide}/edit', [\App\Http\Controllers\Admin\LessonController::class, 'edit_slide'])->name('admin.slides.edit');

    Route::put('/admin/lessons/{lesson}/slides/{slide}/edit', [\App\Http\Controllers\Admin\LessonController::class, 'update_slide'])->name('admin.slides.update');


    Route::delete('/admin/slides/{slide}', [\App\Http\Controllers\Admin\LessonController::class, 'destroy_slide'])->name('admin.slides.destroy');


    Route::get('/admin/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonController::class, 'show'])->name('admin.lessons.show');

    Route::post('/lessons/{lesson}/slides', [\App\Http\Controllers\Admin\LessonController::class, 'store_slide'])->name('admin.slides.store');
    Route::post('/lessons/{lesson}/objectives', [\App\Http\Controllers\Admin\LessonController::class, 'store_objective'])->name('admin.objectives.store');
    Route::post('/lessons/{lesson}/terms', [\App\Http\Controllers\Admin\LessonController::class, 'store_term'])->name('admin.terms.store');

    Route::put('/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonController::class, 'update'])->name('admin.lessons.update');
    Route::delete('/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonController::class, 'destroy'])->name('admin.lessons.destroy');



    Route::put('/objectives/{objective}', [\App\Http\Controllers\Admin\LessonController::class, 'edit_objective'])->name('admin.objectives.update');
    Route::put('/terms/{term}', [\App\Http\Controllers\Admin\LessonController::class, 'edit_term'])->name('admin.terms.update');


    Route::delete('/objectives/{objective}', [\App\Http\Controllers\Admin\LessonController::class, 'destroy_objective'])->name('objectives.destroy');
    Route::delete('/terms/{term}', [\App\Http\Controllers\Admin\LessonController::class, 'destroy_term'])->name('terms.destroy');


    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('settings.edit');
    Route::post('/admin/settings', [SettingsController::class, 'update'])->name('settings.update');


    Route::get('/admin/users', [DashboardController::class, 'users'])->name('admin.users.index');

    Route::delete('/admin/courses/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('admin.courses.destroy');




});



Route::middleware(['auth'])->group(function () {
//    Route::get('/home', function () {
//        return inertia('Home');
//    });

    Route::get('/courses', [CourseController::class, 'index'])->name('course.index');


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
