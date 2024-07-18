<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

// app/Http/Controllers/LessonController.php

    public function show(Request $request, $id)
    {
        $lesson = Lesson::with(['objectives', 'slides.contents','terms'])->findOrFail($id);
        $user = auth()->user();

        // Get completed slides for the user
        $completedSlides = $user->completedSlides()
            ->whereIn('slide_id', $lesson->slides->pluck('id'))
            ->pluck('slide_id')
            ->toArray();

        // Update the completion status for each slide
        foreach ($lesson->slides as $slide) {
            $slide->completed = in_array($slide->id, $completedSlides);
        }

        // Get the slide query parameter
        $slideIndex = (int) $request->query('slide', 0); // Default to 0 if not present
        $couese_id = $lesson->chapter->course_id;
        $lessonsCount = $lesson->chapter->lessons()->count();

        return Inertia::render('Courses/Lesson', [
            'lesson' => $lesson,
            'slideIndex' => $slideIndex,
            'courseId' => $couese_id,
            'lessonsCount' => $lessonsCount
        ]);
    }



    public function completeSlide(Request $request, $lessonId, $slideId)
    {
        $user = auth()->user();
        $lesson = Lesson::findOrFail($lessonId);
        $slide = $lesson->slides()->findOrFail($slideId);

        $user->completedSlides()->syncWithoutDetaching([$slide->id]);

        // Check if all slides in the lesson are completed
        $completedSlidesCount = $user->completedSlides()->where('lesson_id', $lesson->id)->count();
        if ($completedSlidesCount === $lesson->slides()->count()) {
            $user->completedLessons()->syncWithoutDetaching([$lesson->id]);

            // Check if all lessons in the course are completed
            $course = $lesson->chapter->course;
            $completedLessonsCount = $user->completedLessons()->whereHas('chapter.course', function ($query) use ($course) {
                $query->where('id', $course->id);
            })->count();

            $totalLessonsCount = $course->chapters->flatMap->lessons->count();
            if ($completedLessonsCount === $totalLessonsCount) {
                $user->completedCourses()->syncWithoutDetaching([$course->id]);
            }
        }

        return response()->json(['completed' => true]);
    }



    public function completeLesson(Request $request)
    {
        $user = Auth::user();
        $lessonId = $request->input('lesson_id');

        $user->completedLessons()->attach($lessonId);

        return response()->json(['status' => 'success']);
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
