<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __invoke()
    {
        $cases = Cases::with("user", "contact", "organizationProcess")->get();
        return view('admin.reports', compact('cases'));
    }


    public function dataCharts(){
        $stats = [
            'total' => Cases::count(),
            'attended' => Cases::where('status', 'attended')->count(),
            'in_progress' => Cases::where('status', 'in_progress')->count(),
            'not_attended' => Cases::where('status', 'not_attended')->count(),
        ];

        
       
        ]
    }
}
