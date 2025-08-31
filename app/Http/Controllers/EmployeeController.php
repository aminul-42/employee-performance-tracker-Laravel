<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('admin.dashboard.employee.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.dashboard.employee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'role' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'salary' => 'nullable|numeric|min:0',
            'join_date' => 'nullable|date',
        ]);

       $data = $request->all();

if ($request->hasFile('profile_picture')) {
    $file = $request->file('profile_picture');

    // Create a safe filename from employee name + extension
    $filename = str_replace(' ', '_', strtolower($request->name)) . '.' . $file->getClientOriginalExtension();

    // Store in storage/app/public/profile_pictures/
    $path = $file->storeAs('profile_pictures', $filename, 'public');

    $data['profile_picture'] = $path; // will be "profile_pictures/employee_name.jpg"
}

Employee::create($data);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('admin.dashboard.employee.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.dashboard.employee.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'role' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'salary' => 'nullable|numeric|min:0',
            'join_date' => 'nullable|date',
        ]);

        $data = $request->all();
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        // Delete profile picture if exists
    if ($employee->profile_picture && Storage::disk('public')->exists($employee->profile_picture)) {
        Storage::disk('public')->delete($employee->profile_picture);
    }

        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }

  
}