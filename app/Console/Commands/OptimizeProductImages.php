<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class OptimizeProductImages extends Command
{
    protected $signature = 'images:optimize-products';
    protected $description = 'Optimize all product images in storage/app/public/products';

    public function handle()
    {
        $dir = storage_path('app/public/products');

        if (!is_dir($dir)) {
            $this->error("❌ Directory not found: {$dir}");
            return;
        }

        $files = glob($dir . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);

        if (empty($files)) {
            $this->info('ℹ️ No product images found to optimize.');
            return;
        }

        foreach ($files as $file) {
            ImageOptimizer::optimize($file);
            $this->info("✅ Optimized: " . basename($file));
        }

        $this->info('🎉 All product images optimized successfully!');
    }
}
