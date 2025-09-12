<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Class FetchProducts
 * @package App\Console\Commands
 */
class FetchProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch products using API and populate the products table';

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
        $productDataApi = 'https://raw.githubusercontent.com/Sellfy/test-assignment-frontend/refs/heads/master/products.json';
        $response = Http::get($productDataApi);

        if ($response->successful()) {
            $products = $response->json()['data'];

            foreach ($products as $productData) {
                Product::updateOrCreate(
                    [
                        'sku' => $productData['_id'],
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'category' => html_entity_decode($productData['category']),
                        'price' => $productData['price'] / 100,
                        'currency' => $productData['currency'],
                        'url' => $productData['url'],
                        'image_url' => $productData['image_url'],
                    ]
                );
            }

            $this->info('Products successfully imported');
        } else {
            $this->error('Cant fetch products from the API.');
        }
    }
}
