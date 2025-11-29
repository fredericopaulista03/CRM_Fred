<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'google_analytics' => Setting::get('google_analytics', ''),
            'gtm_head' => Setting::get('gtm_head', ''),
            'gtm_body' => Setting::get('gtm_body', ''),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'google_analytics' => 'nullable|string',
            'gtm_head' => 'nullable|string',
            'gtm_body' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings')->with('success', 'Configurações salvas com sucesso!');
    }
}
