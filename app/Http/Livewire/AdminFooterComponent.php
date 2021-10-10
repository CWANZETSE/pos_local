<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\GeneralSetting;

class AdminFooterComponent extends Component
{
    public function render()
    {
    	$settingsCount=GeneralSetting::all()->count();
    	if ($settingsCount==0) {
    		$settings=[];
    	} else {
    		$settings=GeneralSetting::first();
    	}
    	
        return view('livewire.admin-footer-component',compact('settings'));
    }
}
