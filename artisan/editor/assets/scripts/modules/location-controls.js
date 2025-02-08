export const LocationControls = {
  init() {
    if (typeof window.acf === 'undefined') return;
    
    this.bindEvents();
    this.initExistingFields();
  },

  bindEvents() {
    window.acf.addAction('append_field/name=location_rules', this.handleNewRow.bind(this));
    window.acf.addAction('ready_field/name=location_rules', this.initExistingFields.bind(this));
    window.acf.addAction('change', this.handleFieldChange.bind(this));
  },

  initExistingFields() {
    const fields = window.acf.getFields({ name: 'location_rules' });
    fields.forEach(field => {
      field.$el.find('.acf-row:not(.acf-clone)').each((i, row) => {
        this.updateFields($(row));
      });
    });
  },

  handleNewRow(field) {
    const $row = field.$el.find('.acf-row:last');
    this.updateFields($row);
  },

  handleFieldChange(field) {
    const $row = field.$el.closest('.acf-row');
    if (!$row.length) return;

    if (field.get('name') === 'group') {
      this.updateFields($row);
    }
  },

  updateFields($row) {
    const fields = window.acf.getFields({
      parent: $row
    });

    const groupField = fields.find(f => f.get('name') === 'group');
    const typeField = fields.find(f => f.get('name') === 'type');
    const modeField = fields.find(f => f.get('name') === 'mode');
    const itemsField = fields.find(f => f.get('name') === 'items');
    const routeField = fields.find(f => f.get('name') === 'route_pattern');
    const hookField = fields.find(f => f.get('name') === 'hook_name');

    if (!groupField) return;

    const group = groupField.val();

    [typeField, modeField, itemsField, routeField, hookField].forEach(field => {
      if (field) field.$el.hide();
    });

    switch (group) {
      case 'route':
        if (routeField) routeField.$el.show();
        break;
      case 'hook':
        if (hookField) hookField.$el.show();
        break;
      case 'singular':
        if (typeField) typeField.$el.show();
        if (modeField) modeField.$el.show();
        if (modeField && modeField.val() !== 'all' && itemsField) {
          itemsField.$el.show();
        }
        break;
      case 'archive':
      case 'taxonomy':
        if (typeField) typeField.$el.show();
        break;
    }
  }
};
