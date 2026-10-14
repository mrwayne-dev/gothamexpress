<?php

namespace Database\Seeders;

use App\Models\WalletAddress;
use Illuminate\Database\Seeder;

class WalletAddressSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            // Placeholder addresses — rotate before any production use.
            ['label' => 'Tether (TRON)',  'currency' => 'USDT', 'network' => 'TRC20', 'address' => 'TXYZabcdef1234567890PLACEHOLDER', 'display_order' => 1],
            ['label' => 'Bitcoin',        'currency' => 'BTC',  'network' => 'BTC',   'address' => 'bc1qPLACEHOLDERaddressxxxxxxxxxxxxxxxx', 'display_order' => 2],
            ['label' => 'Ethereum',       'currency' => 'ETH',  'network' => 'ERC20', 'address' => '0xPLACEHOLDERaddress00000000000000000000', 'display_order' => 3],
        ];

        foreach ($samples as $data) {
            WalletAddress::updateOrCreate(
                ['currency' => $data['currency'], 'network' => $data['network']],
                $data + ['is_active' => true],
            );
        }
    }
}
