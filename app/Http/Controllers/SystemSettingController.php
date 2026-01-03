<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SystemSettingController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => SystemSetting::all(),
        ]);
    }

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
