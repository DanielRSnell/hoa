import { initRepeaterTabs } from './modules/repeater-tabs.js';
import { initCommandPalette } from './modules/command-palette/index.js';
import { initFlexibleManager } from './modules/flexible-manager.js';
import { LocationControls } from './modules/location-controls.js';

function initEditor() {
  initRepeaterTabs();
  initCommandPalette();
  initFlexibleManager();
  LocationControls.init();

  if (typeof window.acf !== 'undefined') {
    window.acf.addAction('append', function($el) {
      if ($el.hasClass('acf-row')) {
        initRepeaterTabs();
      }
      initFlexibleManager();
    });

    window.acf.addAction('remove', function($el) {
      if ($el.hasClass('acf-row')) {
        initRepeaterTabs();
      }
      initFlexibleManager();
    });

    window.acf.addAction('sortstop', function($el) {
      if ($el.hasClass('values')) {
        initFlexibleManager();
      }
    });
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initEditor);
} else {
  initEditor();
}
