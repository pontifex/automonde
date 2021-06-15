<?php

namespace App\Console\Commands;

use App\Indexers\IIndexer;
use Exception;
use Illuminate\Console\Command;

class ElasticSearchProductsIndexing extends Command
{
    protected $signature = 'elasticsearch:indexing:products';
    protected $description = 'Indexing ElasticSearch Products';

    public function __construct(
        private IIndexer $indexer
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $total = $this->indexer->index();
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $this->comment(
            sprintf('Parsed %d', $total)
        );
    }
}
