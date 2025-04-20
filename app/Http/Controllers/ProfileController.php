<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mobile.profile.edite', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}
