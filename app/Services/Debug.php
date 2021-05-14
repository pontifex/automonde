<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait Debug
{
    public function debug($msg): void
    {
        $isDebugEnabled = env('APP_DEBUG');

        if (! $isDebugEnabled) {
            return;
        }

        if (null !== $msg) {
            $msg = json_encode($msg);
        }

        Log::debug($msg);
    }

    public function debugException(\Exception $e): void
    {
        $isDebugEnabled = env('APP_DEBUG');

        if (! $isDebugEnabled) {
            return;
        }

        Log::debug(
            sprintf(
                '%s happened in file %s line %d at %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine(),
                Carbon::now()->format('Y-m-d H:i:s')
            )
        );
    }
}
