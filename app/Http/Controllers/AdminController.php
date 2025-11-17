<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Status;

class AdminController extends Controller
{
    public function index(Request $request){
         
        $sort = $request->input('sort', 'desc');
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }
            
        $statusId = $request->input('status');
        
        $query = Report::query();
        
        if ($statusId) {
            $validatedData = $request->validate([
                'status' => "nullable|exists:statuses,id"
            ]);
            
            if (isset($validatedData['status'])) {
                $query->where('status_id', $statusId);
            } else {
                $statusId = null;
            }
        }

        $reports = $query->with(['user', 'status'])
            ->orderBy('created_at', $sort)
            ->paginate(8)
            ->withQueryString();

         $statuses = Status::all();

        return view('admin.index', compact('reports', 'statuses', 'sort', 'statusId'));
    }
    
    public function update(Request $request, Report $report)
    {
        $data = $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);
        
        $report->update($data);
        
        return redirect()->back()->with('success', 'Статус заявки обновлен.');
    }
}