/**
 * Shared Framer Motion variants + helpers.
 *
 * Import pattern:
 *   import { motion, AnimatePresence } from 'motion/react';
 *   import { fadeInUp, staggerParent, wordStagger } from '@/Lib/motion';
 *
 * The goal is one vocabulary across the whole site so entry / scroll / state
 * animations feel like they came from the same hand.
 */

export const EASE = [0.22, 1, 0.36, 1]; // cubic — fast start, slow finish

/* -------- Entry: fade in with a lift ------------------------------- */
export const fadeIn = {
    hidden: { opacity: 0 },
    show: { opacity: 1, transition: { duration: 0.5, ease: EASE } },
};

export const fadeInUp = {
    hidden: { opacity: 0, y: 14 },
    show: { opacity: 1, y: 0, transition: { duration: 0.55, ease: EASE } },
};

export const fadeInUpStrong = {
    hidden: { opacity: 0, y: 24 },
    show: { opacity: 1, y: 0, transition: { duration: 0.65, ease: EASE } },
};

/* -------- Stagger parents ------------------------------------------ */
export const staggerParent = (stagger = 0.08, delayChildren = 0.1) => ({
    hidden: {},
    show: {
        transition: { staggerChildren: stagger, delayChildren },
    },
});

/* -------- Word-stagger for headline reveal (feels like typewriting) - */
export const wordStagger = {
    hidden: {},
    show: {
        transition: { staggerChildren: 0.045, delayChildren: 0.05 },
    },
};

export const wordItem = {
    hidden: { opacity: 0, y: '0.4em' },
    show: { opacity: 1, y: 0, transition: { duration: 0.55, ease: EASE } },
};

/* -------- Industry-switch helpers (AnimatePresence mode='wait') ---- */
export const swapOut = {
    initial: { opacity: 0, y: 10 },
    animate: { opacity: 1, y: 0, transition: { duration: 0.45, ease: EASE } },
    exit: { opacity: 0, y: -10, transition: { duration: 0.25, ease: EASE } },
};

/* -------- Chart bars: grow from zero ------------------------------- */
export const barItem = {
    hidden: { scaleY: 0, opacity: 0.6 },
    show: (i = 0) => ({
        scaleY: 1,
        opacity: 1,
        transition: { duration: 0.4, ease: EASE, delay: i * 0.012 },
    }),
};

/* -------- Hover tap (reusable on CTAs) ----------------------------- */
export const hoverLift = {
    whileHover: { y: -2, transition: { duration: 0.15, ease: EASE } },
    whileTap: { scale: 0.98 },
};

/**
 * Splits a sentence into word spans ready to receive the wordItem variant.
 * Preserves spaces using inline-block + non-breaking spaces.
 */
export function splitWords(text) {
    return String(text).split(/(\s+)/).filter(Boolean);
}
