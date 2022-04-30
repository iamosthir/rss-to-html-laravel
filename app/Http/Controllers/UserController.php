<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function update(Request $req)
    {

        $userID = auth()->user()->id;
        $this->validate($req,[
            "myname" => "required",
            "email" => "required|unique:users,email,$userID,id",
            "password" => "min:8|nullable",
            "photo" => "mimes:png,jpg,jpeg,PNG,JPG,JPEG"
        ],[
            "myname.required" => "Your name is required",
            "email.required" => "Email is required",
            "email.unique" => "This email has already taken",
            "password.min" => "password must be 8 characters minimum",
            "photo.mimes" => "Choose a valid image (jpg, png, jpeg)"
        ]);

        $user = User::find($userID);
        $user->name = $req->myname;
        $user->email = $req->email;
        
        if($req->password != "")
        {
            $user->password = bcrypt($req->password);
        }

        if($req->hasFile("photo"))
        {
            if ($user->photo != "") {
                if (file_exists(public_path("uploads/admin/profile/$user->photo"))) {
                    unlink(public_path("uploads/admin/profile/$user->photo"));
                }
            }
            $file = $req->file("photo");
            $new_name = "profile_".rand()."_"."user_".$userID.".".$file->getClientOriginalExtension();
            $file->move(public_path("uploads/admin/profile/"),$new_name);
            $user->photo = $new_name;
        }

        $user->save();

        session()->flash("success","Profile was updated");
        return redirect()->back();
    }

    public function deletePhoto(Request $req)
    {
        if($req->ajax())
        {
            $user = User::find(auth()->user()->id);

            if($user->photo != "")
            {
                if(file_exists(public_path("uploads/admin/profile/$user->photo")))
                {
                    unlink(public_path("uploads/admin/profile/$user->photo"));
                }
            }
            $user->photo = "";
            $user->save();
            return [
                "status" => "ok",
                "msg" => "Profile photo was removed"
            ];
        }
        else
        {
            return [
                "status" => "fail"
            ];
        }
    }

    public function deleteUser(Request $req)
    {
        if($req->ajax())
        {
            if($data = User::find($req->userId))
            {
                $logout = $data->id==auth()->user()->id?true:false;
                if($data->photo != "")
                {
                    if (file_exists(public_path("uploads/admin/profile/$data->photo"))) 
                    {
                        unlink(public_path("uploads/admin/profile/$data->photo"));
                    }
                }

                $data->delete();

                return [
                    "status" => "ok",
                    "msg" => "User was deleted",
                    "logout" => $logout
                ];
                
            }
            else
            {
                return [
                    "status" => "fail",
                    "msg" => "User doesn't exists"
                ];
            }
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "Illegal operation"
            ];
        }
    }

    public function addUser(Request $req)
    {
        if(auth()->user()->role == "super")
        {
            $this->validate($req, [
                "myname" => "required",
                "email" => "required|unique:users,email",
                "password" => "required|min:8|nullable",
                "photo" => "mimes:png,jpg,jpeg,PNG,JPG,JPEG"
            ], [
                "myname.required" => "Your name is required",
                "email.required" => "Email is required",
                "email.unique" => "This email has already taken",
                "password.min" => "password must be 8 characters minimum",
                "photo.mimes" => "Choose a valid image (jpg, png, jpeg)"
            ]);

            $user = new User();
            $user->name = $req->myname;
            $user->email = $req->email;
            $user->password = bcrypt($req->password);

            if($req->role == "super")
            {
                $user->role = "super";
            }

            if ($req->hasFile("photo")) 
            {
                $file = $req->file("photo");
                $new_name = "profile_" . rand() . "_" . "user_"."." . $file->getClientOriginalExtension();
                $file->move(public_path("uploads/admin/profile/"), $new_name);
                $user->photo = $new_name;
            }

            $user->save();

            session()->flash("success","New user created");
            return redirect()->back();

            
        }
        else
        {
            return [
                "status" => "fail",
                "message" => "Illegal operation"
            ];
        }
    }

    public function updateUser(Request $req)
    {
        $this->validate($req, [
            "userId" => "required|exists:users,id",
            "myname" => "required",
            "email" => "required|unique:users,email,$req->userId,id",
            "password" => "min:8|nullable",
            "photo" => "mimes:png,jpg,jpeg,PNG,JPG,JPEG"
        ], [
            "myname.required" => "Your name is required",
            "email.required" => "Email is required",
            "email.unique" => "This email has already taken",
            "password.min" => "password must be 8 characters minimum",
            "photo.mimes" => "Choose a valid image (jpg, png, jpeg)"
        ]);

        $user = User::find($req->userId);
        $user->name = $req->myname;
        $user->email = $req->email;
        
        if($req->role == "super")
        {
            $user->role = "super";
        }

        if ($req->password != "") {
            $user->password = bcrypt($req->password);
        }

        if ($req->hasFile("photo")) {

            if ($user->photo != "") {
                if (file_exists(public_path("uploads/admin/profile/$user->photo"))) {
                    unlink(public_path("uploads/admin/profile/$user->photo"));
                }
            }

            $file = $req->file("photo");
            $new_name = "profile_" . rand() . "_" . "user_" . $user->id . "." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/admin/profile/"), $new_name);
            $user->photo = $new_name;
        }

        $user->save();

        session()->flash("success", "User data was updated");
        return redirect()->back();
    }
}
