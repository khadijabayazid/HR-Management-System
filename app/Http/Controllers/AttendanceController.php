<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AttendanceController extends Controller
{

    public function index(Request $request)
    {
        $query = Attendance::with(['employee', 'editor']);

        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        return response()->json([
            'data' => $query->orderBy('date','desc')->paginate(20),
        ]);
    }

    public function store(StoreAttendanceRequest $request)
    {
        $data = $request->validated();

        if(!empty($data['check_in'])){
            $workStart = Carbon::createFromTime(9,0,0);
            $checkIn = Carbon::parse($data['check_in']);

            if($checkIn->gt($workStart)){
                $data['late_minutes'] = $workStart->diffInMinutes($checkIn);
                $data['status'] = 'late';
            }
            else{
                $data['late_minutes'] = 0;
            }
        }
        $data['edited_by'] = auth()->id();
        
        $attendance = Attendance::create($data);
        
        return response()->json([
            'message' => 'Attendance recorded successfully',
            'data' => $attendance
        ], 201);
    }

    public function show(string $id)
    {
        $attendance = Attendance::with(['employee','editor'])->find($id);

        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance not found',
            ], 404);
        }
        return response()->json([
                'success' => true,
                'data' => $attendance,
            ]);
    }

    public function update(UpdateAttendanceRequest $request, string $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance not found',
            ], 404);
        }

        $data = $request->validated();

        if(!empty($data['check_in'])){
            $workStart = Carbon::createFromTime(9,0,0);
            $checkIn = Carbon::parse($data['check_in']);

            if($checkIn->gt($workStart)){
                $data['late_minutes'] = $workStart->diffInMinutes($checkIn);
                $data['status'] = 'late';
            }
            else{
                $data['late_minutes'] = 0;
            }
        }
        $data['edited_by'] = auth()->id();

        $attendance->update($data);

        return response()->json([
            'message' => 'Attendance updated successfully',
            'data' => $attendance,
        ]);
    }

    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance not found',
            ], 404);
        }

        $attendance->delete();

        return response()->json([
            'message' => 'Attendance deleted successfully',
        ]);
    }
}
