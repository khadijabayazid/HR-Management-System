<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\JobTitle;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['JobTitle', 'jobTitle.department']);
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orwhere('phone', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        if ($request->has('employee_type')) {
            $query->where('employee_type', $request->employee_type);
        }

        if ($request->has('department_id')) {
            $query->whereHas('JobTitle', function ($q) use ($request) {
                $q->where('deparment_id', $request->department_id);
            });
        }

        return response()->json([
            'data' => $query->paginate(10),
        ]);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());

        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    public function show(string $id)
    {
        $employee = Employee::with(['jobTitle', 'jobTitle.department', 'attendances'])->find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found',
            ], 404);
        }
        return response()->json([
                'data' => $employee,
            ]);
    }

    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found',
            ], 404);
        }

        $employee->update($request->validated());

        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $employee,
        ]);
    }

    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found',
            ], 404);
        }

        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully',
        ]);
    }
}
