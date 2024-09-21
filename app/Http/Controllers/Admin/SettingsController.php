<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {

        $setting = Setting::first()->toArray();

        return inertia('Admin/Settings/Edit', ['setting' => $setting]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'program_description' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        $setting = Setting::first(); // Always update the single setting
        $setting->update($request->only('program_name', 'program_description', 'email', 'phone'));

        return to_route('settings.edit')
            ->banner('تم تعديل الاعدادات بنجاح');
    }
}
