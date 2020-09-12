<?php

namespace App\Console\Commands;

use App\Crawler\Crawler;
use Illuminate\Console\Command;

class TestCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command test crawl';

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
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $crawler = new Crawler();
        
        $group_id = '1065116420221723';
        
        $token = "EAAD4tyD9cRABAFZBdw5ZBL3rZCHZBZCt9ECxHWPq49p3ZCiDkxoHfG7uYaZBDosUxWmZBMacqtb2LHqw9vRRMaEL5e8DMEgJF01tHuRMLWZCE0uxlenYzZA4lzjWk1jLOOzOmu5ltZA47Q730wkWI2teaHSJ3XzMSi4oRVj9NxbqeyDMgZDZD";
        
        foreach ($crawler->getFeedOfGroup($group_id, $token, true) as $feed ) {
            $this->warn('Feed:');
            $this->info($feed->message);
            $comments = [];
            foreach ($crawler->getComment($feed->id, $token, true) as $comment) {
                $this->warn('Comment:'. $comment->message);
                $comments[] = $comment;
            }
            $feed->comments = $comments;
        }
    }
}
