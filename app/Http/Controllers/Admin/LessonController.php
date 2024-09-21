<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\Objective;
use App\Models\Slide;
use App\Models\Term;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function store(Request $request, Chapter $chapter)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'lesson_number' => 'required|string',
        ]);

        $lesson = $chapter->lessons()->create([
            'title' => $request->title,
            'lesson_number' => $request->lesson_number,
        ]);

        return redirect()->back();
    }
    public function update(Request $request, Lesson $lesson) {

            $validated =  $request->validate([
                'title' => 'required|string|max:255',
                'lesson_number' => 'required|string',
            ]);

        $lesson->update($validated);

            return redirect()->back()->with('success', 'Term added successfully.');

    }

    public function destroy(Lesson $lesson) {
        $lesson->delete();

        return redirect()->back()->with('success', 'Term added successfully.');
    }

    public function show(Lesson $lesson) {

        $lesson->load('slides', 'objectives', 'terms','chapter.course');

        return inertia('Admin/Lessons/ShowLesson',[
            'lesson' => $lesson
        ]);
    }

    public function create_slide(Lesson $lesson) {

        return inertia('Admin/Lessons/AddSlide',[
            'lesson' => $lesson
        ]);
    }

    public function store_slide(Request $request, Lesson $lesson)
    {

        $request->validate([
            'content' => 'required|string',
        ]);

        $slide = new Slide([
            'content' => $request->input('content'),
            'lesson_id' => $lesson->id,
        ]);
        $slide->save();

        return to_route('admin.lessons.show',$lesson);
    }

    public function edit_slide(Lesson $lesson, Slide $slide) {

        return inertia('Admin/Lessons/EditSlide',[
            'lesson' => $lesson,
            'slide' => $slide
        ]);

    }


    public function update_slide(Request $request, Lesson $lesson, Slide $slide) {
        $validated =    $request->validate([
            'content' => 'required|string',
        ]);


        $slide->update($validated);

        return to_route('admin.lessons.show',$lesson);
    }


    public function store_objective(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string',
        ]);

        $objective = new Objective([
            'title' => $request->input('title'),
            'lesson_id' => $lesson->id,
        ]);
        $objective->save();

        return redirect()->back()->with('success', 'Objective added successfully.');
    }

    public function store_term(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $term = new Term([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'lesson_id' => $lesson->id,
        ]);
        $term->save();

        return redirect()->back()->with('success', 'Term added successfully.');
    }

    // Update an Objective
    public function edit_objective(Request $request, Objective $objective)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $objective->update($validated);

        return redirect()->back()->with('success', 'Term added successfully.');
    }

    // Update a Term
    public function edit_term(Request $request, Term $term)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $term->update($validated);

        return redirect()->back()->with('success', 'Term added successfully.');
    }

    // Delete an Objective
    public function destroy_objective(Objective $objective)
    {
        $objective->delete();

        return redirect()->back()->with('success', 'Term added successfully.');
    }

    // Delete a Term
    public function destroy_term(Term $term)
    {
        $term->delete();

        return redirect()->back()->with('success', 'Term added successfully.');
    }

    public function destroy_slide(Slide $slide)
    {
        $slide->delete();

        return redirect()->back()->with('success', 'Term added successfully.');
    }




}
