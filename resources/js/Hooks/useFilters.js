import { router } from '@inertiajs/react';
import { useCallback, useEffect, useState } from 'react';
import { useDebounce } from './useDebounce';

/**
 * URL-synced filter object.
 * Changes debounce for 300ms before firing an Inertia visit.
 */
export function useFilters(initial = {}, { debounceMs = 300 } = {}) {
    const [filters, setFilters] = useState(initial);
    const debounced = useDebounce(filters, debounceMs);

    useEffect(() => {
        const url = new URL(window.location.href);
        Object.entries(debounced).forEach(([k, v]) => {
            if (v === '' || v == null) url.searchParams.delete(k);
            else url.searchParams.set(k, String(v));
        });
        url.searchParams.delete('page');
        router.visit(url.pathname + url.search, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, [debounced]);

    const set = useCallback((key, value) => setFilters((f) => ({ ...f, [key]: value })), []);
    const reset = useCallback(() => setFilters(initial), [initial]);

    return { filters, set, reset, patch: setFilters };
}
