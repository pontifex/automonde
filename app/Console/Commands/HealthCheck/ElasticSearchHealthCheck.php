<?php

namespace App\Console\Commands\HealthCheck;

use Elasticsearch\Client;
use Illuminate\Console\Command;

class ElasticSearchHealthCheck extends Command
{
    protected $signature = 'health-check/elasticsearch';
    protected $description = 'Checks health of ElasticSearch instance(s)';

    public function __construct(private Client $client)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $this->client->ping();
        } catch (\Exception) {
            $this->error('ElasticSearch health: FAIL');
            return;
        }

        $this->comment('ElasticSearch health: OK');
    }
}
