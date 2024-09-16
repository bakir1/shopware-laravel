<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;

class Products extends Component
{
    public $products = [];

    public function mount()
    {
        $client = new Client();
        $response = $client->get('https://test.oscould.at/store-api/product', [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $this->products = $data['elements'];
    }

    public function render()
    {
        return view('livewire.products', ['products' => $this->products]);
    }
}
