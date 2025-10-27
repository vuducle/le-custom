/**
 * Single Image Block Inserter for WordPress Block Editor
 * 
 * Adds a custom single image block inserter button to the block editor
 */

(function() {
    'use strict';

    // Wait for WordPress block editor to be ready
    if (typeof wp !== 'undefined' && wp.blocks && wp.element) {
        const { registerBlockType } = wp.blocks;
        const { createElement: el } = wp.element;
        const { __ } = wp.i18n;
        const { InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
        const { PanelBody, Button, TextControl, SelectControl, TextareaControl } = wp.components;

        // Register custom single image block
        registerBlockType('le-custom/single-image-with-lightbox', {
            title: __('Professional Single Image', 'le-custom'),
            description: __('A professional single image with lightbox and lazy loading, perfect for dental practices.', 'le-custom'),
            category: 'le-custom',
            icon: 'format-image',
            keywords: [
                __('image', 'le-custom'),
                __('photo', 'le-custom'),
                __('lightbox', 'le-custom'),
                __('dental', 'le-custom'),
                __('professional', 'le-custom'),
                __('treatment', 'le-custom'),
                __('before after', 'le-custom'),
                __('result', 'le-custom')
            ],
            supports: {
                align: ['wide', 'full', 'center'],
                html: false,
                spacing: {
                    margin: true,
                    padding: true
                }
            },
            attributes: {
                image: {
                    type: 'object',
                    default: {}
                },
                title: {
                    type: 'string',
                    default: __('Treatment Result', 'le-custom')
                },
                caption: {
                    type: 'string',
                    default: __('Professional dental treatment result showcasing our expertise and care.', 'le-custom')
                },
                size: {
                    type: 'string',
                    default: 'large'
                },
                enableLightbox: {
                    type: 'boolean',
                    default: true
                },
                enableLazyLoading: {
                    type: 'boolean',
                    default: true
                },
                showCaption: {
                    type: 'boolean',
                    default: true
                },
                showTitle: {
                    type: 'boolean',
                    default: true
                }
            },

            edit: function(props) {
                const { attributes, setAttributes } = props;
                const { image, title, caption, size, enableLightbox, enableLazyLoading, showCaption, showTitle } = attributes;

                const onSelectImage = (newImage) => {
                    setAttributes({
                        image: {
                            id: newImage.id,
                            url: newImage.url,
                            alt: newImage.alt,
                            caption: newImage.caption,
                            sizes: newImage.sizes
                        }
                    });
                };

                const removeImage = () => {
                    setAttributes({ image: {} });
                };

                return el('div', { className: 'le-custom-single-image-block' },
                    // Inspector Controls
                    el(InspectorControls, {},
                        el(PanelBody, { title: __('Professional Image Settings', 'le-custom'), initialOpen: true },
                            el('div', { className: 'components-base-control' },
                                el('label', { className: 'components-base-control__label' },
                                    __('Display Options', 'le-custom')
                                ),
                                el('div', { className: 'components-checkbox-control' },
                                    el('input', {
                                        type: 'checkbox',
                                        checked: showTitle,
                                        onChange: () => setAttributes({ showTitle: !showTitle })
                                    }),
                                    el('span', {}, __('Show title', 'le-custom'))
                                ),
                                el('div', { className: 'components-checkbox-control' },
                                    el('input', {
                                        type: 'checkbox',
                                        checked: showCaption,
                                        onChange: () => setAttributes({ showCaption: !showCaption })
                                    }),
                                    el('span', {}, __('Show caption', 'le-custom'))
                                )
                            ),
                            el('div', { className: 'components-base-control' },
                                el('label', { className: 'components-base-control__label' },
                                    __('Professional Features', 'le-custom')
                                ),
                                el('div', { className: 'components-checkbox-control' },
                                    el('input', {
                                        type: 'checkbox',
                                        checked: enableLightbox,
                                        onChange: () => setAttributes({ enableLightbox: !enableLightbox })
                                    }),
                                    el('span', {}, __('Enable professional lightbox', 'le-custom'))
                                ),
                                el('div', { className: 'components-checkbox-control' },
                                    el('input', {
                                        type: 'checkbox',
                                        checked: enableLazyLoading,
                                        onChange: () => setAttributes({ enableLazyLoading: !enableLazyLoading })
                                    }),
                                    el('span', {}, __('Enable performance optimization', 'le-custom'))
                                )
                            ),
                            el(SelectControl, {
                                label: __('Image Size', 'le-custom'),
                                value: size,
                                options: [
                                    { label: __('Thumbnail', 'le-custom'), value: 'thumbnail' },
                                    { label: __('Medium', 'le-custom'), value: 'medium' },
                                    { label: __('Large', 'le-custom'), value: 'large' },
                                    { label: __('Full Size', 'le-custom'), value: 'full' }
                                ],
                                onChange: (value) => setAttributes({ size: value })
                            })
                        )
                    ),

                    // Single Image Content
                    el('div', { className: 'single-image-block-container' },
                        // Image Title
                        showTitle && el(TextControl, {
                            label: __('Image Title', 'le-custom'),
                            value: title,
                            onChange: (value) => setAttributes({ title: value }),
                            placeholder: __('e.g., Treatment Result, Before & After, Our Work', 'le-custom')
                        }),

                        // Image Upload/Selection
                        el(MediaUploadCheck, {},
                            el(MediaUpload, {
                                onSelect: onSelectImage,
                                allowedTypes: ['image'],
                                multiple: false,
                                value: image.id,
                                render: ({ open }) => el(Button, {
                                    onClick: open,
                                    isPrimary: true,
                                    className: 'single-image-upload-button'
                                }, image.id ? __('Change Image', 'le-custom') : __('Select Professional Image', 'le-custom'))
                            })
                        ),

                        // Image Display
                        image.url && el('div', { className: 'single-image-preview' },
                            el('figure', { className: 'single-image-with-lightbox' },
                                el('img', {
                                    src: image.sizes && image.sizes[size] ? image.sizes[size].url : image.url,
                                    alt: image.alt || title,
                                    className: enableLazyLoading ? 'lazy-image' : ''
                                })
                            ),
                            el(Button, {
                                onClick: removeImage,
                                isDestructive: true,
                                isSmall: true,
                                className: 'remove-single-image-button'
                            }, __('Remove Image', 'le-custom'))
                        ),

                        // Image Caption
                        showCaption && el(TextareaControl, {
                            label: __('Professional Caption', 'le-custom'),
                            value: caption,
                            onChange: (value) => setAttributes({ caption: value }),
                            placeholder: __('Describe the treatment result or professional achievement...', 'le-custom'),
                            rows: 3
                        }),

                        // Empty State
                        !image.url && el('div', {
                            className: 'single-image-empty'
                        }, __('No image selected. Click "Select Professional Image" to add a professional image.', 'le-custom'))
                    )
                );
            },

            save: function(props) {
                const { attributes } = props;
                const { image, title, caption, size, enableLightbox, enableLazyLoading, showCaption, showTitle } = attributes;

                if (!image.url) {
                    return el('div', { className: 'single-image-block-container' },
                        showTitle && title && el('h3', { className: 'single-image-title' }, title),
                        el('div', { className: 'single-image-empty' }, __('No image selected.', 'le-custom'))
                    );
                }

                const imageUrl = image.sizes && image.sizes[size] ? image.sizes[size].url : image.url;

                return el('div', { className: 'single-image-block-container' },
                    showTitle && title && el('h3', { className: 'single-image-title' }, title),
                    el('figure', { className: 'single-image-with-lightbox' },
                        enableLightbox ? el('a', {
                            href: image.url,
                            'data-lightbox': 'single-image',
                            title: image.alt || title
                        }, el('img', {
                            src: imageUrl,
                            alt: image.alt || title,
                            className: enableLazyLoading ? 'lazy-image' : '',
                            'data-src': image.url
                        })) : el('img', {
                            src: imageUrl,
                            alt: image.alt || title,
                            className: enableLazyLoading ? 'lazy-image' : '',
                            'data-src': image.url
                        })
                    ),
                    showCaption && caption && el('p', { className: 'single-image-caption' }, caption)
                );
            }
        });

        // Add custom block category if it doesn't exist
        if (wp.blocks.getCategories) {
            const categories = wp.blocks.getCategories();
            const leCustomCategory = categories.find(cat => cat.slug === 'le-custom');
            
            if (!leCustomCategory) {
                wp.blocks.registerBlockCollection('le-custom', {
                    title: __('LE Custom Blocks', 'le-custom'),
                    icon: 'format-image'
                });
            }
        }
    }

})(); 