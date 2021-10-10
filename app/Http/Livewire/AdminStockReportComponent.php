<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Models\Admin;
use App\Models\Size;
use App\Services\LogsService;
use Illuminate\Support\Facades\Auth;
use PDF;
use Livewire\Component;
use App\Models\Branch;
use App\Models\Sale;
use App\Models\SalesReturn;
use App\Models\GeneralSetting;
use App\Models\ProductsAttribute;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;


class AdminStockReportComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	public $branch_id;
	public $perPage;
	public $reportReady;
	public $reorder_level;

    public $search_type;
    public $viewFilters;
    public $searchCode;


	public function mount(){
		$this->reportReady=false;
        $this->viewFilters=true;
		$this->perPage=10;
        $this->resetPage();
	}

    public function updatedSearchType(){
        $searchType=$this->search_type;
        $this->searchCode="";
        if($searchType==="filter"){
            $this->viewFilters=true;
        }else{
            $this->viewFilters=false;
        }
    }

	public function updatedBranchId(){
		$this->reportReady=false;
		$this->reorder_level="";
        $this->resetPage();
	}
    public function updatedReorderLevel(){
        $this->reportReady=false;
        $this->resetPage();
    }


	public function downloadPDF(){


			$branch_id=$this->branch_id;

                $productsQuery=ProductsAttribute::with('branch')
                                ->with('product')
                                ->with('size')
                                ->where('branch_id',$this->branch_id);
                if($this->reorder_level===""){
                    $products=[];
                }else{
                    if($this->reorder_level==="all"){
                        $products=$productsQuery->get();
                    }else if($this->reorder_level==="<"){
                        $products=$productsQuery->get()->filter(function($product){
                            if($product->stock<Size::find($product->size_id)->reorder_level){
                                return $product;
                            }
                        });
                    }else{
                        $products=$productsQuery->get()->filter(function($product){
                            if($product->stock>Size::find($product->size_id)->reorder_level){
                                return $product;
                            }
                        });
                    }
        }
	        $branch=Branch::findOrFail($branch_id)->first()->name;

	        $settingsCount=GeneralSetting::all()->count();
	        if ($settingsCount==0) {
		        $logo='null';
	    	}else{
	    		$logo=GeneralSetting::first()->logo;
	    	}
        (new LogsService('downloaded stock report' ,'Admin'))->storeLogs();
			$pdfContent = PDF::loadView('pdf.stock',compact(['branch','products','logo']))->output();
				 return response()->streamDownload(
			     fn () => print($pdfContent),
			     "filename.pdf"
			);


	}


    public function render()
    {
        $AdminBranchId=auth()->user()->branch_id;

        if($this->search_type=="code") {
            $this->resetPage();
            $this->branch_id="";
            $this->reorder_level="";
            $productsQuery=ProductsAttribute::with('branch')
                ->with('product')
                ->with('size')
                ->where('sku',$this->searchCode);
            if (Auth::user()->role_id==Admin::IS_MANAGER){
                $products=$productsQuery->where('branch_id',$AdminBranchId)->paginate($this->perPage);
                $this->reportReady=true;
            }else{
                $products=$productsQuery->paginate($this->perPage);
                $this->reportReady=true;
            }

        }else{
            if ($this->branch_id=="") {
                $this->reportReady=false;
                $products=[];
            } else {
                $productsQuery=ProductsAttribute::with('branch')
                    ->with('product')
                    ->with('size')
                    ->where('branch_id',$this->branch_id);
                if($this->reorder_level==""){
                    $products=[];
                    $this->reportReady=false;
                }else{
                    if($this->reorder_level==="all"){
                        $products=$productsQuery->paginate($this->perPage);
                        $this->reportReady=true;
                    }else if($this->reorder_level=="<"){
                        $this->reportReady=true;
                        $products=$productsQuery->get()->filter(function($product){
                            if($product->stock<Size::find($product->size_id)->reorder_level){
                                return $product;
                            }
                        });
                    }else{
                        $this->reportReady=true;
                        $products=$productsQuery->get()->filter(function($product){
                            if($product->stock>Size::find($product->size_id)->reorder_level){
                                return $product;
                            }
                        });
                    }
                }
            }
        }


        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }



        return view('livewire.admin-stock-report-component',['branches'=>$branches,'products'=>$products,'AdminBranchId'=>$AdminBranchId])->layout('layouts.admin');
    }
}
