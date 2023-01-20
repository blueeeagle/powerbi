<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Users;
use App\TwoModelsTrack;

class TwoModelsTrackController extends ApiController
{
    public function index(Request $request)
    {
        //$report = Report::all();
        $reportQuery = TwoModelsTrack::query();
        //$reportQuery->where('users_categories.userId', '=', $request->userId);
        //$reportQuery->orderBy('users_categories.createdAt', 'desc');
        if($request->search !="") {
            $reportQuery->where('stock', 'like', '%' . $request->search . '%');
            $reportQuery->orwhere('vin', 'like', '%' . $request->search . '%');
            $reportQuery->orwhere('name', 'like', '%' . $request->search . '%');
        }
        if($request->age !="") { 
            $reportQuery->where('age', '=', $request->age);
        }
        if($request->order !="" && $request->orderby !="") {
            $reportQuery->orderBy($request->orderby, $request->order); 
        }
        else {
            $reportQuery->orderBy('id', 'desc'); 
        }

        $report = $reportQuery->get()->toArray();  

        return $this->successResponse($report);
    }
}
