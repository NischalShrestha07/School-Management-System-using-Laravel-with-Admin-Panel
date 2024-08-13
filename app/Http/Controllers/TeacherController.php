<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        return view('admin.teacher.form');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'dob' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = new User();

        $user->name = $request->name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->dob = $request->dob;
        $user->mobno = $request->mobno;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'teacher';
        $user->save();

        return redirect()->route('teacher.create')->with('success', 'Teacher Added Successfully');
    }
    public function read()
    {
        $teachers = User::where('role', 'teacher')->latest()->get();
        // dd($teachers);
        return view('admin.teacher.table', compact('teachers'));
    }

    public function edit($id)
    {
        $teacher = User::find($id);
        return view('admin.teacher.editForm', compact('teacher'));
    }

    public function delete($id)
    {
        $teacher = User::find($id);
        $teacher->delete();

        return redirect()->route('teacher.read')->with('success', 'Teacher Deleted Successfully.');
    }
    public function update(Request $request, $id)
    {

        $teacher = User::find($id);
        $teacher->name = $request->name;
        $teacher->father_name = $request->father_name;
        $teacher->mother_name = $request->mother_name;
        $teacher->dob = $request->dob;
        $teacher->mobno = $request->mobno;
        $teacher->email = $request->email;
        $teacher->update();


        return redirect()->route('teacher.read')->with('success', 'Teacher Updated SuccessFully.');
    }
}
