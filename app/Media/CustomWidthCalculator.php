<?php

namespace App\Media;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\ResponsiveImages\WidthCalculator\WidthCalculator;
use Spatie\MediaLibrary\Support\ImageFactory;

class CustomWidthCalculator implements WidthCalculator
{
    public function calculateWidthsFromFile(string $imagePath): Collection
    {
        $image = ImageFactory::load($imagePath);
        $width = $image->getWidth();
        $height = $image->getHeight();
        $fileSize = filesize($imagePath);

        return $this->calculateWidths($fileSize, $width, $height);
    }

    public function calculateWidths(int $fileSize, int $width, int $height): Collection
    {
        // Lebar yang ingin di-generate
        $targetWidths = collect([320, 480, 640, 800, 1200]);

        // Jangan generate width lebih besar dari original
        return $targetWidths->filter(fn($w) => $w <= $width);
    }
}
