import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot, hydrateRoot } from 'react-dom/client';
import { AppProviders } from '@/Layouts/AppProviders';

const appName = import.meta.env.VITE_APP_NAME || 'Gotham Express';

createInertiaApp({
    title: (title) => (title ? `${title} · ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        const tree = (
            <AppProviders initialTheme={props.initialPage?.props?.theme ?? 'light'}>
                <App {...props} />
            </AppProviders>
        );

        if (import.meta.env.SSR) {
            hydrateRoot(el, tree);
            return;
        }

        createRoot(el).render(tree);
    },
    progress: {
        color: '#3478F7',
        showSpinner: false,
    },
});
