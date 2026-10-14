import { router } from '@inertiajs/react';
import { useCallback } from 'react';

export function usePagination(meta) {
    const current = meta?.current_page || 1;
    const last = meta?.last_page || 1;
    const perPage = meta?.per_page || 25;

    const goTo = useCallback((page) => {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        router.visit(url.pathname + url.search, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, []);

    const setPerPage = useCallback((n) => {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', n);
        url.searchParams.delete('page');
        router.visit(url.pathname + url.search, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, []);

    return {
        current,
        last,
        perPage,
        goTo,
        setPerPage,
        prev: () => goTo(Math.max(1, current - 1)),
        next: () => goTo(Math.min(last, current + 1)),
    };
}
