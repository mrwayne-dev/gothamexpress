import { CaretDown } from '@phosphor-icons/react';

/**
 * FAQ accordion built on <details>/<summary> — zero JS, keyboard-accessible,
 * works with scrolling, URL-hash deep-links naturally.
 *
 * items: [{ q: 'Question?', a: 'Answer markdown-free.' }]
 */
export function Accordion({ items = [], defaultOpenIndex = 0 }) {
    return (
        <div className="ge-faq__list">
            {items.map((item, i) => (
                <details
                    key={i}
                    className="ge-faq__item"
                    open={i === defaultOpenIndex || undefined}
                >
                    <summary className="ge-faq__q">
                        <span>{item.q}</span>
                        <span className="ge-faq__chevron"><CaretDown weight="bold" /></span>
                    </summary>
                    <div className="ge-faq__a">{item.a}</div>
                </details>
            ))}
        </div>
    );
}
