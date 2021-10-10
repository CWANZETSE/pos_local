<?php

namespace App\Console\Commands;

use App\Models\CashPayment;
use App\Models\Reconciliation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SaveCashierBalancingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cashier:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saves Cashier Data Every Midnight';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cashiers=User::all();
        foreach ($cashiers as $cashier){
            $today= date('Y-m-d');
            $from = Carbon::parse($today)
                ->startOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $to = Carbon::parse($today)
                ->endOfDay()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59
            $cashSalesTendered=CashPayment::where('user_id',$cashier->id)
                ->whereBetween('created_at', [$from, $to])
                ->sum('tendered');
            $cashSalesChange=CashPayment::where('user_id',$cashier->id)
                ->whereBetween('created_at', [$from, $to])
                ->sum('change');
            $saleAmount=CashPayment::where('user_id',$cashier->id)
                ->whereBetween('created_at', [$from, $to])
                ->sum('total');
            $recon=new Reconciliation();
            $recon->create(
                [
                    'user_id'=>$cashier->id,
                    'sales_date'=>$today,
                    'totalCashSales'=>$saleAmount,
                    'declaredAmount'=>0,
                    'balance'=>0
                ]
            );

        }
    }
}
