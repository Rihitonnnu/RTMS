import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createTheme, ThemeProvider } from '@mui/material';

const appName =
  window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const appTheme = createTheme({
  palette: {
    mode: 'light',
    secondary: {
      main: '#A9A9A9',
      light: '#ffa2a3',
      dark: '#a34449'
    }
  }
});

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.tsx`,
      import.meta.glob('./Pages/**/*.tsx')
    ),
  setup({ el, App, props }) {
    const root = createRoot(el);

    root.render(
      <ThemeProvider theme={appTheme}>
        <App {...props} />
      </ThemeProvider>
    );
  },
  progress: {
    color: '#4B5563'
  }
});
