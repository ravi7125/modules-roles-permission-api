<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Traits\Listingapi;

class EmployeeController extends Controller
{
    use Listingapi;
    public function add(Request $request)
    {
        $request->validate([
            'name'          =>  'required',
            'description'   =>  'nullable|max:255',
        ]);
        $employee = new employee();
        $employee->name =$request->name;
        $employee->description=$request->description;
        $employee->city =$request->city;
        $employee->salary=$request->salary;
        $employee->save();
        return message($employee);
    }
 
// show modules
    public function view($id = null){
         $employee = $id ? employee::findOrFail($id) : employee::all();
 
    if ($employee->isEmpty()) {
        return 'Data is not available';
    }
 
        return message($employee);
    }
 
//modules update 
    public function update(Request $request,$id)
   {
        $employee = employee::findOrFail($request->id);
        $employee->name=$request->name;
        $employee->description=$request->description;
        $employee->city =$request->city;
        $employee->salary=$request->salary;
        $employee->save();
        return response()->json([
        'message' => 'employee updated successfully'
    ]);
    }
 //Delete modules data.. 
    function Delete($id){
        $employee = employee::findOrFail($id);
        $employee->delete();     
        return message('employee data deleted');
    }

   
}


