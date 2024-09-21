<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return inertia('Admin/Topics/Index', ['topics' => $topics]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Topic::create([
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Topic added successfully.');
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $topic->update([
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Topic updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()->back()->with('success', 'Topic deleted successfully.');
    }
}
