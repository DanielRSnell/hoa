export function extractComponents() {
  const elements = document.querySelectorAll('[data-layout]');
  const components = new Map();
  
  elements.forEach(element => {
    const layout = element.getAttribute('data-layout');
    if (!components.has(layout)) {
      components.set(layout, {
        layout,
        label: element.textContent.trim(),
        min: element.getAttribute('data-min') || '',
        max: element.getAttribute('data-max') || '',
        element
      });
    }
  });
  
  return Array.from(components.values());
}

export function createComponentLink(component) {
  const link = document.createElement('a');
  link.href = '#';
  link.setAttribute('data-layout', component.layout);
  link.setAttribute('data-min', component.min);
  link.setAttribute('data-max', component.max);
  link.textContent = component.label;
  return link;
}
