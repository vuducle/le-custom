/**
 * Gallery Block Inserter for WordPress Block Editor
 *
 * Adds a custom gallery block inserter button to the block editor
 */

(function () {
  'use strict';

  // Wait for WordPress block editor to be ready
  if (typeof wp !== 'undefined' && wp.blocks && wp.element) {
    const { registerBlockType } = wp.blocks;
    const { createElement: el } = wp.element;
    const { __ } = wp.i18n;
    const { InspectorControls, MediaUpload, MediaUploadCheck } =
      wp.blockEditor;
    const { PanelBody, Button, TextControl, SelectControl } =
      wp.components;

    // Register custom gallery block
    registerBlockType('le-custom/gallery-with-lightbox', {
      title: __('Professional Gallery', 'le-custom'),
      description: __(
        'A modern, professional gallery perfect for dental practices with lightbox and lazy loading.',
        'le-custom'
      ),
      category: 'le-custom',
      icon: 'format-gallery',
      keywords: [
        __('gallery', 'le-custom'),
        __('images', 'le-custom'),
        __('lightbox', 'le-custom'),
        __('photo', 'le-custom'),
        __('dental', 'le-custom'),
        __('professional', 'le-custom'),
        __('treatment', 'le-custom'),
        __('before after', 'le-custom'),
      ],
      supports: {
        align: ['wide', 'full'],
        html: false,
        spacing: {
          margin: true,
          padding: true,
        },
      },
      attributes: {
        images: {
          type: 'array',
          default: [],
        },
        title: {
          type: 'string',
          default: __('Treatment Gallery', 'le-custom'),
        },
        columns: {
          type: 'number',
          default: 3,
        },
        gap: {
          type: 'string',
          default: '1rem',
        },
        showCaptions: {
          type: 'boolean',
          default: true,
        },
        enableLightbox: {
          type: 'boolean',
          default: true,
        },
        enableLazyLoading: {
          type: 'boolean',
          default: true,
        },
      },

      edit: function (props) {
        const { attributes, setAttributes } = props;
        const {
          images,
          title,
          columns,
          gap,
          showCaptions,
          enableLightbox,
          enableLazyLoading,
        } = attributes;

        const onSelectImages = (newImages) => {
          const formattedImages = newImages.map((image) => ({
            id: image.id,
            url: image.url,
            alt: image.alt,
            caption: image.caption,
            thumbnail: image.sizes?.medium?.url || image.url,
          }));
          setAttributes({ images: formattedImages });
        };

        const removeImage = (index) => {
          const newImages = [...images];
          newImages.splice(index, 1);
          setAttributes({ images: newImages });
        };

        const replaceImage = (index, newImage) => {
          const newImages = [...images];
          newImages[index] = {
            id: newImage.id,
            url: newImage.url,
            alt: newImage.alt,
            caption: newImage.caption || newImages[index].caption, // Keep existing caption if new one is empty
            thumbnail: newImage.sizes?.medium?.url || newImage.url,
          };
          setAttributes({ images: newImages });
        };

        const updateImageCaption = (index, caption) => {
          const newImages = [...images];
          newImages[index].caption = caption;
          setAttributes({ images: newImages });
        };

        return el(
          'div',
          { className: 'le-custom-gallery-block' },
          // Inspector Controls
          el(
            InspectorControls,
            {},
            el(
              PanelBody,
              {
                title: __(
                  'Professional Gallery Settings',
                  'le-custom'
                ),
                initialOpen: true,
              },
              el(TextControl, {
                label: __('Gallery Title', 'le-custom'),
                value: title,
                onChange: (value) => setAttributes({ title: value }),
                placeholder: __(
                  'e.g., Treatment Gallery, Before & After, Our Work',
                  'le-custom'
                ),
              }),
              el(SelectControl, {
                label: __('Columns', 'le-custom'),
                value: columns,
                options: [
                  { label: '1', value: 1 },
                  { label: '2', value: 2 },
                  { label: '3', value: 3 },
                  { label: '4', value: 4 },
                  { label: '5', value: 5 },
                  { label: '6', value: 6 },
                ],
                onChange: (value) =>
                  setAttributes({ columns: parseInt(value) }),
              }),
              el(SelectControl, {
                label: __('Gap', 'le-custom'),
                value: gap,
                options: [
                  {
                    label: __('Small', 'le-custom'),
                    value: '0.5rem',
                  },
                  { label: __('Medium', 'le-custom'), value: '1rem' },
                  {
                    label: __('Large', 'le-custom'),
                    value: '1.5rem',
                  },
                ],
                onChange: (value) => setAttributes({ gap: value }),
              }),
              el(
                'div',
                { className: 'components-base-control' },
                el(
                  'label',
                  { className: 'components-base-control__label' },
                  __('Professional Features', 'le-custom')
                ),
                el(
                  'div',
                  { className: 'components-checkbox-control' },
                  el('input', {
                    type: 'checkbox',
                    checked: showCaptions,
                    onChange: () =>
                      setAttributes({ showCaptions: !showCaptions }),
                  }),
                  el(
                    'span',
                    {},
                    __('Show image captions', 'le-custom')
                  )
                ),
                el(
                  'div',
                  { className: 'components-checkbox-control' },
                  el('input', {
                    type: 'checkbox',
                    checked: enableLightbox,
                    onChange: () =>
                      setAttributes({
                        enableLightbox: !enableLightbox,
                      }),
                  }),
                  el(
                    'span',
                    {},
                    __('Enable professional lightbox', 'le-custom')
                  )
                ),
                el(
                  'div',
                  { className: 'components-checkbox-control' },
                  el('input', {
                    type: 'checkbox',
                    checked: enableLazyLoading,
                    onChange: () =>
                      setAttributes({
                        enableLazyLoading: !enableLazyLoading,
                      }),
                  }),
                  el(
                    'span',
                    {},
                    __('Enable performance optimization', 'le-custom')
                  )
                )
              )
            )
          ),

          // Gallery Content
          el(
            'div',
            { className: 'gallery-block-container' },
            // Gallery Title
            title && el('h2', { className: 'gallery-title' }, title),

            // Image Upload/Selection
            el(
              MediaUploadCheck,
              {},
              el(MediaUpload, {
                onSelect: onSelectImages,
                allowedTypes: ['image'],
                multiple: true,
                gallery: true,
                value: images.map((img) => img.id),
                render: ({ open }) =>
                  el(
                    Button,
                    {
                      onClick: open,
                      isPrimary: true,
                      className: 'gallery-upload-button',
                    },
                    images.length === 0
                      ? __('Select Treatment Images', 'le-custom')
                      : __('Add More Images', 'le-custom')
                  ),
              })
            ),

            // Gallery Grid
            images.length > 0 &&
              el(
                'div',
                {
                  className: 'gallery-with-lightbox',
                  style: {
                    gridTemplateColumns: `repeat(${columns}, 1fr)`,
                    gap: gap,
                  },
                },
                images.map((image, index) =>
                  el(
                    'figure',
                    {
                      key: image.id,
                      className: 'gallery-image',
                    },
                    el('img', {
                      src: image.thumbnail,
                      alt: image.alt,
                      className: enableLazyLoading
                        ? 'lazy-image'
                        : '',
                    }),
                    showCaptions &&
                      image.caption &&
                      el(
                        'figcaption',
                        {},
                        el(TextControl, {
                          value: image.caption,
                          onChange: (value) =>
                            updateImageCaption(index, value),
                          placeholder: __(
                            'Add caption...',
                            'le-custom'
                          ),
                        })
                      ),
                    el(
                      'div',
                      { className: 'gallery-image-controls' },
                      el(
                        MediaUploadCheck,
                        {},
                        el(MediaUpload, {
                          onSelect: (newImage) =>
                            replaceImage(index, newImage),
                          allowedTypes: ['image'],
                          multiple: false,
                          value: image.id,
                          render: ({ open }) =>
                            el(
                              Button,
                              {
                                onClick: open,
                                isSecondary: true,
                                isSmall: true,
                                className: 'replace-image-button',
                              },
                              __('Replace', 'le-custom')
                            ),
                        })
                      ),
                      el(
                        Button,
                        {
                          onClick: () => removeImage(index),
                          isDestructive: true,
                          isSmall: true,
                          className: 'remove-image-button',
                        },
                        __('Remove', 'le-custom')
                      )
                    )
                  )
                )
              ),

            // Empty State
            images.length === 0 &&
              el(
                'div',
                {
                  className: 'gallery-empty',
                },
                __(
                  'No images selected. Click "Select Treatment Images" to add professional images to your gallery.',
                  'le-custom'
                )
              )
          )
        );
      },

      save: function (props) {
        const { attributes } = props;
        const {
          images,
          title,
          columns,
          gap,
          showCaptions,
          enableLightbox,
          enableLazyLoading,
        } = attributes;

        if (images.length === 0) {
          return el(
            'div',
            { className: 'gallery-block-container' },
            title && el('h2', { className: 'gallery-title' }, title),
            el(
              'div',
              { className: 'gallery-empty' },
              __('No images selected.', 'le-custom')
            )
          );
        }

        return el(
          'div',
          { className: 'gallery-block-container' },
          title && el('h2', { className: 'gallery-title' }, title),
          el(
            'div',
            {
              className: 'gallery-with-lightbox',
              style: {
                gridTemplateColumns: `repeat(${columns}, 1fr)`,
                gap: gap,
              },
            },
            images.map((image, index) =>
              el(
                'figure',
                {
                  key: image.id,
                  className: 'gallery-image',
                },
                enableLightbox
                  ? el(
                      'a',
                      {
                        href: image.url,
                        'data-lightbox': 'gallery',
                        title: image.alt,
                      },
                      el('img', {
                        src: image.thumbnail,
                        alt: image.alt,
                        className: enableLazyLoading
                          ? 'lazy-image'
                          : '',
                        'data-src': image.url,
                      })
                    )
                  : el('img', {
                      src: image.thumbnail,
                      alt: image.alt,
                      className: enableLazyLoading
                        ? 'lazy-image'
                        : '',
                      'data-src': image.url,
                    }),
                showCaptions &&
                  image.caption &&
                  el('figcaption', {}, image.caption)
              )
            )
          )
        );
      },
    });

    // Add custom block category if it doesn't exist
    if (wp.blocks.getCategories) {
      const categories = wp.blocks.getCategories();
      const leCustomCategory = categories.find(
        (cat) => cat.slug === 'le-custom'
      );

      if (!leCustomCategory) {
        wp.blocks.registerBlockCollection('le-custom', {
          title: __('LE Custom Blocks', 'le-custom'),
          icon: 'format-gallery',
        });
      }
    }
  }
})();
