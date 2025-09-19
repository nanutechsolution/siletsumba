<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing article images from URL to Media Library with WebP and responsive images.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting image migration from URL...');

        $articles = Article::whereNotNull('image_url')->get();

        foreach ($articles as $article) {
            $imageUrl = $article->image_url;

            if (!$imageUrl) {
                continue;
            }

            $fileName = basename($imageUrl); // ambil nama file dari URL
            $localFolder = public_path('articles');
            $localPath = $localFolder . '/' . $fileName;

            // Pastikan folder ada
            if (!File::exists($localFolder)) {
                File::makeDirectory($localFolder, 0755, true);
            }

            // Download file jika belum ada
            if (!File::exists($localPath)) {
                try {
                    file_put_contents($localPath, file_get_contents($imageUrl));
                    $this->info("Downloaded image for article #{$article->id}");
                } catch (\Exception $e) {
                    $this->warn("Failed to download image for article #{$article->id}: " . $e->getMessage());
                    continue;
                }
            }

            // Skip jika sudah ada media
            if ($article->hasMedia('images')) {
                $this->info("Article #{$article->id} already has media, skipping.");
                continue;
            }

            // Tambahkan ke Media Library
            $article->addMedia($localPath)
                ->preservingOriginal()
                ->toMediaCollection('images');

            $this->info("Image for article #{$article->id} migrated successfully.");
        }

        $this->info('Image migration completed!');

        return Command::SUCCESS;
    }
}