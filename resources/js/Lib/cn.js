import clsx from 'clsx';

/** Thin shim so components can `import { cn } from '@/Lib/cn'`. */
export function cn(...args) {
    return clsx(...args);
}
