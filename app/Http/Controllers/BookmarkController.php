<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $bookmark = Bookmark::firstOrCreate([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
        ]);

        return response()->json(['status' => 'success', 'bookmark' => $bookmark], 200);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        Bookmark::where('user_id', Auth::id())
            ->where('course_id', $request->course_id)
            ->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
