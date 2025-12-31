<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    /**
     * GET /settings
     * عرض جميع الإعدادات
     */
    public function index()
    {
        return response()->json([
            'data' => SystemSetting::all(),
        ]);
    }

    /**
     * PUT /settings/{key}
     * تعديل إعداد واحد باستخدام الـ key
     */
    public function update(Request $request, $key)
    {
        $request->validate([
            'setting_value' => 'required|string',
        ]);

        $setting = SystemSetting::where('setting_key', $key)->first();

        if(!$setting){
            return response()->json([
                'message' => 'Setting not found',
            ], 404);
        }

        $setting->update([
            'setting_value' => $request->setting_value
        ]);

        return response()->json([
            'message' => 'Setting updated successfully',
            'data' => $setting,
        ]);
    }

}
