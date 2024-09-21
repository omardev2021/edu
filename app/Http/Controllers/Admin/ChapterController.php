<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use Symfony\Component\HttpFoundation\Request;

class ChapterController extends Controller
{

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'chapter_number' => 'required|string|max:50',
        ]);

        $chapter = $course->chapters()->create([
            'title' => $request->title,
            'chapter_number' => $request->chapter_number,
        ]);

       return to_route('admin.courses.show', $course->id)
           ->banner('تمت اضافة الجزء بنجاح');
    }

    public function update(Request $request, Chapter $chapter) {

        $validated =    $request->validate([
            'title' => 'required|string|max:255',
            'chapter_number' => 'required|string|max:50',
        ]);

        $chapter->update($validated);

        return redirect()->back()->banner('تم تعديل الجزء بنجاح');

    }

    public function destroy(Chapter $chapter) {
        $chapter->delete();

        return redirect()->back()->banner('تمت حذف الجزء بنجاح');
    }
}
