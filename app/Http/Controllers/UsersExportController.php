<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class UsersExportController extends Controller
{
    public function export(Excel $excel){
        return shell_exec('rundll32 user32.dll,MessageBeep');
    }
}
