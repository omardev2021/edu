<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Highlight;
use Symfony\Component\HttpFoundation\Request;


class HighlightController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'content' => 'required|string|max:255',

        ]);

        $chapter = $course->highlights()->create([
            'content' => $request->content,

        ]);

        return to_route('admin.courses.show', $course->id)
            ->banner('تمت اضافة الجزء بنجاح');
    }

    public function update(Request $request, Highlight $highlight) {

        $validated =  $request->validate([
            'content' => 'required|string|max:255',

        ]);

        $highlight->update($validated);

        return redirect()->back()->banner('تم تعديل الجزء بنجاح');

    }

    public function destroy(Highlight $highlight) {
        $highlight->delete();

        return redirect()->back()->banner('تمت حذف  بنجاح');
    }
}
