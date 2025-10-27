/**
 * Quick Edit Meta Description JavaScript
 * 
 * Handles the quick edit functionality for meta descriptions
 */

(function($) {
    'use strict';

    // Store meta descriptions for quick access
    var metaDescriptions = {};

    /**
     * Initialize quick edit functionality
     */
    function initQuickEditMeta() {
        // Populate meta descriptions when page loads
        populateMetaDescriptions();
        
        // Handle quick edit open
        $(document).on('click', '.editinline', function() {
            var postId = $(this).closest('tr').attr('id').replace('post-', '');
            populateQuickEditForm(postId);
        });
        
        // Handle character count for meta description
        $(document).on('input', 'textarea[name="meta_description"]', function() {
            updateCharacterCount($(this));
        });
        
        // Handle character count for custom page title
        $(document).on('input', 'input[name="custom_page_title"]', function() {
            updateTitleCharacterCount($(this));
        });
    }

    /**
     * Populate meta descriptions from the page
     */
    function populateMetaDescriptions() {
        $('.wp-list-table tbody tr').each(function() {
            var $row = $(this);
            var postId = $row.attr('id').replace('post-', '');
            var $metaColumn = $row.find('.column-meta_description .meta-description-preview');
            
            if ($metaColumn.length) {
                metaDescriptions[postId] = $metaColumn.text().trim();
            }
        });
    }

    /**
     * Populate quick edit form with existing data
     */
    function populateQuickEditForm(postId) {
        // Get meta description from stored data or via AJAX
        var metaDescription = metaDescriptions[postId];
        
        if (metaDescription) {
            $('textarea[name="meta_description"]').val(metaDescription);
        } else {
            // Fetch via AJAX if not available
            $.ajax({
                url: leCustomQuickEdit.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'le_custom_get_meta_description',
                    post_id: postId,
                    nonce: leCustomQuickEdit.nonce
                },
                success: function(response) {
                    if (response.success && response.data.meta_description) {
                        $('textarea[name="meta_description"]').val(response.data.meta_description);
                        metaDescriptions[postId] = response.data.meta_description;
                    }
                }
            });
        }
        
        // Update character count
        updateCharacterCount($('textarea[name="meta_description"]'));
    }

    /**
     * Update character count for meta description
     */
    function updateCharacterCount($textarea) {
        var currentLength = $textarea.val().length;
        var maxLength = 160;
        var remaining = maxLength - currentLength;
        
        // Remove existing counter
        $textarea.siblings('.char-counter').remove();
        
        // Add character counter
        var $counter = $('<span class="char-counter" style="display: block; margin-top: 5px; font-size: 12px; color: #666;"></span>');
        $textarea.after($counter);
        
        if (remaining >= 0) {
            $counter.text(remaining + ' characters remaining');
            $counter.css('color', '#666');
        } else {
            $counter.text('Exceeds limit by ' + Math.abs(remaining) + ' characters');
            $counter.css('color', '#dc3232');
        }
    }

    /**
     * Update character count for custom page title
     */
    function updateTitleCharacterCount($input) {
        var currentLength = $input.val().length;
        var maxLength = 70;
        var remaining = maxLength - currentLength;
        
        // Remove existing counter
        $input.siblings('.char-counter').remove();
        
        // Add character counter
        var $counter = $('<span class="char-counter" style="display: block; margin-top: 5px; font-size: 12px; color: #666;"></span>');
        $input.after($counter);
        
        if (remaining >= 0) {
            $counter.text(remaining + ' characters remaining');
            $counter.css('color', '#666');
        } else {
            $counter.text('Exceeds limit by ' + Math.abs(remaining) + ' characters');
            $counter.css('color', '#dc3232');
        }
    }

    /**
     * Add styles for better UX
     */
    function addQuickEditStyles() {
        var styles = `
            <style>
                .inline-edit-col-right .inline-edit-col {
                    padding: 10px 0;
                }
                
                .inline-edit-group textarea[name="meta_description"] {
                    width: 100%;
                    margin-top: 5px;
                }
                
                .char-counter {
                    font-style: italic;
                }
                
                .column-meta_description .meta-description-preview {
                    max-width: 300px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }
                
                .column-meta_description .no-meta-description {
                    color: #999;
                    font-style: italic;
                }
                
                .quick-edit-row .inline-edit-col-right {
                    width: 50%;
                }
            </style>
        `;
        
        $('head').append(styles);
    }

    // Initialize when document is ready
    $(document).ready(function() {
        if ($('.wp-list-table').length) {
            initQuickEditMeta();
            addQuickEditStyles();
        }
    });

})(jQuery); 