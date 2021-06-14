<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Exception;
use Illuminate\Console\Command;

class ElasticSearchIndexRecreate extends Command
{
    private const INDICES_DIR = 'elasticsearch/indices';

    protected $signature = 'elasticsearch:index:recreate {index-name}';
    protected $description = 'Manage ElasticSearch indices';

    public function __construct(private Client $client)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->deleteIndex();
        $this->createIndex();
    }

    private function deleteIndex()
    {
        $deleteParams = [
            'index' => $this->argument('index-name'),
        ];

        try {
            $this->client->indices()->delete($deleteParams);

            $this->comment(
                sprintf(
                    'Index %s deleted',
                    $this->argument('index-name'),
                )
            );
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return;
        }
    }

    private function createIndex()
    {
        $indexFile = sprintf(
            '%s/%s.php',
            self::INDICES_DIR,
            $this->argument('index-name')
        );

        if (! is_readable($indexFile)) {
            $this->error('Index does not exist');
            return;
        }

        $indexParams = require($indexFile);

        try {
            $this->client->indices()->create($indexParams);
            $this->comment(
                sprintf(
                    'Index %s created',
                    $this->argument('index-name'),
                )
            );
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return;
        }
    }
}
