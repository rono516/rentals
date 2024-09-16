<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($userUuid)
    {
        return view('users.edit', [
            'user' => $this->verifyUser($userUuid),
        ]);
    }

    public function update(Request $request, $userUuid)
    {
        $user = $this->verifyUser($userUuid);

        $validData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if ($validData['email'] !== $user->email) {
            $validData['email_verified_at'] = null;
        }

        $user->update($validData);

        flash()->addSuccess('Profile updated successfully.');

        return redirect()->route('users.edit', ['userUuid' => $user->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function verifyUser($userUuid)
    {
        $user = User::where('uuid', $userUuid)->firstOrFail();

        if ($user->id !== auth()->user()->id) {
            abort(404);
        }

        return $user;
    }
}
