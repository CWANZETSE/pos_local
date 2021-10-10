<?php


namespace App\Services;


use App\Models\CashPayment;
use App\Models\Declarations;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CashierUndeclaredCashService
{
    public function CalculateUndeclaredCash (){
        $from    = Carbon::parse(Carbon::today())
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse(Carbon::today())
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $transactionsSum=CashPayment::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('reversed',0)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total');
        $approvedDeclaredCash=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_APPROVED)
            ->sum('amount');
        $pendingDeclaredCash=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_PENDING)
            ->sum('amount');
        $openingBalance=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('float',1)
            ->sum('amount');
        $undeclared=($transactionsSum+$openingBalance)-($approvedDeclaredCash+$pendingDeclaredCash);
        return $undeclared;
    }
}
