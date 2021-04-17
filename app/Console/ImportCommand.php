<?php

namespace App\Console;

use App\Models\Location;
use Illuminate\Console\Command;
use App\Services\Contracts\LocationFeedParserInterface;
use App\Services\Parsers\JsonLocationFeedParser;
use App\Services\Parsers\FeedParser;
use App\Services\Parsers\XmlLocationFeedParser;

class ImportCommand extends Command
{
    protected $signature = 'koala:import {files* : One or more files to import}';

    protected $description = 'Imports data provided for the Koala code test.';

    /**
     * @var LocationFeedParserInterface[]
     */
    protected array $locationFeedParsers;

    public function handle(): void
    {
        foreach ($this->argument('files') as $filePath) {
            $this->info('Importing '.$filePath);

            $locations = $this->parserBasedOnExtension($filePath)->parse($filePath);

            $locations->each(
                fn (Location $location) =>
                    $location->updateOrCreate(
                        ['feed_id' => $location->feed_id],
                        $location->getAttributes()
                    )
            );
        }
    }

    protected function parserBasedOnExtension(string $path): ?FeedParser
    {
        $pathParts = explode('.', $path);
        $extension = end($pathParts);

        return match ($extension) {
            'json' => app(JsonLocationFeedParser::class),
            'xml' => app(XmlLocationFeedParser::class),
            default => null
        };
    }
}
