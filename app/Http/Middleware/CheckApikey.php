<?php

namespace App\Http\Middleware;
use App\Http\Controllers\ApiController;


use Closure;

use Config;

use Response;

class CheckApikey extends ApiController
{
  
  /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
  */
  public function handle($request, Closure $next)
  {
       //print_r($request); exit();
    if($request->header('apiKey') != 'POWER@2022') {  

      // $json = [
      //      'status' => false,
      //      'status_code' => Config::get('constants.no_access'),
      //      'message' => "Invalid API Key",
      // ];

      return $this->errorResponse('invalid api key', 401);

      //return Response::json($json);
    }

    return $next($request);
  }

}