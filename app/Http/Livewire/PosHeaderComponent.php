<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Branch;
use App\Models\User;
use Auth;

class PosHeaderComponent extends Component
{
    public $searchProduct;
    public $user;
    public $selectedAttributes;
    public $searchByCode;
    private $searchResults;

    public function mount()
    {
        $this->selectedAttributes = [];
        $this->searchProduct = '';
    }

    public function updatedSearchProduct()
    {
        $this->searchByCode = "";
        $this->selectedAttributes = [];
        $this->searchResults();
    }

    public function updatedSearchByCode()
    {
        $this->searchProduct = "";
        $this->selectedAttributes = [];
    }



    //PRODUCT SEARCH RESULTS USING SEARCHBOX
    public function searchResults()
    {
        if (strlen($this->searchProduct) > 0) {
            $products = Product::with('attributes')
                ->where('name', 'LIKE', '%' . $this->searchProduct . '%')
                ->get(); //can only return 5 results as limit defined in Model relations

            $attributes = array();
            foreach ($products as $key => $product) {

                foreach ($product->attributes as $attr_key => $attr) {
                    $all_attrs = $attr->with('product')->where('product_id', $attr->product_id)->get();
                    foreach ($all_attrs as $key => $somevalue) {
                        if (!in_array($somevalue, $attributes)) {
                            array_push($attributes, $somevalue);
                        }
                    }
                }
            }

            $selected_attr = array_filter($attributes, function ($attribute) {

                return $attribute['branch_id'] === Branch::where('id', Auth::user()->branch_id)->first()->id;
            });
            $this->selectedAttributes = $selected_attr;
        }
    }

    //SEARCH BY CODE
    public function searchResultsByCode()
    {
        $this->searchProduct = "";
        $branch_id = Branch::where('id', Auth::user()->branch_id)->first()->id;

        $req = $this->searchByCode;
        $attribute = ProductsAttribute::where('sku', $req)
            ->where('branch_id', $branch_id)->first();

        if (!$attribute) {
            $this->dispatchBrowserEvent('ProductCodeErrorEvent');
            shell_exec('rundll32 user32.dll,MessageBeep');
        } else {
            $posSession = session()->get('pos');
            $suspended_session = session()->get('suspended_session');
            // GET QTY FROM SESSION BEFORE SEARCH
            $itemQty = 0;
            if ($posSession) {
                foreach ($posSession as $key => $session) {

                    if ($attribute->id == $key) {
                        $itemQty = $session['quantity'];
                    }
                }
            } elseif ($suspended_session) {
                foreach ($suspended_session as $key => $session) {

                    if ($attribute->id == $key) {
                        $itemQty = $session['quantity'];
                    }
                }
            } else {
                $itemQty = 0;
            }


            // END GET QTY FROM SESSION BEFORE SEARCH


            if ($attribute->stock <= $itemQty) {
                $this->dispatchBrowserEvent('OutOfStockEvent');
                shell_exec('rundll32 user32.dll,MessageBeep');
            } else {

                $this->emit('AddToOrderEvent', $attribute->id);
                $this->dispatchBrowserEvent('ScrollProductsTableToBottomEvent');
                $this->selectedAttributes = [];
            }
        }
        $this->searchByCode = "";
    }


    //SELECT ATTRIBUTE
    public function selectAttribute($attrId, $stock)
    {
        if ($stock == 0) {
            $this->dispatchBrowserEvent('OutOfStockEvent');
            shell_exec('rundll32 user32.dll,MessageBeep');
            $this->selectedAttributes = [];
            return false;
        }
        $this->emit('AddToOrderEvent', $attrId);
        $this->dispatchBrowserEvent("ProductSelectedModalEvent");
        $this->dispatchBrowserEvent('ScrollProductsTableToBottomEvent');
        $this->searchProduct = "";
        $this->selectedAttributes = [];
    }

    public function ShowSearchModal()
    {

        $this->dispatchBrowserEvent('ShowSearchModalEvent');
        $this->searchProduct = "";
        $this->selectedAttributes = [];
        $this->searchResults();
    }

    public function MessageAlertEvent($type, $message)
    {
        $this->dispatchBrowserEvent('MessageAlertEvent', ['type' => $type, 'message' => $message]);
    }
    public function render()
    {
        return view('livewire.pos-header-component');
    }
}
