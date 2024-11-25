<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedSchedule;

class FeedScheduleController extends Controller
{
    public function index()
    {
        return response()->json(FeedSchedule::all());
    }

    public function store(Request $request)
    {
        $feedSchedule = FeedSchedule::create($request->all());
        return response()->json($feedSchedule, 201);
    }

    public function update(Request $request, $id)
    {
        $feedSchedule = FeedSchedule::findOrFail($id);
        $feedSchedule->update($request->all());
        return response()->json($feedSchedule);
    }

    public function destroy($id)
    {
        FeedSchedule::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
