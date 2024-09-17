<?php

namespace App\Http\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\DB;

class Products extends Component
{
    public $products = [];
    public $manufacturers = [];
    public $editingProduct = [];
    public $selectedManufacturer = null;
    public $showModal = false;
    public $productId;

    public function mount()
    {
        $this->fetchProducts(); 
        $this->manufacturers = Manufacturer::all(); 
    }

    public function fetchProducts()
    {

        $client = new Client();

        try {
            $response = $client->get('https://test.oscloud.at/store-api/product', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'sw-access-key' => 'b82152a21c824a5fa10dd87f60a647ce',
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            $this->products = array_filter($data['elements'], function ($product) {
                return $product['active'];  // Filter only active products
            });

        } catch (\Exception $e) {
            dd('Error fetching products: ' . $e->getMessage());
        }
    }

    public function openModal($productId)
    {
        $this->productId = $productId;
        $this->editingProduct = collect($this->products)->firstWhere('id', $productId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function saveChanges()
    {
        $client = new Client();

        try {
            $response = $client->patch('https://test.oscloud.at/api/_action/sync', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                ],
                'json' => [
                    'data' => [
                        'entity' => 'product',
                        'action' => 'update',
                        'payload' => [
                            [
                                'id' => $this->editingProduct['id'],
                                'price' => $this->editingProduct['price'],
                                'stock' => $this->editingProduct['stock'],
                            ],
                        ],
                    ],
                ],
            ]);

            $this->updateProductInLocalData($this->editingProduct['id'], $this->editingProduct);
            $this->closeModal();

        } catch (\Exception $e) {
            dd('Error updating product: ' . $e->getMessage());
        }

        $this->saveManufacturerRelation($this->productId, $this->selectedManufacturer);
    }

    private function updateProductInLocalData($productId, $updatedData)
    {
        foreach ($this->products as &$product) {
            if ($product['id'] == $productId) {
                $product['price'] = $updatedData['price'];
                $product['stock'] = $updatedData['stock'];
            }
        }
    }

    private function saveManufacturerRelation($productId, $manufacturerId)
    {
        if ($manufacturerId) {
            DB::table('manufacturer_products')->updateOrInsert(
                ['product_id' => $productId],
                ['manufacturer_id' => $manufacturerId]
            );
        }
    }

    public function getAccessToken()
    {
        $client = new Client();

        try {
            $response = $client->post('https://test.oscloud.at/api/oauth/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'SWIAQJVIVM16D1JOUE1HVMRONA', 
                    'client_secret' => 'aFI3eUxaazRVRkk0Qjl6dlhHbHZzbFhJRUFoSm9yZ2gxOVFmUVE', 
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['access_token'];

        } catch (\Exception $e) {
            dd('Error fetching access token: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.products', [
            'products' => $this->products,
            'manufacturers' => $this->manufacturers,
        ]);
    }
}
