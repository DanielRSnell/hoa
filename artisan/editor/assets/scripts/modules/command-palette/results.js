export function renderResults(items, container, button) {
  container.innerHTML = items.map((item, index) => `
    <div class="command-palette__item ${index === 0 ? 'is-selected' : ''}" data-layout="${item.layout}">
      <span class="command-palette__icon">${item.label[0].toUpperCase()}</span>
      <span class="command-palette__label">${item.label}</span>
      <span class="command-palette__shortcut">⏎</span>
    </div>
  `).join('');

  container.querySelectorAll('.command-palette__item').forEach(item => {
    item.addEventListener('click', () => {
      const component = items.find(c => c.layout === item.dataset.layout);
      if (component) {
        const link = createComponentLink(component);
        button.parentNode.appendChild(link);
        link.click();
        link.remove();
        container.closest('.command-palette').classList.remove('is-active');
      }
    });

    item.addEventListener('mouseenter', () => {
      container.querySelectorAll('.command-palette__item').forEach(i => 
        i.classList.remove('is-selected')
      );
      item.classList.add('is-selected');
    });
  });
}

export function updateSelection(items, index) {
  items.forEach(item => item.classList.remove('is-selected'));
  items[index]?.classList.add('is-selected');
  items[index]?.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
}

function createComponentLink(component) {
  const link = document.createElement('a');
  link.href = '#';
  link.setAttribute('data-layout', component.layout);
  link.setAttribute('data-min', component.min);
  link.setAttribute('data-max', component.max);
  link.textContent = component.label;
  return link;
}
