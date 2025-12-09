<?php
namespace App\Http\Controllers;
class UserController extends Controller 
{
    public function profile()
{
    $user = User::find(session('user_id'));
    return view('client.profile', compact('user'));
}

public function update(Request $req)
{
    $user = User::find(session('user_id'));

    $user->name = $req->name;
    $user->email = $req->email;
    $user->phone = $req->phone;
    $user->address = $req->address;

    if ($req->password) {
        $user->password = Hash::make($req->password);
    }

    $user->save();

    return back()->with('success', 'Cập nhật thành công!');
}
}