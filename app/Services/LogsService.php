<?php


namespace App\Services;


use App\Models\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LogsService
{
    protected $event;
    protected $model;


    public function __construct($event,$model)
    {
        $this->event=$event;
        $this->model=$model;
    }

    public function storeLogs(){

        $myIp=getHostByName(getHostName());

        $log=new Log();
        $log->create([
            'user_id'=>Auth::user()->id,
            'event'=>$this->event,
            'model'=>$this->model,
            'ip'=>$myIp,
        ]);
    }
}
