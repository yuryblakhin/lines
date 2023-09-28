<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ProductXmlService;
use Exception;
use Illuminate\Console\Command;

class GenerateXmlCommand extends Command
{
    protected $signature = 'generate:xml';

    protected $description = 'Generate XML file';

    protected ProductXmlService $productXmlService;

    public function __construct(
        ProductXmlService $productXmlService
    ) {
        parent::__construct();
        $this->productXmlService = $productXmlService;
    }

    public function handle(): void
    {
        try {
            $products = Product::with(['images', 'categories'])->get();
            $this->productXmlService->createXml($products);

            $this->info('XML file exported successfully.');
        } catch (Exception $e) {
            $this->error('Error exporting XML file: ' . $e->getMessage());
        }
    }
}
