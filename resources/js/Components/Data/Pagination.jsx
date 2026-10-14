import { CaretLeft, CaretRight } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

/** Pagination driven by Laravel paginator meta: { current_page, last_page, per_page, total } */
export function Pagination({ meta, onPage, className }) {
    if (!meta || meta.last_page <= 1) return null;
    const current = meta.current_page;
    const last = meta.last_page;

    const pages = buildPageList(current, last);

    return (
        <div className={cn('ge-pagination', className)}>
            <span>
                Page <strong>{current}</strong> of {last}{meta.total != null ? ` · ${meta.total.toLocaleString()} total` : null}
            </span>
            <div className="ge-pagination__pages">
                <button
                    type="button"
                    className="ge-pagination__btn"
                    onClick={() => onPage?.(current - 1)}
                    disabled={current <= 1}
                    aria-label="Previous page"
                >
                    <CaretLeft weight="bold" />
                </button>
                {pages.map((p, i) =>
                    p === '…' ? (
                        <span key={`e-${i}`} className="ge-pagination__btn" aria-hidden="true">…</span>
                    ) : (
                        <button
                            key={p}
                            type="button"
                            className={cn('ge-pagination__btn', p === current && 'ge-pagination__btn--active')}
                            onClick={() => onPage?.(p)}
                        >
                            {p}
                        </button>
                    ),
                )}
                <button
                    type="button"
                    className="ge-pagination__btn"
                    onClick={() => onPage?.(current + 1)}
                    disabled={current >= last}
                    aria-label="Next page"
                >
                    <CaretRight weight="bold" />
                </button>
            </div>
        </div>
    );
}

function buildPageList(current, last) {
    const pages = new Set([1, last, current, current - 1, current + 1]);
    const list = [...pages].filter((p) => p >= 1 && p <= last).sort((a, b) => a - b);
    const out = [];
    for (let i = 0; i < list.length; i++) {
        out.push(list[i]);
        if (i < list.length - 1 && list[i + 1] - list[i] > 1) out.push('…');
    }
    return out;
}
