<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | This Method is use to update password of the admin
    |--------------------------------------------------------------------------
    */
    public function PasswordUpdate(Request $request)
    {
        $password = $request['password'];
        $newpass = $request['newpass'];

        $id = Auth::user()->id;

        $update = User::find($id);

        $update->password = bcrypt($password);

        $update->save();

        return redirect()->route('admin_home')->with('message', 'Successfully Updated Password!');
    }

    /*
    |--------------------------------------------------------------------------
    | This Method is use to update the profile of the admin
    |--------------------------------------------------------------------------
    */
    public function ProfileUpdate(Request $request)
    {
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $mobile = $request['mobile'];
        $bday = $request['bday'];
        $id = $request['id'];

        $update = User::find($id);

        $update->firstname = $firstname;
        $update->lastname = $lastname;
        $update->mobile = $mobile;
        $update->birthday = $bday;

        $update->save();

        return redirect()->route('admin_profile')->with('message', 'Successfully Updated Profile');
    }

    /*
    |--------------------------------------------------------------------------
    | Method to edit profile of the admin
    |--------------------------------------------------------------------------
    */
    public function ProfileEdit()
    {
        $admin = User::where('privelege', 'Admin')->first();

        return view('pages.admin.show_admin_profile_edit', $admin);
    }

   	/*
    |--------------------------------------------------------------------------
    | This method is use to show admin profile
    |--------------------------------------------------------------------------
    */
    public function showAdminProfile()
    {
        $admin = User::where('privelege', 'Admin')->first();

    	return view('pages.admin.show_admin_profile', $admin);
    }

    /*
    |--------------------------------------------------------------------------
    | This method is use to verify the admin user
    |--------------------------------------------------------------------------
    */
    public function verifyAdmin()
    {
    	if(Auth::user()->privelege == 'Admin') {
    		return redirect()->route('admin_home');
    	}
    	
    	Auth::logout();

    	return redirect()->route('signin')->with('errormessage', 'Your Are Not Allowed to use the URL!');
    }
   
}
