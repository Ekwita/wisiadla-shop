<?php

namespace App\Http\Controllers\CRUD;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::all();
        return view('crud.users.index', ['users' => $users]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $availableRoles = UserRoleEnum::ROLE;
        $validatedData = $request->validate([
            'role' => 'required', Rule::in($availableRoles)
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index');
    }
}
