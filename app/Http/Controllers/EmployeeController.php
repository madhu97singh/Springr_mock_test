<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeForm;
use App\Models\Employee;
use File;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->paginate(5);

        return view('employee.index', compact('employees'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    { 
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|regex:/^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7}$/|unique:users,email',
            // 'image' => 'required|mimes:png,jpeg,gif,jpg',
            'image' => 'required',
            'date_of_joining' => 'required',
            'date_of_leaving' => 'required|after:date_of_joining',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $dateFrom = Carbon::parse($request->date_of_joining);
        $dateTo = Carbon::parse($request->date_of_leaving);
        $interval = $dateFrom->diff($dateTo);
        $experience = $interval->format('%y years %m months');
        // $experience = $interval->format('%y years %m months and %d days');
        
        // $image=$request->file('image');
        // $my_image=rand().'.'. $image->getClientOriginalExtension();
        // $image->move('media/upload',$my_image);
        // $request->image = $my_image;

        // if ($request->hasFile('image')){
        //     $image = Storage::putFile('public/',$request->image);
        // }

        $employee= new Employee();
        $employee->name=$request->name;
        $employee->email=$request->email;
        $employee->date_of_joining=$request->date_of_joining;
        $employee->date_of_leaving=$request->date_of_leaving;
        $employee->still_working=$request->still_working;
        $employee->image=$request->image;
        // $employee->image=$request->file('image')->store('public');
        $employee->experience=$experience;
        $employee->save();
   
        return response()->json(['success'=>'Data is successfully added']);
    }

    public function destroy($id)
    {
        $employee=Employee::find($id);
        if($employee)
        {
            $employee->delete();
            $employeearr['status'] = "success";
        }else{
            $employeearr['status'] = "fail";
        }
        return json_encode($employeearr);
        exit;
    }
}

