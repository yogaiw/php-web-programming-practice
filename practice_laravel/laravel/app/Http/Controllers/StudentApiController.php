<?php

namespace App\Http\Controllers;

use App\Student;
use Validator;
use Illuminate\Http\Request;
use File;

class StudentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all()->toJson(JSON_PRETTY_PRINT);
        return response($students,200);
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
        $validateData = Validator::make($request->all(),[
            'nim'               =>'required|size:8,unique:student,nim',
            'nama'              =>'required|min:3|max:50',
            'jenis_kelamin'     =>'required|in:P,L',
            'jurusan'           =>'required',
            'alamat'            =>'',
            'image'             =>'required|file|image|max:1000',
        ]);
        if($validateData->fails()) {
            return response($validateData->errors(),400);
        } else {
            $mahasiswa = new Student();
            $mahasiswa->nim = $request->nim;
            $mahasiswa->name = $request->nama;
            $mahasiswa->gender = $request->jenis_kelamin;
            $mahasiswa->department = $request->jurusan;
            $mahasiswa->address = $request->alamat;
            if($request->hasFile('image')) {
                $extFile = $request->image->getClientOriginalExtension();
                $namaFile = 'user-'.time().".".$extFile;$path=$request->image->move('assets/images',$namaFile);
                $mahasiswa->image = $path;
            }
            $mahasiswa->save();
            return response()->json(["message"=>"student record created"],201);
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Student::where('id',$id)->exists()) {
            $validateData = Validator::make($request->all(),[
                'nim'               =>'required|size:8,unique:student,nim',
                'nama'              =>'required|min:3|max:50',
                'jenis_kelamin'     =>'required|in:P,L',
                'jurusan'           =>'required',
                'alamat'            =>'',
                'image'             =>'required|file|image|max:1000',
            ]);
            if($validateData->fails()) {
                return response($validateData->errors(),400);
            } else {
                $mahasiswa = Student::find($id);
                $mahasiswa->nim = $request->nim;
                $mahasiswa->name = $request->nama;
                $mahasiswa->gender = $request->jenis_kelamin;
                $mahasiswa->department = $request->jurusan;
                $mahasiswa->address = $request->alamat;
                if($request->hasFile('image')) {
                    $extFile = $request->image->getClientOriginalExtension();
                    $namaFile='user-'.time().".".$extFile;
                    File::delete($mahasiswa->image);
                    $path = $request->image->move('assets/images',$namaFile);
                    $mahasiswa->image = $path;
                }
                $mahasiswa->save();
                return response()->json(["message"=>"student record updated"],201);
            }
        } else {
            return response()->json(["message"=>"Student not found"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Student::where('id',$id)->exists()) {
            $mahasiswa = Student::find($id);
            File::delete($mahasiswa->image);
            $mahasiswa->delete();
            return response()->json(["message"=>"student record deleted"],201);
        } else {
            return response()->json(["message"=>"Student not found"],404);
        }
    }
}
