<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.pages.profile.edit', [
            'admin' => auth('admin')->user(),
        ]);
    }

    public function updatePassword(AdminUpdatePasswordRequest $request): RedirectResponse
    {
        $admin = auth('admin')->user();
        $admin->forceFill([
            'password' => Hash::make($request->validated('password')),
        ])->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', __('Password updated successfully.'));
    }
}
