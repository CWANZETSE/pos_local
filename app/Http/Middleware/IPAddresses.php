<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Terminal;

class IPAddresses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        //$request->ip(); //IP ADDRESS
        //192.168.100.1 //Router IP
        //192.168.100.124 //Computer IP
        // $myMac=substr(shell_exec('getmac'), 159,20);
        // ob_start();
        // system('getmac');
        // $Content = ob_get_contents();
        // ob_clean();
        // $myMac=substr($Content, strpos($Content,'\\')-20, 17);

        $activeTerminals=Terminal::where('status',1)->get();

        $ips_array=[];
        foreach ($activeTerminals as $key => $terminal) {
            array_push($ips_array, $terminal->ip_address);
        }
        
        $myIp=$request->ip(); 

        if (!in_array($myIp, $ips_array)) {
            abort(401);
        }else{
            return $next($request);
        }
        
    }

}
