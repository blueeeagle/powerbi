<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser{

    protected function successResponse($data, $message = null, $code = 200)
	{
		return response()->json([
			'status'=> 'success', 
			'code'=> $code,
			'message' => $message, 
			'data' => $data
		], $code);
	}

	protected function errorResponse($message = null, $code)
	{
		return response()->json([
			'status'=> 'fail', 
			'code'=> $code,
			'message' => $message,
		], $code);
	}

}