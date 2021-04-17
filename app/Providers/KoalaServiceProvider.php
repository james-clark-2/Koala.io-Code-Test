<?php

namespace App\Providers;

use App\Services\Contracts\DataTranslatorInterface;
use App\Services\Contracts\FeedReaderInterface;
use App\Services\FeedReaders\XmlFeedReader;
use App\Services\FeedReaders\JsonFeedReader;
use App\Services\Parsers\JsonLocationFeedParser;
use App\Services\Parsers\FeedParser;
use App\Services\Parsers\XmlLocationFeedParser;
use App\Services\Translators\Location\ConfigurableLocationDataTranslator;
use App\Services\Translators\Location\JsonLocationDataTranslator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class KoalaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JsonLocationFeedParser::class, fn() =>
            new JsonLocationFeedParser(
                app(JsonFeedReader::class),
                app()->make(ConfigurableLocationDataTranslator::class, ['configuration' => Config::get('feeds.locations.json')])
            )
        );

        $this->app->bind(XmlLocationFeedParser::class, fn() =>
            new XmlLocationFeedParser(
                app(XmlFeedReader::class),
                app()->make(ConfigurableLocationDataTranslator::class, ['configuration' => Config::get('feeds.locations.xml')])
            )
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
