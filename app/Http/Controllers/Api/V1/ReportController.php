<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Users;
use App\Report;


class ReportController extends ApiController
{
    public function index(Request $request)
    {
        //$report = Report::all();
        $reportQuery = Report::query();       
        if($request->search !="") {
            $reportQuery->where('stock', 'like', '%' . $request->search . '%');
            $reportQuery->orwhere('vin', 'like', '%' . $request->search . '%');
            $reportQuery->orwhere('vehicle', 'like', '%' . $request->search . '%');
        }
        if($request->age !="" && $request->age <= 100) { 
            $reportQuery->where('age', '<=', $request->age);
        }
        
        if($request->order !="" && $request->orderby !="") {
            $reportQuery->orderBy($request->orderby, $request->order); 
        }
        else {
            $reportQuery->orderBy('id', 'desc'); 
        }                
        
        $report['vehicle'] = $reportQuery->get()->toArray();  
        $ageQuery = $reportQuery;
        $ageAverage = $ageQuery->select(\DB::raw('AVG(age) as average'))->get()->first();
        $report['averageOnlineAge'] = number_format((float)$ageAverage['average'], 2, '.', '');
        $report['totalVehicleOnline'] = count($report['vehicle']);
        $report['averageOwnedAge'] = number_format((float)$ageAverage['average'], 2, '.', '');
        $report['totalVehicleinventory'] = count($report['vehicle']);
        
        return $this->successResponse($report);
    }
}
