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
            ->where('status', 'scheduled')
            ->where('scheduled_at', '<=', $now)
            ->get();

        foreach ($articles as $article) {
            $article->update(['status' => "published", 'scheduled_at' => now()]);
            $this->info("Artikel '{$article->title}' telah dipublikasikan.");
        }
    }
}
