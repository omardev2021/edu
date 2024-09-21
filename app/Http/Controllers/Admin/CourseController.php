<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function create()
    {
        $topics = Topic::all()->toArray(); // Fetch all topics

        return Inertia::render('Admin/Courses/CreateCourse', [
            'topics' => $topics,
        ]);
    }


    public function index()
    {
        // Fetch courses with related chapters and lessons count
        $courses = Course::withCount(['chapters'])->get()->toArray();


        return inertia('Admin/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function show($courseId)
    {
        $course = Course::with(['chapters.lessons','highlights'])->findOrFail($courseId);
//    return $course;
       return inertia('Admin/Courses/ShowCourse', [
           'course' => $course,
       ]);
    }

    public function store(Request $request)
    {

        // Decode topics since they are coming as JSON
        $topics = json_decode($request->topics, true);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|in:public,paid',
            'is_featured' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('course_images', 'public');

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'type' => $request->type,
            'is_featured' => $request->is_featured ?? false,
        ]);

        // Attach topics to the course
        $course->topics()->sync($topics);

        return to_route('admin.courses.index');
    }

    public function edit(Course $course)
    {
        // Load the topics related to the course
        $course->load('topics');

        // Fetch all topics for selection
        $topics = Topic::all();

        return Inertia::render('Admin/Courses/EditCourse', [
            'course' => $course,
            'topics' => $topics,
        ]);
    }


    public function update(Request $request, Course $course)
    {
        // Decode topics if they are coming as JSON
        $topics = json_decode($request->topics, true);

        // Validate the input data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|in:public,paid',
            'is_featured' => 'boolean',

        ]);

        // Update course details
        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'is_featured' => $request->is_featured ?? false,
        ]);

        // If a new image is uploaded, store it
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('course_images', 'public');
            $course->update(['image_path' => $imagePath]);
        }

        // Sync topics
        $course->topics()->sync($topics);

        return to_route('admin.courses.index')
            ->banner('تم تعديل الكورس بنجاح');
    }


    public function destroy(Course $course) {

        $course->delete();

        return to_route('admin.courses.index')
            ->banner('تم حذف الكورس بنجاح');
    }

}
