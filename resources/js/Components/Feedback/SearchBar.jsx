import { MagnifyingGlass, X } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

export function SearchBar({ value = '', onChange, placeholder = 'Search…', className }) {
    return (
        <div className={cn('ge-search', className)}>
            <span className="ge-search__icon">
                <MagnifyingGlass weight="bold" />
            </span>
            <input
                type="search"
                className="ge-search__input"
                value={value}
                onChange={(e) => onChange?.(e.target.value)}
                placeholder={placeholder}
            />
            {value ? (
                <button
                    type="button"
                    className="ge-search__clear"
                    onClick={() => onChange?.('')}
                    aria-label="Clear search"
                >
                    <X weight="bold" size={14} />
                </button>
            ) : null}
        </div>
    );
}
