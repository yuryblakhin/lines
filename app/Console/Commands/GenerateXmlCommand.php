<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleXMLElement;

class GenerateXmlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $xml = new SimpleXMLElement('<products></products>');

        foreach ($products as $product) {
            $productElement = $xml->addChild('product');

            $productElement->addChild('id', $product->id);
            $productElement->addChild('name', $product->name);
            $productElement->addChild('code', $product->code);
            $productElement->addChild('sku', $product->sku);
            $productElement->addChild('description', $product->description);
            $carouselElement = $productElement->addChild('carousel');

            if ($product->image_path) {
                $carouselItemElement = $carouselElement->addChild('carousel-item');
                $carouselItemElement->addChild('img', $product->getImagePath())->addAttribute('class', 'd-block w-100')->addAttribute('alt', $product->name);
            }

            foreach ($product->images as $image) {
                $carouselItemElement = $carouselElement->addChild('carousel-item');
                $carouselItemElement->addChild('img', $image->getImagePath())->addAttribute('class', 'd-block w-100')->addAttribute('alt', 'Additional Image');
            }

            if ($product->image_path || $product->images->count() > 1) {
                $carouselElement->addChild('button', 'Previous')->addAttribute('class', 'carousel-control-prev')->addAttribute('type', 'button')->addAttribute('data-bs-target', '#productCarusel')->addAttribute('data-bs-slide', 'prev');
                $carouselElement->addChild('button', 'Next')->addAttribute('class', 'carousel-control-next')->addAttribute('type', 'button')->addAttribute('data-bs-target', '#productCarusel')->addAttribute('data-bs-slide', 'next');
            }

            $warehousesElement = $productElement->addChild('warehouses');
            foreach ($warehouses as $warehouse) {
                $warehouseElement = $warehousesElement->addChild('warehouse');
                $warehouseElement->addChild('name', $warehouse->name);

                $pivot = $warehouse->products->find($product) ? $warehouse->products->find($product)->pivot : null;

                $formElement = $warehouseElement->addChild('form');
                $formElement->addAttribute('method', 'POST')->addAttribute('action', route('api.product.warehouse.update', ['product' => $product->id, 'warehouse' => $warehouse->id], false));

                $formElement->addChild('input', null)->addAttribute('type', 'number')->addAttribute('class', 'form-control form-control-sm')->addAttribute('name', 'price')->addAttribute('value', $pivot ? $pivot->price : 0);
                $formElement->addChild('input', null)->addAttribute('type', 'number')->addAttribute('class', 'form-control form-control-sm')->addAttribute('name', 'quantity')->addAttribute('value', $pivot ? $pivot->quantity : 0);

                $formElement->addChild('button', 'Update')->addAttribute('type', 'submit')->addAttribute('class', 'btn btn-outline-primary btn-sm');
            }
        }

        $xmlString = $xml->asXML();
        file_put_contents('products.xml', $xmlString);
        $this->info('XML file generated successfully!');
    }
}
