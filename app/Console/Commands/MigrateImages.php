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
    protected $description = 'Migrate existing article images to Media Library.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting image migration...');

        $articles = Article::all();

        foreach ($articles as $article) {
            // Pastikan artikel memiliki URL gambar dan file-nya ada
            if ($article->image_url && File::exists(public_path('storage/' . $article->image_url))) {
                // Tambahkan gambar ke Media Library dari lokasi lama
                $article->addMedia(public_path('storage/' . $article->image_url))
                    ->toMediaCollection('images');
                $this->info("Image for article #{$article->id} migrated successfully.");
            } else {
                $this->warn("No image found for article #{$article->id}, skipping.");
            }
        }

        $this->info('Image migration completed!');

        return Command::SUCCESS;
    }
}