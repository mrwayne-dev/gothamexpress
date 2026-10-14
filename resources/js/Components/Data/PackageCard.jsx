import { StatusBadge } from '@/Components/Primitives/Badge';
import { AmountDisplay } from '@/Components/Feedback/AmountDisplay';
import { cn } from '@/Lib/cn';

export function PackageCard({ pkg, actions, className, onClick }) {
    return (
        <article className={cn('ge-pkg-card', className)} onClick={onClick}>
            <div className="ge-pkg-card__header">
                <span className="ge-pkg-card__tracking">{pkg.tracking_id}</span>
                <StatusBadge status={pkg.status} />
            </div>
            <div className="ge-pkg-card__name">{pkg.package_name}</div>
            <div className="ge-pkg-card__meta">
                To: {pkg.firstname} {pkg.lastname} · {pkg.location}
            </div>
            <div className="ge-pkg-card__footer">
                <AmountDisplay value={pkg.amount} />
                <StatusBadge status={pkg.payment_status} />
            </div>
            {actions ? <div className="cluster-sm">{actions}</div> : null}
        </article>
    );
}
