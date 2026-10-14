<?php

namespace Database\Factories;

use App\Models\WalletAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WalletAddress> */
class WalletAddressFactory extends Factory
{
    public function definition(): array
    {
        $currencies = [
            ['label' => 'Tether (TRON)', 'currency' => 'USDT', 'network' => 'TRC20'],
            ['label' => 'Bitcoin', 'currency' => 'BTC', 'network' => 'BTC'],
            ['label' => 'Ethereum', 'currency' => 'ETH', 'network' => 'ERC20'],
        ];
        $pick = fake()->randomElement($currencies);

        return [
            'label' => $pick['label'],
            'currency' => $pick['currency'],
            'network' => $pick['network'],
            'address' => bin2hex(random_bytes(20)),
            'is_active' => true,
            'display_order' => 0,
        ];
    }
}
