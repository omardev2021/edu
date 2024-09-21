<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $topics = Topic::with(['courses.chapters.lessons','courses.topics'])->get()->map(function ($topic) use ($user) {
            $topic->courses->each(function ($course) use ($user) {
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
            });
            return $topic;
        });

        $courses = Course::with(['chapters.lessons','topics'])->get()->map(function ($course) use ($user) {
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

        return Inertia::render('Courses/Courses', [
            'topics' => $topics,
            'courses' => $courses
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
        $course = Course::with(['chapters.lessons.slides','highlights','chapters.lessons.terms','chapters.lessons.objectives'])->findOrFail($id);
        $this->authorize('view', $course);

        $user = auth()->user();

        // Fetch completed slides for the authenticated user
        $completedSlides = $user ? $user->completedSlides()->pluck('slide_id')->toArray() : [];

        // Append completion status to each slide and lesson
        foreach ($course->chapters as $chapter) {
            foreach ($chapter->lessons as $lesson) {
                $completedSlidesCount = 0;
                foreach ($lesson->slides as $slide) {
                    if (in_array($slide->id, $completedSlides)) {
                        $slide->completed = true;
                        $completedSlidesCount++;
                    } else {
                        $slide->completed = false;
                    }
                }
                $lesson->completed_slides_count = $completedSlidesCount;
                $lesson->total_slides_count = count($lesson->slides);
                // Set lesson completed status
                $lesson->completed = ($lesson->completed_slides_count === $lesson->total_slides_count);
            }
        }
        // Check if the course is bookmarked by the user
        $course->bookmarked = $user && $course->isBookmarkedBy($user);

        // Fetch related courses in the same path
        $relatedCourses = Course::where('id', '!=', $course->id)
            ->take(3)
            ->get()
            ->map(function ($course) use ($user) {
                $course->is_accessible = $user && $user->can('view', $course);
                return $course;
                });


        // Fetch the next course in the same path
        $nextCourse = Course::where('id', '>', $course->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextCourse) {
            $nextCourse->is_accessible = $user && $user->can('view', $nextCourse);
        }

        return Inertia::render('Courses/CoursePage', [
            'course' => $course,
            'relatedCourses' => $relatedCourses,
            'nextCourse' => $nextCourse
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
