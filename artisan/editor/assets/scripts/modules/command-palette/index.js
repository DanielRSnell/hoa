import { CommandPaletteWindow } from './window.js';

let commandPalette;

export function initCommandPalette() {
  window.handoff = window.handoff || {};

  const registerLayoutHandler = () => {
    const fields = window.acf.getFields();
    
    if (!fields || !Array.isArray(fields)) return;

    const componentsField = fields.find(field => 
      field.data && field.data.name === 'components'
    );

    if (!componentsField) return;

    const fieldKey = componentsField.get('key');

    window.handoff.addLayout = (layoutName) => {
      const field = window.acf.getField(fieldKey);
      if (field) {
        field.add({ layout: layoutName });
      }
    };
  };

  commandPalette = new CommandPaletteWindow();
  window.CommandPalette = {
    instance: commandPalette,
    
    open() {
      const button = document.querySelector('[data-name="add-layout"]');
      if (button && this.instance) {
        const components = this.extractComponents();
        this.instance.open(button, components);
      }
    },

    close() {
      if (this.instance) {
        this.instance.close();
      }
    },

    toggle() {
      if (!this.instance) return;
      
      if (this.instance.isOpen) {
        this.close();
      } else {
        this.open();
      }
    },

    extractComponents() {
      const layouts = new Map();
      const links = Array.from(document.querySelectorAll('.acf-fc-popup a[data-layout]'));
      
      links.forEach(link => {
        const layout = link.getAttribute('data-layout');
        if (!layouts.has(layout)) {
          layouts.set(layout, {
            layout,
            label: this.formatComponentName(layout),
            min: link.getAttribute('data-min') || '',
            max: link.getAttribute('data-max') || '',
            description: this.getComponentDescription(layout),
            category: this.getComponentCategory(layout),
            icon: this.getComponentIcon(layout)
          });
        }
      });
      
      return Array.from(layouts.values());
    },

    formatComponentName(name) {
      return name
        .split(/[-_]/)
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    },

    getComponentDescription(layout) {
      const descriptions = {
        hero: 'Full-width banner section with title, content, and call-to-action',
        testimonials: 'Display customer reviews in various layouts',
        features: 'Showcase product or service features in a grid',
        cta: 'Conversion-focused call-to-action section',
        pricing: 'Display pricing tables and plans',
        gallery: 'Image gallery with various display options',
        team: 'Team member profiles and information',
        faq: 'Frequently asked questions in accordion format',
        stats: 'Display statistics and key metrics',
        contact: 'Contact form and information section'
      };
      return descriptions[layout] || '';
    },

    getComponentCategory(layout) {
      const categories = {
        hero: 'Header',
        testimonials: 'Social Proof',
        features: 'Content',
        cta: 'Conversion',
        pricing: 'Conversion',
        gallery: 'Media',
        team: 'Content',
        faq: 'Content',
        stats: 'Content',
        contact: 'Forms'
      };
      return categories[layout] || 'Other';
    },

    getComponentIcon(layout) {
      const icons = {
        hero: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="18" height="18" rx="2" />
          <path d="M3 9h18" />
        </svg>`,
        testimonials: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M17 8h2a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2v4l-4-4H9a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h8Z" />
        </svg>`
      };
      return icons[layout] || `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="18" height="18" rx="2" />
        <path d="M12 8v8" />
        <path d="M8 12h8" />
      </svg>`;
    }
  };

  if (typeof window.acf !== 'undefined') {
    window.acf.addAction('show_field_popup', function(popup, $el) {
      if ($el.hasClass('acf-fc-add')) {
        registerLayoutHandler();
        window.CommandPalette.open();
        return false;
      }
    }, 5);
  }

  document.addEventListener('click', (e) => {
    const button = e.target.closest('[data-name="add-layout"]');
    if (button) {
      e.preventDefault();
      e.stopPropagation();
      registerLayoutHandler();
      window.CommandPalette.open();
    }
  });

  document.addEventListener('keydown', (e) => {
    if ((e.key === 'k' || e.key === 'K') && (e.metaKey || e.ctrlKey) && !e.shiftKey && !e.altKey) {
      e.preventDefault();
      registerLayoutHandler();
      window.CommandPalette.open();
    }
  });
}
