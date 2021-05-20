<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'name', 'email', 'designation',
    ];

    public function getEmployee()
    {
        return Employee::get();
    }

    public function addEmployee($data)
    {
        return Employee::create($data);
    }

    public function updateEmployee($id, $data)
    {
        return Employee::find($id)->update($data);
    }

    public function deleteEmployee($id)
    {
        return Employee::find($id)->delete();
    }
}
