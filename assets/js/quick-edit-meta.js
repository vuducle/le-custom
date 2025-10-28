/**
 * Quick Edit Enhanced Meta JavaScript
 *
 * Handles the quick edit functionality for enhanced meta fields including
 * meta descriptions, custom titles, page slugs, and parent pages
 */

(function ($) {
  'use strict';

  // Store data for quick access
  var pageData = {};

  /**
   * Initialize enhanced quick edit functionality
   */
  function initQuickEditMeta() {
    // Populate page data when page loads
    populatePageData();

    // Handle quick edit open
    $(document).on('click', '.editinline', function () {
      var postId = $(this)
        .closest('tr')
        .attr('id')
        .replace('post-', '');
      populateQuickEditForm(postId);
    });

    // Handle character count for meta description
    $(document).on(
      'input',
      'textarea[name="meta_description"]',
      function () {
        updateCharacterCount($(this), 160);
      }
    );

    // Handle character count for custom page title
    $(document).on(
      'input',
      'input[name="custom_page_title"]',
      function () {
        updateCharacterCount($(this), 70);
      }
    );

    // Handle slug formatting
    $(document).on('input', 'input[name="post_name"]', function () {
      formatSlug($(this));
    });
  }

  /**
   * Populate page data from the page list
   */
  function populatePageData() {
    $('.wp-list-table tbody tr').each(function () {
      var $row = $(this);
      var postId = $row.attr('id').replace('post-', '');

      pageData[postId] = {
        slug: $row.find('.column-page_slug code').text().trim(),
        parent: $row.find('.column-page_parent a').length
          ? $row.find('.column-page_parent a').text().trim()
          : '',
        metaDescription: $row
          .find('.column-meta_description .meta-description-preview')
          .text()
          .trim(),
      };
    });
  }

  /**
   * Populate quick edit form with existing data
   */
  function populateQuickEditForm(postId) {
    var data = pageData[postId];

    if (data) {
      // Set slug
      if (data.slug) {
        $('input[name="post_name"]').val(data.slug);
      }

      // Set parent page
      var parentText = data.parent;
      if (parentText) {
        $('select[name="post_parent"] option').each(function () {
          if ($(this).text().indexOf(parentText) > -1) {
            $(this).prop('selected', true);
            return false;
          }
        });
      }

      // Set meta description
      if (data.metaDescription) {
        $('textarea[name="meta_description"]').val(
          data.metaDescription
        );
      }
    }

    // Fetch additional data via AJAX if needed
    $.ajax({
      url: leCustomQuickEdit.ajaxUrl,
      type: 'POST',
      data: {
        action: 'le_custom_get_page_data',
        post_id: postId,
        nonce: leCustomQuickEdit.nonce,
      },
      success: function (response) {
        if (response.success && response.data) {
          var ajaxData = response.data;

          // Update form with AJAX data
          if (ajaxData.custom_title) {
            $('input[name="custom_page_title"]').val(
              ajaxData.custom_title
            );
          }

          if (
            ajaxData.meta_description &&
            !$('textarea[name="meta_description"]').val()
          ) {
            $('textarea[name="meta_description"]').val(
              ajaxData.meta_description
            );
          }

          if (ajaxData.parent_id) {
            $('select[name="post_parent"]').val(ajaxData.parent_id);
          }
        }
      },
    });

    // Update character counts
    updateCharacterCount($('textarea[name="meta_description"]'), 160);
    updateCharacterCount($('input[name="custom_page_title"]'), 70);
  }

  /**
   * Update character count for input fields
   */
  function updateCharacterCount($field, maxLength) {
    var currentLength = $field.val().length;
    var remaining = maxLength - currentLength;

    // Remove existing counter
    $field.siblings('.char-counter').remove();

    // Add character counter
    var $counter = $(
      '<span class="char-counter" style="display: block; margin-top: 5px; font-size: 12px; color: #666;"></span>'
    );
    $field.after($counter);

    if (remaining >= 0) {
      $counter.text(remaining + ' characters remaining');
      $counter.css('color', '#666');
    } else {
      $counter.text(
        'Exceeds limit by ' + Math.abs(remaining) + ' characters'
      );
      $counter.css('color', '#dc3232');
    }
  }

  /**
   * Format slug input to be URL-friendly
   */
  function formatSlug($input) {
    var slug = $input.val();
    var formatted = slug
      .toLowerCase()
      .replace(/[^a-z0-9\-]/g, '-')
      .replace(/-+/g, '-')
      .replace(/^-|-$/g, '');

    if (slug !== formatted) {
      $input.val(formatted);
    }
  }

  /**
   * Add comprehensive styles for enhanced quick edit interface
   */
  function addQuickEditStyles() {
    var styles = `
            <style>
                /* General Table Improvements */
                .wp-list-table.pages {
                    border-spacing: 0;
                }

                .wp-list-table.pages td {
                    padding: 10px 8px !important;
                    vertical-align: middle;
                }

                .wp-list-table.pages .row-title {
                    font-weight: 600;
                    line-height: 1.4;
                }

                /* Enhanced Quick Edit Form */
                .le-custom-meta-fields {
                    width: 50% !important;
                    float: right;
                    clear: right;
                    border-left: 1px solid #dcdcde;
                    padding-left: 20px !important;
                    position: relative;
                }

                .le-custom-meta-fields h4 {
                    margin: 20px 0 10px 0 !important;
                    padding: 0 0 5px 0 !important;
                    font-size: 14px !important;
                    font-weight: 600 !important;
                    color: #1e1e1e !important;
                    border-bottom: 1px solid #e0e0e0;
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                    letter-spacing: 0.3px;
                }

                .le-custom-meta-fields h4:first-child {
                    margin-top: 10px !important;
                }

                .le-custom-meta-fields .inline-edit-col {
                    padding: 0 10px 0 0 !important;
                }

                .le-custom-meta-fields .inline-edit-group {
                    margin-bottom: 15px !important;
                }

                .le-custom-meta-fields .inline-edit-group .title {
                    font-weight: 600;
                    color: #1e1e1e;
                    display: block;
                    margin-bottom: 5px;
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                    letter-spacing: 0.3px;
                }

                .le-custom-meta-fields textarea[name="meta_description"],
                .le-custom-meta-fields input[name="custom_page_title"],
                .le-custom-meta-fields input[name="post_name"],
                .le-custom-meta-fields select[name="post_parent"] {
                    width: 100% !important;
                    margin-top: 5px !important;
                    border: 1px solid #8c8f94;
                    border-radius: 4px;
                    padding: 6px 8px;
                    font-size: 13px;
                }

                .le-custom-meta-fields textarea[name="meta_description"]:focus,
                .le-custom-meta-fields input[name="custom_page_title"]:focus,
                .le-custom-meta-fields input[name="post_name"]:focus,
                .le-custom-meta-fields select[name="post_parent"]:focus {
                    border-color: #2271b1;
                    box-shadow: 0 0 0 1px #2271b1;
                    outline: none;
                }

                .le-custom-meta-fields .description {
                    font-size: 11px !important;
                    color: #646970 !important;
                    font-style: italic;
                    margin-top: 3px !important;
                    display: block;
                }

                /* Character Counters */
                .char-counter {
                    font-style: italic !important;
                    font-size: 11px !important;
                    margin-top: 3px !important;
                    display: block !important;
                }

                .char-counter.over-limit {
                    color: #d63638 !important;
                    font-weight: 600;
                }

                /* Enhanced Page List Columns */
                .column-page_slug {
                    width: 140px;
                    padding: 8px 10px !important;
                }

                .column-page_parent {
                    width: 150px;
                    padding: 8px 10px !important;
                }

                .column-meta_description {
                    width: 250px;
                    padding: 8px 10px !important;
                }

                .column-page_slug code {
                    background: #f6f7f7;
                    border: 1px solid #c3c4c7;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
                    font-size: 12px;
                    color: #2c3338;
                    display: inline-block;
                    line-height: 1.3;
                    white-space: nowrap;
                    max-width: 120px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .column-page_parent a {
                    color: #2271b1;
                    text-decoration: none;
                    font-weight: 500;
                    line-height: 1.4;
                    padding: 2px 0;
                    display: inline-block;
                }

                .column-page_parent a:hover {
                    color: #135e96;
                    text-decoration: underline;
                }

                .column-page_parent .no-parent,
                .column-meta_description .no-meta-description {
                    color: #8c8f94;
                    font-style: italic;
                    font-size: 12px;
                    line-height: 1.4;
                    padding: 2px 0;
                    display: inline-block;
                }

                .column-meta_description .meta-description-preview {
                    max-width: 220px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    line-height: 1.4;
                    color: #50575e;
                    padding: 2px 0;
                    display: inline-block;
                }

                /* Quick Edit Layout Improvements */
                .quick-edit-row .inline-edit-col-left {
                    width: 50% !important;
                }

                .quick-edit-row .inline-edit-col-right:not(.le-custom-meta-fields) {
                    width: 50% !important;
                }

                /* Enhanced Visual Feedback */
                .le-custom-meta-fields input[name="post_name"].slug-invalid {
                    border-color: #d63638 !important;
                    box-shadow: 0 0 0 1px #d63638 !important;
                }

                .le-custom-meta-fields .slug-help {
                    color: #d63638;
                    font-size: 11px;
                    margin-top: 3px;
                    display: block;
                }

                /* Loading States */
                .le-custom-loading {
                    opacity: 0.6;
                    pointer-events: none;
                }

                .le-custom-loading::after {
                    content: '';
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    width: 20px;
                    height: 20px;
                    margin: -10px 0 0 -10px;
                    border: 2px solid #f3f3f3;
                    border-top: 2px solid #2271b1;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                }

                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                /* Success States */
                .le-custom-success {
                    border-left: 4px solid #00a32a !important;
                    background-color: #f0f6fc !important;
                }

                /* Improved Hover States */
                .wp-list-table tbody tr:hover .column-page_slug code {
                    background: #e0e0e0;
                    border-color: #a7aaad;
                }

                /* Accessibility Improvements */
                .le-custom-meta-fields input:focus,
                .le-custom-meta-fields textarea:focus,
                .le-custom-meta-fields select:focus {
                    outline: 2px solid transparent;
                    outline-offset: 0;
                }

                /* Mobile Responsiveness */
                @media screen and (max-width: 1200px) {
                    .column-page_slug {
                        width: 120px;
                    }
                    
                    .column-page_parent {
                        width: 130px;
                    }
                    
                    .column-meta_description {
                        width: 200px;
                    }
                    
                    .column-meta_description .meta-description-preview {
                        max-width: 180px;
                    }
                }

                @media screen and (max-width: 782px) {
                    .le-custom-meta-fields {
                        width: 100% !important;
                        float: none !important;
                        clear: both !important;
                        border-left: none !important;
                        border-top: 1px solid #dcdcde !important;
                        padding-left: 0 !important;
                        padding-top: 15px !important;
                        margin-top: 15px !important;
                    }
                    
                    .quick-edit-row .inline-edit-col-left,
                    .quick-edit-row .inline-edit-col-right {
                        width: 100% !important;
                    }
                    
                    .column-page_slug,
                    .column-page_parent,
                    .column-meta_description {
                        width: auto;
                        padding: 8px 8px !important;
                    }
                    
                    .column-page_slug code {
                        max-width: 100px;
                    }
                    
                    .column-meta_description .meta-description-preview {
                        max-width: 150px;
                    }
                }

                /* High contrast mode support */
                @media (prefers-contrast: high) {
                    .le-custom-meta-fields {
                        border-left-color: #000;
                    }
                    
                    .column-page_slug code {
                        border-color: #000;
                        background: #fff;
                    }
                }

                /* Dark mode considerations */
                @media (prefers-color-scheme: dark) {
                    .column-page_slug code {
                        background: #2c3338;
                        border-color: #50575e;
                        color: #f0f0f1;
                    }
                }
            </style>
        `;

    $('head').append(styles);
  }

  /**
   * Add success feedback when data is saved
   */
  function showSuccessFeedback($row) {
    $row.addClass('le-custom-success');
    setTimeout(function () {
      $row.removeClass('le-custom-success');
    }, 2000);
  }

  /**
   * Validate form fields before submission
   */
  function validateQuickEditForm() {
    var isValid = true;
    var $slugField = $('input[name="post_name"]');

    // Validate slug
    if ($slugField.length && $slugField.val()) {
      var slug = $slugField.val();
      var validSlug = /^[a-z0-9\-]+$/;

      if (!validSlug.test(slug)) {
        $slugField.addClass('slug-invalid');
        $slugField.siblings('.slug-help').remove();
        $slugField.after(
          '<span class="slug-help">Slug contains invalid characters. Use only lowercase letters, numbers, and hyphens.</span>'
        );
        isValid = false;
      } else {
        $slugField.removeClass('slug-invalid');
        $slugField.siblings('.slug-help').remove();
      }
    }

    return isValid;
  }

  /**
   * Handle form submission
   */
  function handleFormSubmission() {
    $(document).on('click', '.inline-edit-save .save', function (e) {
      if (!validateQuickEditForm()) {
        e.preventDefault();
        return false;
      }

      // Add loading state
      var $row = $(this).closest('.quick-edit-row');
      $row.addClass('le-custom-loading');

      // Show success feedback after save (simulate - WordPress handles actual save)
      setTimeout(function () {
        $row.removeClass('le-custom-loading');
        var $originalRow = $row.prev('tr');
        if ($originalRow.length) {
          showSuccessFeedback($originalRow);
        }
      }, 1000);
    });
  }

  // Initialize when document is ready
  $(document).ready(function () {
    if ($('.wp-list-table').length) {
      initQuickEditMeta();
      addQuickEditStyles();
      handleFormSubmission();
    }
  });
})(jQuery);
