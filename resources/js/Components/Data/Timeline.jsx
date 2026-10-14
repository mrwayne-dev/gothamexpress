import { cn } from '@/Lib/cn';

/**
 * Timeline — vertical steps.
 * items: [{ title, timestamp, state: 'completed'|'active'|'pending', notes? }]
 */
export function Timeline({ items = [], className }) {
    return (
        <ol className={cn('ge-timeline', className)}>
            {items.map((item, idx) => (
                <li key={idx} className={cn('ge-timeline__item', item.state && `ge-timeline__item--${item.state}`)}>
                    <span className="ge-timeline__dot" aria-hidden="true" />
                    <div className="ge-timeline__title">{item.title}</div>
                    {item.timestamp ? <div className="ge-timeline__time">{item.timestamp}</div> : null}
                    {item.notes ? <div className="ge-timeline__notes">{item.notes}</div> : null}
                </li>
            ))}
        </ol>
    );
}
