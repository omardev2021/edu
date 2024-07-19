<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Path;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PathController extends Controller
{
    public function index()
    {
        $id = 1;
        $user = auth()->user();

        $active_path = Path::with(['courses.chapters.lessons'])->findOrFail($id);
        $active_path->courses->each(function ($course) use ($user) {
            $course->is_accessible = $user && $user->can('view', $course);
        });

        // Calculate progress percentage for the active path
        $totalLessonsInActivePath = $active_path->courses->flatMap(function ($course) {
            return $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });
        })->count();

        $completedLessonsInActivePath = $user ? $active_path->courses->flatMap(function ($course) use ($user) {
            return $course->chapters->flatMap(function ($chapter) use ($user) {
                return $chapter->lessons->filter(function ($lesson) use ($user) {
                    return $user->hasCompletedLesson($lesson);
                });
            });
        })->count() : 0;

        $progressPercentageForActivePath = $totalLessonsInActivePath > 0 ? ($completedLessonsInActivePath / $totalLessonsInActivePath) * 100 : 0;
        $active_path->completed = $progressPercentageForActivePath === 100;

        // Fetch all paths and filter out the active path
        $paths = Path::with('courses')->get()->filter(function ($path) use ($id) {
            return $path->id != $id;
        })->map(function ($path) use ($user) {
            $totalLessons = $path->courses->flatMap(function ($course) {
                return $course->chapters->flatMap(function ($chapter) {
                    return $chapter->lessons;
                });
            })->count();

            $completedLessons = $user ? $path->courses->flatMap(function ($course) use ($user) {
                return $course->chapters->flatMap(function ($chapter) use ($user) {
                    return $chapter->lessons->filter(function ($lesson) use ($user) {
                        return $user->hasCompletedLesson($lesson);
                    });
                });
            })->count() : 0;

            $progressPercentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

            return [
                'id' => $path->id,
                'title' => $path->title,
                'description' => $path->description,
                'is_free' => $path->type === 'public',
                'is_accessible' => $user && $user->can('view', $path),
                'completed' => $progressPercentage === 100,
                'courses' => $path->courses->map(function ($course) use ($user) {
                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'image_path' => $course->image_path,
                        'is_accessible' => $user && $user->can('view', $course),
                    ];
                }),
            ];
        })->values();

        // Calculate the total number of courses
        $totalCourses = $active_path->courses->count();

        // Calculate the total number of lessons
        $totalLessons = $active_path->courses->flatMap(function ($course) {
            return $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });
        })->count();

        $allLessons = Lesson::all()->count();

        // Calculate completed lessons for the user
        $completedLessons = $user ? $user->completedLessons()->count() : 0;

        // Calculate progress percentage
        $progressPercentage = $allLessons > 0 ? ($completedLessons / $allLessons) * 100 : 0;

        $bookmarks = $user->bookmarks()->get()->map(function ($course) use ($user) {
            $course->is_accessible = $user && $user->can('view', $course);

            // Calculate completed lessons and total lessons for each course
            $lessons = $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });

            $course->completed_lessons = $lessons->filter(function ($lesson) use ($user) {
                return $user->hasCompletedLesson($lesson);
            })->count();

            $course->total_lessons = $lessons->count();

            // Check if the course is bookmarked
            $course->bookmarked = $user ? $user->bookmarks()->where('course_id', $course->id)->exists() : false;

            return $course;
        });

        $completedCourses = $user->completedCourses()->get()->map(function ($course) use ($user) {
            $course->is_accessible = $user && $user->can('view', $course);

            // Calculate completed lessons and total lessons for each course
            $lessons = $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });

            $course->completed_lessons = $lessons->filter(function ($lesson) use ($user) {
                return $user->hasCompletedLesson($lesson);
            })->count();

            $course->total_lessons = $lessons->count();

            // Check if the course is bookmarked
            $course->bookmarked = $user ? $user->bookmarks()->where('course_id', $course->id)->exists() : false;

            return $course;
        });

        return Inertia::render('Courses/Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'paths' => $paths,
            'activePath' => $active_path,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'totalCourses' => $totalCourses,
            'progressPercentage' => $progressPercentage,
            'progressPercentageForActivePath' => $progressPercentageForActivePath,
            'bookmarks' => $bookmarks,
            'completedCourses' => $completedCourses
        ]);
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {



        $user = auth()->user();

        $active_path = Path::with(['courses.chapters.lessons'])->findOrFail($id);
        $active_path->courses->each(function ($course) use ($user) {
            $course->is_accessible = $user && $user->can('view', $course);
        });

        // Calculate progress percentage for the active path
        $totalLessonsInActivePath = $active_path->courses->flatMap(function ($course) {
            return $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });
        })->count();

        $completedLessonsInActivePath = $user ? $active_path->courses->flatMap(function ($course) use ($user) {
            return $course->chapters->flatMap(function ($chapter) use ($user) {
                return $chapter->lessons->filter(function ($lesson) use ($user) {
                    return $user->hasCompletedLesson($lesson);
                });
            });
        })->count() : 0;

        $progressPercentageForActivePath = $totalLessonsInActivePath > 0 ? ($completedLessonsInActivePath / $totalLessonsInActivePath) * 100 : 0;
        $active_path->completed = $progressPercentageForActivePath === 100;

        // Fetch all paths and filter out the active path
        $paths = Path::with('courses')->get()->filter(function ($path) use ($id) {
            return $path->id != $id;
        })->map(function ($path) use ($user) {
            $totalLessons = $path->courses->flatMap(function ($course) {
                return $course->chapters->flatMap(function ($chapter) {
                    return $chapter->lessons;
                });
            })->count();

            $completedLessons = $user ? $path->courses->flatMap(function ($course) use ($user) {
                return $course->chapters->flatMap(function ($chapter) use ($user) {
                    return $chapter->lessons->filter(function ($lesson) use ($user) {
                        return $user->hasCompletedLesson($lesson);
                    });
                });
            })->count() : 0;

            $progressPercentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

            return [
                'id' => $path->id,
                'title' => $path->title,
                'description' => $path->description,
                'is_free' => $path->type === 'public',
                'is_accessible' => $user && $user->can('view', $path),
                'completed' => $progressPercentage === 100,
                'courses' => $path->courses->map(function ($course) use ($user) {
                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'image_path' => $course->image_path,
                        'is_accessible' => $user && $user->can('view', $course),
                    ];
                }),
            ];
        })->values();

        // Calculate the total number of courses
        $totalCourses = $active_path->courses->count();

        // Calculate the total number of lessons
        $totalLessons = $active_path->courses->flatMap(function ($course) {
            return $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });
        })->count();

        $allLessons = Lesson::all()->count();

        // Calculate completed lessons for the user
        $completedLessons = $user ? $user->completedLessons()->count() : 0;

        // Calculate progress percentage
        $progressPercentage = $allLessons > 0 ? ($completedLessons / $allLessons) * 100 : 0;

        $bookmarks = $user->bookmarks()->get()->map(function ($course) use ($user) {
            $course->is_accessible = $user && $user->can('view', $course);

            // Calculate completed lessons and total lessons for each course
            $lessons = $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });

            $course->completed_lessons = $lessons->filter(function ($lesson) use ($user) {
                return $user->hasCompletedLesson($lesson);
            })->count();

            $course->total_lessons = $lessons->count();

            // Check if the course is bookmarked
            $course->bookmarked = $user ? $user->bookmarks()->where('course_id', $course->id)->exists() : false;

            return $course;
        });

        $completedCourses = $user->completedCourses()->get()->map(function ($course) use ($user) {
            $course->is_accessible = $user && $user->can('view', $course);

            // Calculate completed lessons and total lessons for each course
            $lessons = $course->chapters->flatMap(function ($chapter) {
                return $chapter->lessons;
            });

            $course->completed_lessons = $lessons->filter(function ($lesson) use ($user) {
                return $user->hasCompletedLesson($lesson);
            })->count();

            $course->total_lessons = $lessons->count();

            // Check if the course is bookmarked
            $course->bookmarked = $user ? $user->bookmarks()->where('course_id', $course->id)->exists() : false;

            return $course;
        });

        return Inertia::render('Courses/Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'paths' => $paths,
            'activePath' => $active_path,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'totalCourses' => $totalCourses,
            'progressPercentage' => $progressPercentage,
            'progressPercentageForActivePath' => $progressPercentageForActivePath,
            'bookmarks' => $bookmarks,
            'completedCourses' => $completedCourses
        ]);

    }


    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
