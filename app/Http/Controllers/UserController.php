<?php

namespace App\Http\Controllers;

use App\Role;
use App\Tables\UsersTable;
use App\User;
use ErrorException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws ErrorException
     */
    public function index()
    {
        $table = (new UsersTable())->setup();

        return view('users.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/users/create')->with('error', 'Validation Error');
        }

        $roleId = Role::where('name', Role::ROLE_USER)->firstOrfail()->id;
        $user = User::create([
            'name'    => $request->get('name'),
            'email'    => $request->get('email'),
            'password'   =>  Hash::make($request->get('password')),
            'role' =>  $roleId,
        ]);

        return redirect('/users/' . $user->id . '/edit');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        return view('users.create', ['user' => User::where('id', $id)->firstOrFail()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect('/users/' . $user->id .  '/edit')->with('error', 'Validation Error');
        }

        $user->update([
            'name'    => $request->get('name'),
            'email'    => $request->get('email'),
        ]);

        return redirect('/users/' . $user->id. '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect('/users');
    }

    public function changePassword()
    {
        return view('users.change_password');
    }

    public function saveNewPassword(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|max:255',
            'confirmed_password' => 'required|string|max:255',
        ]);

        if ($validator->fails() && $request->get('password') === $request->get('confirmed_password')) {
            return redirect('/change_password')->with('error', 'Validation Error');
        }

        $user->update([
            'password' => Hash::make($request->get('password')),
        ]);

        return redirect('/');
    }
}
