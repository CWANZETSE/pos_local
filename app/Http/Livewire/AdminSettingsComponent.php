<?php

namespace App\Http\Livewire;

use App\Models\Tax;
use App\Services\LogsService;
use Livewire\Component;
use App\Models\GeneralSetting;
use App\Models\Terminal;
use Validator;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
class AdminSettingsComponent extends Component
{
	use WithFileUploads;
	use WithPagination;
	protected $paginationTheme = 'bootstrap';


	public $state=[];
	public $updatingMode;
	public $ip_address;
	public $mac_address;
	public $location;
	public $status;
	public $search="";
	public $pagesize=5;
	public $sorting;
	public $termialId;
	public $mpesa;
	public $cash;
	public $kcb_pinpad;
	public $updatingTaxMode;
	public $tax_name;
	public $percentage;
    public $tax_id;
    public $success_creating_tax_msg;
    public $success_updating_tax_msg;


	protected $rules = [
        'mac_address' => 'required|unique:terminals',
    ];
    /**
     * @var mixed
     */


    public function mount(){
		$this->updatingMode=false;
		$this->updatingTaxMode=false;
		$this->status=false;

		$settings=GeneralSetting::take(1)->first();
    	if (!empty($settings)) {
	    	$this->state['store_footer_copyright']=$settings->store_footer_copyright;
			$this->state['store_name']=$settings->store_name;
			$this->state['store_address']=$settings->store_address;
			$this->state['store_phone']=$settings->store_phone;
			$this->state['store_email']=$settings->store_email;
			$this->state['store_website']=$settings->store_website;
			$this->state['tax_percentage']=$settings->tax_percentage;
			$this->state['printer_name']=$settings->printer_name;
			$this->state['mpesa']=$settings->mpesa;
			$this->state['cash']=$settings->cash;
			$this->state['kcb_pinpad']=$settings->kcb_pinpad;
            $this->app_name=$settings->app_name;
            $this->app_env=$settings->app_env;
            $this->app_debug=$settings->app_debug;
            $this->app_url=$settings->app_url;
            $this->db_connection=$settings->db_connection;
            $this->db_host=$settings->db_host;
            $this->db_port=$settings->db_port;
            $this->db_database=$settings->db_database;
            $this->db_username=$settings->db_username;
            $this->db_password=$settings->db_password;
		}else{
			$this->state['print_receipt']=false;
		}

	}

	public function showAddTerminalModal(){
		$this->dispatchBrowserEvent('showNewTerminalModalEvent');
	}

	public function ShowTaxModal(){
        $this->dispatchBrowserEvent('showTaxModalEvent');
    }

    public function AddNewTax(){
        $validatedData = Validator::make(
            [
                'tax_name' => $this->tax_name,
                'percentage' => $this->percentage,
            ],
            [
                'tax_name' => 'required|unique:taxes',
                'percentage' => 'required'
            ]

        )->validate();
        Tax::create([
           'tax_name'=>$this->tax_name,
           'percentage'=>$this->percentage,
        ]);
        $this->tax_name='';
        $this->percentage='';
        $this->updatingTaxMode=false;
        $this->success_creating_tax_msg=true;
        $this->success_updating_tax_msg=false;
    }

    public function ChangeToTaxUpdatingMode($taxId){
        $this->updatingTaxMode=true;
        $this->tax_id=$taxId;
	    $tax=Tax::find($taxId);

	    $this->tax_name=$tax->tax_name;
	    $this->percentage=$tax->percentage;
    }

    public function updateTax(){
        $validatedData = Validator::make(
            [
                'tax_name' => $this->tax_name,
                'percentage' => $this->percentage,
            ],
            [
                'tax_name' => 'required',
                'percentage' => 'required'
            ]

        )->validate();
        $tax=Tax::find($this->tax_id);
        $tax->update([
            'tax_name'=>$this->tax_name,
            'percentage'=>$this->percentage,
        ]);
        $this->tax_name='';
        $this->percentage='';
        $this->updatingTaxMode=false;
        $this->success_creating_tax_msg=false;
        $this->success_updating_tax_msg=true;
    }

	public function saveSettings(){
		$validatedData=Validator::make($this->state,[
			'store_name'=>'required',
			'store_footer_copyright'=>'required',
			'store_address'=>'required',
			'store_phone'=>'required',
			'store_email'=>'required',
			'store_website'=>'required',
		])->validate();

		$settings=GeneralSetting::take(1)->first();
		if (!empty($settings)) {
	            $settings->update([
					'store_footer_copyright'=>$this->state['store_footer_copyright'],
					'store_name'=>$this->state['store_name'],
					'store_address'=>$this->state['store_address'],
					'store_phone'=>$this->state['store_phone'],
					'store_email'=>$this->state['store_email'],
					'store_website'=>$this->state['store_website'],
					'tax_percentage'=> $this->state['tax_percentage'] ?? 0,
					'printer_name'=>$this->state['printer_name'],
					'cash'=>$this->state['cash'],
					'mpesa'=>$this->state['mpesa'],
					'kcb_pinpad'=>$this->state['kcb_pinpad'],
				]);
				if (!empty($this->state['logo'])) {

					$this->state['logo']->store('public/logos');
					$settings->update([
						'logo'=>$this->state['logo']->hashName(),
					]);

				}
            (new LogsService('updated settings' ,'Admin'))->storeLogs();
              $this->dispatchBrowserEvent('settingsUpdated',['message'=>'Settings Updated','type'=>'success']);

        } else {

			GeneralSetting::create([
				'store_footer_copyright'=>$this->state['store_footer_copyright'],
				'store_name'=>$this->state['store_name'],
				'store_address'=>$this->state['store_address'],
				'store_phone'=>$this->state['store_phone'],
				'store_email'=>$this->state['store_email'],
				'store_website'=>$this->state['store_website'],
				'tax_percentage'=>$this->state['tax_percentage'] ?? 0,
				'printer_name'=>$this->state['printer_name'],
				'cash'=>$this->state['cash'],
				'mpesa'=>$this->state['mpesa'],
				'kcb_pinpad'=>$this->state['kcb_pinpad'],

			]);
				if (!empty($this->state['logo'])) {
					$settings=GeneralSetting::take(1)->first();
					$this->state['logo']->store('public/logos');
					$settings->update([
						'logo'=>$this->state['logo']->hashName(),
					]);

				}
            (new LogsService('created settings' ,'Admin'))->storeLogs();
			$this->dispatchBrowserEvent('settingsUpdated',['message'=>'Settings Updated','type'=>'success']);

        }

	}



    public function render()
    {
    	if ($this->sorting=="default") {
    		if ($this->search=='') {
    			$terminals=Terminal::latest()->paginate($this->pagesize);
    		} else {
    			$terminals=Terminal::where('mac_address','LIKE','%'.$this->search.'%')->latest()->paginate($this->pagesize);
    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
    			$terminals=Terminal::where('status',1)->paginate($this->pagesize);
    		} else {
    			$terminals=Terminal::where('mac_address','LIKE','%'.$this->search.'%')->where('status',1)->paginate($this->pagesize);
    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
    			$terminals=Terminal::where('status',0)->paginate($this->pagesize);
    		} else {
    			$terminals=Terminal::where('mac_address','LIKE','%'.$this->search.'%')->where('status',0)->paginate($this->pagesize);
    		}

    	}else{
    		$terminals=Terminal::latest()->paginate($this->pagesize);
    	}

    	$count=Terminal::all()->count();
        $tax_details=Tax::all();

        return view('livewire.admin-settings-component',compact(['terminals','count','tax_details']))->layout('layouts.admin');
    }
}
