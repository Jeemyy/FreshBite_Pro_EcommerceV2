<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Show the form for editing the settings.
     */
    public function index()
    {
        // جلب أول record موجود أو إنشاء واحد افتراضي إذا مش موجود
        $setting = Setting::firstOrCreate([], [
            'about' => null,
            'contact' => ['address' => '', 'email' => '', 'phone' => ''],
            'pages' => [],
        ]);

        // قائمة الصفحات الممكن الاختيار منها
        $allPages = ['Home', 'About', 'Shop', 'News', 'Contact'];

        return view('admin.settings.index', compact('setting', 'allPages'));
    }

    /**
     * Update the settings in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        // جمع البيانات لتخزينها
        $data = [
            'about' => $request->input('about', null),
            'contact' => [
                'address' => $request->input('contact.address', ''),
                'email' => $request->input('contact.email', ''),
                'phone' => $request->input('contact.phone', ''),
            ],
            'pages' => $request->input('pages', []), // array of selected pages
        ];

        // تحديث البيانات في قاعدة البيانات
        $setting->update($data);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
