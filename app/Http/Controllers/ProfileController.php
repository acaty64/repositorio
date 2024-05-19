<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\Middleware;

class ProfileController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('can:profile.index', only: ['index']),
            new Middleware('can:profile.create', only: ['create', 'store']),
            new Middleware('can:profile.edit', only: ['edit', 'update']),
            new Middleware('can:profile.destroy', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $users = User::all();
        return view('profile.index', compact('users'));
    }

    public function edit($id): View
    {
        $user = User::findOrFail($id);

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        /* ToDo Validation */

        $user = User::findOrFail($request->id);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return Redirect::route('profile.index');
        //return Redirect::route('profile.edit', $user->id)->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        /*
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        */
        
        //$user = $request->user();
        $user = User::findOrFail($request->id);

        //Auth::logout();

        $user->delete();

        //$request->session()->invalidate();
        //$request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
