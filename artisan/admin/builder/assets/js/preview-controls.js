(function($) {
    if (typeof acf === 'undefined') return;

    var previewOptionsCache = {};

    function loadPreviewOptions($select) {
        var postId = $('#post_ID').val();
        
        if (previewOptionsCache[postId]) {
            updatePreviewSelect($select, previewOptionsCache[postId]);
            return;
        }
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load_preview_options',
                layout_id: postId
            },
            beforeSend: function() {
                $select.prop('disabled', true);
                $select.empty().append('<option value="">Loading...</option>');
            },
            success: function(response) {
                if (response.success && response.data.results) {
                    previewOptionsCache[postId] = response.data.results;
                    updatePreviewSelect($select, response.data.results);
                }
            },
            error: function() {
                $select.empty().append('<option value="">Error loading preview options</option>');
            },
            complete: function() {
                $select.prop('disabled', false);
            }
        });
    }

    function updatePreviewSelect($select, options) {
        $select.empty().append('<option value="">- Select Preview Page -</option>');
        
        options.forEach(function(item) {
            $select.append($('<option></option>')
                .attr('value', item.id)
                .attr('data-url', item.url)
                .text(item.text));
        });

        // Update URL field if there was a previously selected value
        var prevValue = $select.data('prevValue');
        if (prevValue) {
            $select.val(prevValue).trigger('change');
        }
    }

    function invalidatePreviewCache() {
        previewOptionsCache = {};
    }

    // Handle preview selection change
    $(document).on('change', '[data-key="field_preview_select"] select', function() {
        var $selected = $(this).find('option:selected');
        var url = $selected.data('url') || '';
        $(this).data('prevValue', $(this).val());
        $('[data-key="field_preview_url"] input').val(url);
    });

    // Handle preview reload trigger
    $(document).on('reload', '[data-key="field_preview_select"] select', function() {
        invalidatePreviewCache();
        loadPreviewOptions($(this));
    });

    // Initialize preview options when tab is shown
    acf.addAction('show_field/key=field_preview_tab', function(field) {
        var $select = field.$el.find('[data-key="field_preview_select"] select');
        loadPreviewOptions($select);
    });
})(jQuery);
