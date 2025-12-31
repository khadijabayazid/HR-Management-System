<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobTitleRequest;
use App\Http\Requests\UpdateJobTitleRequest;
use App\Models\JobTitle;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    
    public function index(Request $request)
    {
        $query = JobTitle::with('department');
        if ($request->has('search')) {
            $query->where('title', 'LIKE', "%{$request->search}%");
        }

        if($request->has('department_id')){
            $query->where('department_id',$request->department_id);
        }
        return response()->json([
            'data' => $query->paginate(10),
        ]);
    }

    public function store(StoreJobTitleRequest $request)
    {
        $jobTitle = JobTitle::create($request->validated());

        return response()->json([
            'message' => 'Job Title created successfully',
            'data' => $jobTitle
        ], 201);
    }

    public function show(string $id)
    {
        $jobTitle = JobTitle::with('department')->find($id);

        if (!$jobTitle) {
            return response()->json([
                'message' => 'Job Title not found',
            ], 404);
        }
        return response()->json([
                'data' => $jobTitle,
            ]);
    }

    public function update(UpdateJobTitleRequest $request, string $id)
    {
        $jobTitle = JobTitle::find($id);

        if (!$jobTitle) {
            return response()->json([
                'message' => 'Job Title not found',
            ], 404);
        }

        $jobTitle->update($request->validated());

        return response()->json([
            'message' => 'Job Title updated successfully',
            'data' => $jobTitle,
        ]);
    }

    public function destroy(string $id)
    {
        $jobTitle = JobTitle::find($id);

        if (!$jobTitle) {
            return response()->json([
                'message' => 'Job Title not found',
            ], 404);
        }

        $jobTitle->delete();

        return response()->json([
            'message' => 'Job Title deleted successfully',
        ]);
    }
}
