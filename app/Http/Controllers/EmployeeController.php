<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Employee;
use DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        //
    }

    public function getEmployees(Request $request, Employee $employee)
    {
        $employeeData = $employee->getEmployee();
        return DataTables::of($employeeData)
                ->addColumn('Action', function($employeeData){
                    return '<button type="button" class="btn btn-success btn-sm" id="getEditEmployeeModal" data-id="'.$employeeData->id.'">Edit</button>
                    <button type="button" data-id="'.$employeeData->id.'" data-toggle="modal" data-target="#DeleteEmployeeModal" class="btn btn-danger btn-sm" id="getEmployeeDeleteId">Delete</button>';
                })
                ->rawColumns(['Action'])
                ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'designation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $employee->addEmployee($request->all());
        return response()->json(['success'=>'Employee added successfully']);
    }

    public function edit($id)
    {
        $employee = new Employee;
        $employeeData = $employee->findorfail($id);

        $htmlData = '<div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="'.$employeeData->name.'" id="nameId">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" value="'.$employeeData->email.'" id="emailId">
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation:</label>
                        <input type="text" class="form-control" name="designation" value="'.$employeeData->designation.'" id="designationId">
                    </div>';

        return response()->json(['html'=>$htmlData]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'designation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $employee = new Employee;
        $employee->updateEmployee($id, $request->all());

        return response()->json(['success'=>'Employee updated successfully']);
    }

    public function destroy($id)
    {
        $employee = new Employee;
        $employee->deleteEmployee($id);

        return response()->json(['success'=>'Employee deleted successfully']);
    }
}
