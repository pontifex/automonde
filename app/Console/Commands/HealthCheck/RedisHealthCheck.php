<?php

namespace App\Console\Commands\HealthCheck;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisHealthCheck extends Command
{
    protected $signature = 'health-check/redis';
    protected $description = 'Checks health of Redis instance(s)';

    public function handle(): void
    {
        try {
            Redis::connection();
        } catch (\Exception) {
            $this->error('Redis health: FAIL');
            return;
        }

        $this->comment('Redis health: OK');
    }
}
