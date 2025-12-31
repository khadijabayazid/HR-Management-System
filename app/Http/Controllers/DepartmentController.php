<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        $query = Department::query();
        if ($request->has('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        return response()->json([
            'data' => $query->paginate(10),
        ]);
    }

    public function store(StoreDepartmentRequest $request)
    {

        $department = Department::create($request->validated());

        return response()->json([
            'message' => 'Department created successfully',
            'data' => $department
        ], 201);
    }

    public function show($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }
        return response()->json([
                'data' => $department,
            ]);
    }

    public function update(UpdateDepartmentRequest $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }

        $department->update($request->validated());

        return response()->json([
            'message' => 'Department updated successfully',
            'data' => $department,
        ]);
    }

    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }

        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully',
        ]);
    }
}
