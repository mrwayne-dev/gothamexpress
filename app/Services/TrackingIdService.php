<?php

namespace App\Services;

use App\Models\Package;
use RuntimeException;

class TrackingIdService
{
    public function generate(int $maxAttempts = 10): string
    {
        $prefix = (string) config('gotham.tracking_id.prefix', 'GTX-');
        $bytes = (int) config('gotham.tracking_id.random_bytes', 4);

        for ($i = 0; $i < $maxAttempts; $i++) {
            $candidate = $prefix . strtoupper(bin2hex(random_bytes($bytes)));
            if (! Package::where('tracking_id', $candidate)->exists()) {
                return $candidate;
            }
        }

        throw new RuntimeException('Unable to generate a unique tracking id after '.$maxAttempts.' attempts.');
    }
}
