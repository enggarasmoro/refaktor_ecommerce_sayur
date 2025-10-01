import React from 'react';
import ReactDOM from 'react-dom/client';
import { MobileApp } from './mobile/MobileApp.jsx';

// Build marker (update date/time string to confirm newest bundle loads)
const BUILD_MARK = 'mobile-bundle-2025-10-01-01';
if (typeof window !== 'undefined') {
  window.__APP_BUILD__ = BUILD_MARK;
  // eslint-disable-next-line no-console
  console.log('[APP BUILD]', BUILD_MARK);
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
  <MobileApp />
  </React.StrictMode>
);
