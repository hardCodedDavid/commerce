<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

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
     * @return void
     */
    public function handle(): void
    {
        SitemapGenerator::create(config('app.url'))
            ->getSitemap()
            ->add(Url::create('/')->setPriority(0.5))
            ->add(Url::create('/shop')->addAlternate('/shop/filter')->setPriority(0.5))
            ->add(Url::create('/new-arrivals')->setPriority(0.5))
            ->add(Url::create('/deals')->setPriority(0.5))
            ->add(Url::create('/top-selling')->setPriority(0.5))
            ->add(Url::create('/faqs')->setPriority(0.5))
            ->writeToFile(public_path('sitemap.xml'));
    }
}
