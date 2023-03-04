<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            "user_records" => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users/add', [
            'role_records' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check input validation
        $request->validate([
            'firstName' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'role_id' => 'required'

        ]);

        //filter input data
        $prefix = isset($request->prefix) ? $request->prefix.' ' : '';
        $lastName = isset($request->gender) ? ' '.$request->gender : '';
        $gender = isset($request->gender) ? $request->gender : 0;
        $phone = isset($request->phone) ? $request->phone : '';
        $email = isset($request->email) ? $request->email : '';
        $is_active = isset($request->is_active) ? 1 : 0;

        //store to database
        $user = new User();
        $user->name = $prefix . $request->firstName . $lastName;
        $user->username = $request->username;
        $user->gender = $gender;
        $user->is_active = $is_active;
        $user->email = $email;
        $user->password = Hash::make($request->password);
        $user->phone = $phone;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index')->with([
            'message' => 'New user added',
            'type' => 'success',
            'duration' => 5000,
            'dismissible' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users/view', [
            "user" => $user,
            "role_name" => Role::find($user->role_id)->name,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users/edit', [
            "user" => User::find($id),
            "role_records" => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => 'required',
            'username' => Rule::unique('users')->ignore($id),
            'password' => isset($request->password) ? 'confirmed|min:6' : '',
            'role_id' => 'required',

        ]);

        $prefix = isset($request->prefix) ? $request->prefix.' ' : '';
        $lastName = isset($request->gender) ? ' '.$request->gender : '';
        $gender = isset($request->gender) ? $request->gender : 0;
        $phone = isset($request->phone) ? $request->phone : '';
        $email = isset($request->email) ? $request->email : '';
        $is_active = isset($request->is_active) ? 1 : 0;

        $user = User::find($id);
        $user->name = $prefix . $request->firstName . $lastName;
        $user->username = $request->username;
        $user->gender = $gender;
        $user->is_active = $is_active;
        $user->email = $email;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->phone = $phone;
        $user->role_id = $request->role_id;
        $user->update();

        return redirect()->route('users.index')->with([
            'message' => 'User update successfully',
            'type' => 'success',
            'duration' => 5000,
            'dismissible' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return back()->with([
            'message' => 'User deleted',
            'type' => 'success',
            'duration' => 5000,
            'dismissible' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showProfile()
    {
        $role_name = Role::find(Auth::user()->role_id)->name;
        return view('users/profile', compact('role_name'));
    }

    /**
     * Store the profile picture to database.
     */
    public function uploadProfilePic(Request $request)
    {
        $storage_is = $request->storage;

        $photo = $request->file('photo');
        $fileName = uniqid().'.'.$photo->getClientOriginalName();
        $user = User::find(Auth::user()->id);
        $path = storage_path('app/public/user_profile_photo/'.$user->profile_photo);

        if ($storage_is === 'default'){
            $photo->storeAs('user_profile_photo', $fileName, 'public');
            if ($user->profile_photo != NULL){
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        }else{
            Storage::disk('spaces')->put('photos/'.$fileName,  file_get_contents($photo), [
                'visibility' => 'public'
            ]);
        }
        $user->profile_photo = $fileName;
        $user->update();
        return redirect()->back()->with([
            'message' => 'Photo uploaded successfully',
            'type' => 'success',
            'duration' => 5000,
            'dismissible' => true,
        ]);

    }

    /**
     * Display profile picture.
     */
    public function profileUrl(){
        $response = Http::get(Storage::disk('spaces')->url('photos/'.Auth::user()->profile_photo));
        if (Auth::user()->profile_photo == NULL ){
            return 'https://ui-avatars.com/api/?name='.Auth::user()->name.'&background=083b4e&color=fff';
        }else {
            if ($response->status() === 200) {
                return Storage::disk('spaces')->url('photos/' . Auth::user()->profile_photo);
            } else {
                return asset('storage/user_profile_photo/' . Auth::user()->profile_photo);
            }
        }

    }

    /**
     * Remove profile picture from database and storage;
     */
    public function destroyProfilePic($id)
    {

        $user = User::find($id);
        $path = storage_path('app/public/user_profile_photo/'.$user->profile_photo);
        $response = Http::get(Storage::disk('spaces')->url('photos/'.$user->profile_photo));
        if ($response->status() === 200) {
            Storage::disk('spaces')->delete('photos/'.$user->profile_photo);
            $user->profile_photo = NULL;
            $user->update();
            return redirect()->back();
        }else{
            if (File::exists($path)) {
                File::delete($path);
                $user->profile_photo = NULL;
                $user->update();
                return redirect()->back();
            }
        }
    }
    /**
     * Update the specified user password in storage.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => 'required|confirmed|min:6',
        ]);

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with([
            'message' => 'Password update successfully',
            'type' => 'success',
            'duration' => 5000,
            'dismissible' => true,
        ]);

    }
}
