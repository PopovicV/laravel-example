<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserWebController extends Controller
{
  public function index()
  {
    $users = User::all();
    return view("users", ["users"=>$users]);
  }

  public function show($id)
  {
      return User::find($id);
  }

  public function update(Request $request, $id)
  {
      $user = User::findOrFail($id);
      $userData = $request->all();

      $validator = Validator::make($userData, [
        'first_name' => ['sometimes', 'string', 'max:255'],
        'last_name' => ['sometimes', 'string', 'max:255'],
        'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
      ]);

      if ($validator->fails()) {
        Session::flash('error-message', $validator->errors());
        return view('profile');
      }

      $user->first_name = $userData['first_name'] ? $userData['first_name'] : $user->first_name;
      $user->last_name = $userData['last_name'] ? $userData['last_name'] : $user->last_name;
      $user->email = $userData['email'] ? $userData['email'] : $user->email;
      if (isset($userData['password']) && isset($userData['password_confirmation'])) {
        $user->password = Hash::make($userData['password']);
      }
      $user->save();
      Session::flash('success-message', 'User successfully updated!');
      return redirect()->to('/profile');
  }

  public function delete(Request $request, $id)
  {
      $user = User::findOrFail($id);
      $user->delete();

      return 204;
  }

  public function showProfile() {
    return view("profile");
  }
}
