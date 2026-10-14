import { StatusBadge } from '@/Components/Primitives/Badge';
import { AmountDisplay } from '@/Components/Feedback/AmountDisplay';
import { CopyButton } from '@/Components/Feedback/CopyButton';

/**
 * Pre-composed table cells for a transaction row.
 * Pass the row object; render inside your own <tr> or let DataTable renderCell call this.
 */
export function TransactionRow({ tx }) {
    return (
        <tr>
            <td className="ge-tx-id" data-label="Payment ID">
                {tx.payment_id ? (
                    <span className="cluster-sm">
                        <span>{tx.payment_id.slice(0, 10)}…</span>
                        <CopyButton value={tx.payment_id} />
                    </span>
                ) : '—'}
            </td>
            <td data-label="Email">{tx.payer_email}</td>
            <td data-label="Amount"><AmountDisplay value={tx.amount} currency={tx.currency || 'USD'} /></td>
            <td data-label="Method">{tx.payment_method || '—'}</td>
            <td data-label="Status"><StatusBadge status={tx.payment_status} /></td>
            <td data-label="Date">{tx.created_at ? new Date(tx.created_at).toLocaleDateString() : '—'}</td>
        </tr>
    );
}
