<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
class UserController extends Controller
{
    //
    public function profile(){
        return view('user.profile',['user'=>Auth::user()]);
    }

    public function updateProfileImg(Request $request){
        if($request->hasFile('icon_url')){
            $icon_url = $request->file('icon_url');
            $filename = time() . '.' . $icon_url->getClientOriginalExtension();
            Image::make($icon_url)->resize(300,300)->save(public_path('/upload/userimgs/'.$filename));

            $user = Auth::user();
            $user->icon_url = $filename;
            $user->save();
        }
        return view('user.profile',['user'=>Auth::user()]);
    }
}
