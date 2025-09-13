<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Carbon\Carbon;

class PublishScheduledArticles extends Command
{
    protected $signature = 'articles:publish-scheduled';
    protected $description = 'Publikasikan artikel yang dijadwalkan';

    public function handle()
    {
        $now = Carbon::now();
        $articles = Article::whereNotNull('scheduled_at')
            ->where('is_published', false)
            ->where('scheduled_at', '<=', $now)
            ->get();

        foreach ($articles as $article) {
            $article->update(['is_published' => true]);
            $this->info("Artikel '{$article->title}' telah dipublikasikan.");
        }
    }
}
