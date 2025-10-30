<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Recruitment;
use App\Models\Schedule;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
       
        return view('dashboard');
    }

    public function stats(){

         $donnee = [
            'total_employees'=> Employee::count(),
            'total_departments' => Department::count(),
            'active_recruitments' => Recruitment::where('status','open')->count(),
            'open_support_tickets' => SupportTicket::where('status', 'Open')->count(),

            'recruitment_descriptions' => Recruitment::select('title', 'description','created_at')
            ->latest()
            ->take(3)
            ->get(),

            'upcoming_schedules' => Schedule::select('title', 'notes', 'start_time')
            ->orderBy('start_time', 'asc')
            ->take(3)
            ->get(),

        ];

        return response()->json([
            'successful'=> true,
            'data'=> $donnee
        ]);
    }
}
