<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ProductXmlService
{
    protected Filesystem $disk;

    protected string $folderExport;

    protected string $documentName;

    public function __construct()
    {
        $this->disk = Storage::disk(config('filesystems.default'));
        $this->folderExport = 'export';
        $this->documentName = 'catalog_export.xml';
    }

    public function createXml($products): void
    {
        $this->createDirectoryIfNotExists();

        $xml = new SimpleXMLElement('<root/>');
        $xml->addChild('created_at', now()->toDateTimeString());

        $productsElement = $xml->addChild('products');
        foreach ($products as $product) {
            $productElement = $productsElement->addChild('product');
            $productElement->addChild('id', (string) $product->id);
            $productElement->addChild('name', $product->name);
            $productElement->addChild('code', $product->code);
            $productElement->addChild('sku_owner', $product->sku_owner);
            $productElement->addChild('description', $product->description);

            $mainImageElement = $productElement->addChild('main_image');
            $mainImageElement->addChild('url', $product->getImagePath());

            $additionalImagesElement = $productElement->addChild('additional_images');
            foreach ($product->images as $image) {
                $additionalImageElement = $additionalImagesElement->addChild('additional_image');
                $additionalImageElement->addChild('id', (string) $image->id);
                $additionalImageElement->addChild('url', $image->getImagePath());
            }

            $categoriesElement = $productElement->addChild('categories');
            foreach ($product->categories as $category) {
                $categoryElement = $categoriesElement->addChild('category');
                $categoryElement->addChild('id', (string) $category->id);
                $categoryElement->addChild('name', $category->name);

                $parents = $category->ancestors()->get();
                foreach ($parents as $parent) {
                    $parentElement = $categoryElement->addChild('parent_category');
                    $parentElement->addChild('id', (string) $parent->id);
                    $parentElement->addChild('name', $parent->name);
                }
            }


            $productElement->addChild('active', (string) $product->active);
        }

        $xml->asXML($this->disk->path($this->folderExport . '/' . $this->documentName));
    }

    public function createDirectoryIfNotExists(): void
    {
        if (!$this->disk->exists($this->folderExport)) {
            $this->disk->makeDirectory($this->folderExport);
        }
    }

    public function xmlFileExists(): bool
    {
        return $this->disk->exists($this->folderExport . '/' . $this->documentName);
    }

    public function getXmlFilePath()
    {
        if ($this->xmlFileExists()) {
            return $this->disk->url($this->folderExport . '/' . $this->documentName);
        }

        return false;
    }
}
