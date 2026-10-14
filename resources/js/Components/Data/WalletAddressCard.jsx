import { CurrencyBtc, CurrencyCircleDollar, CurrencyEth } from '@phosphor-icons/react';
import { CopyButton } from '@/Components/Feedback/CopyButton';
import { cn } from '@/Lib/cn';

const ICONS = {
    BTC: CurrencyBtc,
    ETH: CurrencyEth,
    USDT: CurrencyCircleDollar,
};

export function WalletAddressCard({ wallet, className }) {
    const Icon = ICONS[(wallet.currency || '').toUpperCase()] || CurrencyCircleDollar;
    return (
        <div className={cn('ge-wallet', className)}>
            <div className="ge-wallet__head">
                <Icon weight="bold" size={20} />
                <span className="ge-wallet__currency">{wallet.currency}</span>
                {wallet.network ? <span className="ge-wallet__network">{wallet.network}</span> : null}
                {wallet.label ? <span className="text-muted text-sm">{wallet.label}</span> : null}
            </div>
            <div className="ge-wallet__address" title={wallet.address}>{wallet.address}</div>
            <div className="ge-wallet__actions">
                <CopyButton value={wallet.address} label="Copy address" />
            </div>
        </div>
    );
}
