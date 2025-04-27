<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'reported_type' => 'required|string|in:post,comment,user',
            'reported_id' => 'required|integer',
            'reason' => 'required|string|max:1000',
        ]);
    
        Report::create([
            'reporter_id' => Auth::id(),
            'reported_type' => $request->reported_type,
            'reported_id' => $request->reported_id,
            'reason' => $request->reason,
        ]);
    
        return back()->with('success', 'Votre signalement a été soumis avec succès.');
    }
    

    public function index()
    {
        $reports = Report::with('reporter', 'reported')->latest()->get();

        return response()->json($reports);
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return response()->json([
            'message' => 'Le signalement a été supprimé avec succès.'
        ]);
    }
}