import { router } from '@inertiajs/react';
import { useCallback, useEffect, useRef, useState } from 'react';

/**
 * Reload the current Inertia page on an interval.
 * Pauses when the tab is hidden.
 *
 * @param {object} opts
 * @param {string[]} [opts.only]    – Inertia partial-reload keys
 * @param {number}   [opts.interval=30000]
 * @param {boolean}  [opts.enabled=true]
 */
export function usePolling({ only, interval = 30000, enabled = true } = {}) {
    const [running, setRunning] = useState(enabled);
    const timer = useRef(null);

    const tick = useCallback(() => {
        if (document.hidden) return;
        router.reload({ only, preserveScroll: true, preserveState: true });
    }, [only]);

    useEffect(() => {
        if (!running) return;
        timer.current = setInterval(tick, interval);
        const onVis = () => {
            if (!document.hidden) tick();
        };
        document.addEventListener('visibilitychange', onVis);
        return () => {
            if (timer.current) clearInterval(timer.current);
            document.removeEventListener('visibilitychange', onVis);
        };
    }, [running, interval, tick]);

    return {
        running,
        start: () => setRunning(true),
        stop: () => setRunning(false),
    };
}
