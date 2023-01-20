<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\URL;
use App\User;
use App\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use Mail;


class Controller extends BaseController
{
    protected $url;
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUserRole() {
        $userid = Auth::user()->id;
        $roleQuery = User::query();

        $roleQuery->join('role_user as ru', 'ru.user_id', '=', 'users.id')
            ->join('roles as r', 'r.id', '=', 'ru.role_id')
            ->select('users.id', 'users.service_provider_idservice_provider as provider_id', 'users.name', 'r.title as role_name', 'r.id as role_id');                    
        $roleQuery->where('users.id', '=', $userid);
        $roleQuery->orderBy('users.id', 'desc');
        $userRoles = $roleQuery->first();

        return $userRoles;
    }

    public function roleVerify($id) {  
        $userrole = $this->getUserRole();
        if($userrole['role_name']=='Agency'){ 
            //echo $userrole['provider_id'];
            //echo $id; die;
            if($userrole['provider_id'] != $id) {
                abort_unless('', 403);
            }
        }
    }

    public function getServiceProvider($id) {
        $agencies = ServiceProvider::join('users as ur', 'ur.service_provider_idservice_provider', '=', 'service_providers.idservice_provider')
            ->leftjoin('profiles as pr','pr.idprofile', '=', 'service_providers.profile_idprofile')
            ->leftjoin('companies as co','co.idcompany','=','service_providers.company_idcompany')
            ->join('ref_countries as c', 'c.idref_country', '=', 'service_providers.country')
            ->join('ref_states as s', 's.idref_state', '=', 'service_providers.state')
            ->select('service_providers.*','ur.email', 'ur.id','co.registration_no', 'co.uen_no', 'co.no_of_employee', 'pr.nric', 'pr.dob', 'pr.gender', 'pr.nationality', 'c.name as country', 'c.idref_country', 's.name as state', 's.idref_state')
            ->where('service_providers.idservice_provider', '=', $id)
            ->first();
        return $agencies;
    }

    public function sendMail($emailTo, $data, $template, $subjectText) {
        //$emailBcc = ["rifanece@gmail.com", "rifanece@gmail.com"];
        $data['loginUrl'] =  $this->url->to('login'); 
        $data['baseUrl'] =  $this->url->to('');               
        Mail::send('emails.'.$template, $data, function($message) use ($emailTo, $subjectText) {
            $message->to($emailTo, 'OLM')->subject($subjectText);
            // $message->bcc($emailBcc, 'OLG')->subject
            // ('New Order from Customer');
            $message->from('info@olg.com','OLM');
        });
        //echo count(Mail::failures());
    }

    public function getImagePath()
    {
        $image_path = URL::to('').'/storage/app/public';
        //$image_path = 'http://localhost/maidService/Laravel-CoreUI-AdminPanel/storage/app/public';
        return $image_path;
    }
}
