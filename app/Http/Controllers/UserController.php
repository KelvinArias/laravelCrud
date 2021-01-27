<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return User::get();
    } 

    public function destroy(User $user){
        return $user->delete();
    }

    public function store(Request $request){
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'address' => $request['address'],
            'phone' => $request['phone'],
        ]);
    }

    public function update(Request $request, $id){
        return User::find($id)->update($request->all());
    }

}