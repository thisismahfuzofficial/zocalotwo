<?php

namespace App\Livewire;

use App\Models\Extra;
use Livewire\Component;
use Cart as CartFacade;

class Cart extends Component
{
    public $extras;

    public const CHOPSTICK = 4;

    public  $extraBucket = [];
    public  $extraPrice = ['discountedItem' => 0];

    public $restuarant;
    public $cartForExtras = ['totalQty' => 0, 'chopstickQty' => 0];
    public $total = 0;
    public function mount()
    {

        $this->extras =  Extra::latest()->where('type', 'cart')->get();
        foreach ($this->extras as $extra) {

            $this->extraBucket[$extra->id] = ['model' => $extra, 'qty' => CartFacade::get('extra_' . $extra->id)['quantity'] ?? 0, 'unit' => $extra->price];
            if ($extra->id == $this::CHOPSTICK) {
                $this->extraPrice[$extra->id] = ['subtotal' => 0, 'discount' => $extra->price * 15, 'total' => 0];
            } else {
                $this->extraPrice[$extra->id] = ['subtotal' => 0, 'discount' => 0, 'total' => 0];
            }
            // $this->cartForExtras[$extra->id] = ['qty' => 0, 'unit' => $extra->price, 'total' => 0];
        }
        $this->total =  CartFacade::getTotal();
        $this->restuarant = CartFacade::getContent()->first()['attributes']['restaurent'];
        $this->calculatePrice();
    }

    public function addExtra($id)
    {
        ++$this->extraBucket[$id]['qty'];
        $this->calculatePrice();
    }
    public function removeExtra($id)
    {
        if ($this->extraBucket[$id]['qty'] > 0 == false) return;
        --$this->extraBucket[$id]['qty'];
        $this->calculatePrice();
    }


    public function calculatePrice()
    {

        $bucket = $this->extraBucket;
        unset($bucket[$this::CHOPSTICK]);

        $total_items = collect($bucket)->map(fn($extra) => $extra['qty'])->sum();

        $freeItems = floor(round($this->total) / 10);
        if ($total_items <= $freeItems) {
            $this->extraPrice['discountedItem'] = 0;
        }

        foreach ($this->extraBucket as $id => $data) {

            $this->extraPrice[$id]['subtotal'] = $data['unit'] * $data['qty'];
            $this->extraPrice[$id]['discount'] =  $this->extraPrice[$id]['discount'];
            if ($id == $this::CHOPSTICK) {

                $this->extraPrice[$id]['total'] = $this->extraPrice[$id]['subtotal'] - $this->extraPrice[$id]['discount'];

                if ($this->extraPrice[$id]['total'] < 0) {
                    $this->extraPrice[$id]['total'] = 0;
                }
            } else {

                if ($data['qty'] > 0 && $data['qty'] <= $freeItems && $this->extraPrice['discountedItem'] < $freeItems) {
                    $this->extraPrice[$id]['discount'] = $data['unit'] * $data['qty'];
                    $this->extraPrice['discountedItem'] += $data['qty'];
                }
                $this->extraPrice[$id]['total'] = setMinValue($this->extraPrice[$id]['subtotal'] - $this->extraPrice[$id]['discount'], 0);
            }


            CartFacade::remove('extra_' . $id);
            if ($data['qty'] > 0) {

                CartFacade::add([
                    'id' => 'extra_' . $id,
                    'name' => $data['model']->name,
                    'price' => $this->extraPrice[$id]['total'] / $data['qty'],
                    'quantity' => $data['qty'],
                    'associatedModel' => $data['model'],
                    'attributes' => [
                        'restaurent' => $this->restuarant,
                        'extra' => $data['model'],
                        'tax' => $data['model']->tax,
                    ]
                ]);
            }
        }
    }


    public function render()
    {
        return view('livewire.cart');
    }
}
