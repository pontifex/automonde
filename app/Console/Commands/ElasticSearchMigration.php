<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;
use Illuminate\Console\Command;

class ElasticSearchMigration extends Command
{
    private const INDICES_DIR = 'elasticsearch/indices';

    protected $signature = 'elasticsearch:index:create {index-name}';
    protected $description = 'Manage ElasticSearch indices';

    public function handle(): void
    {
        $client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts(
                [
                    sprintf(
                        '%s:%d',
                        env('ELASTICSEARCH_HOST'),
                        env('ELASTICSEARCH_HOST_HTTP_PORT')
                    )
                ]
            )->build();

        $this->deleteIndex($client);
        $this->createIndex($client);
    }

    private function deleteIndex(Client $client)
    {
        $deleteParams = [
            'index' => $this->argument('index-name'),
        ];

        try {
            $client->indices()->delete($deleteParams);

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

    private function createIndex(Client $client)
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
            $client->indices()->create($indexParams);
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
