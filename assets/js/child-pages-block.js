/**
 * Child Pages Block - Editor Component
 * 
 * Registers and configures the Child Pages block for the Gutenberg editor
 */

(function (wp) {
    const { registerBlockType } = wp.blocks;
    const { InspectorControls } = wp.blockEditor;
    const { PanelBody, SelectControl, ToggleControl, RangeControl } = wp.components;
    const { __ } = wp.i18n;
    const { useEffect } = wp.element;

    registerBlockType('le-custom/child-pages', {
        title: __('Child Pages', 'le-custom'),
        description: __('Display child pages with title, image, and excerpt', 'le-custom'),
        icon: 'list-view',
        category: 'widgets',
        keywords: [__('child'), __('pages'), __('subpages'), __('children')],
        supports: {
            align: ['wide', 'full'],
            html: false,
        },
        attributes: {
            layout: {
                type: 'string',
                default: 'grid'
            },
            columns: {
                type: 'number',
                default: 3
            },
            showImage: {
                type: 'boolean',
                default: true
            },
            showExcerpt: {
                type: 'boolean',
                default: true
            },
            excerptLength: {
                type: 'number',
                default: 20
            },
            orderBy: {
                type: 'string',
                default: 'menu_order'
            },
            order: {
                type: 'string',
                default: 'ASC'
            }
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const { layout, columns, showImage, showExcerpt, excerptLength, orderBy, order } = attributes;

            return [
                // Inspector Controls (Sidebar)
                wp.element.createElement(
                    InspectorControls,
                    { key: 'inspector' },
                    wp.element.createElement(
                        PanelBody,
                        { title: __('Layout Settings', 'le-custom'), initialOpen: true },
                        wp.element.createElement(SelectControl, {
                            label: __('Layout', 'le-custom'),
                            value: layout,
                            options: [
                                { label: __('Grid', 'le-custom'), value: 'grid' },
                                { label: __('List', 'le-custom'), value: 'list' }
                            ],
                            onChange: (value) => setAttributes({ layout: value })
                        }),
                        layout === 'grid' && wp.element.createElement(RangeControl, {
                            label: __('Columns', 'le-custom'),
                            value: columns,
                            onChange: (value) => setAttributes({ columns: value }),
                            min: 1,
                            max: 4
                        })
                    ),
                    wp.element.createElement(
                        PanelBody,
                        { title: __('Display Settings', 'le-custom'), initialOpen: true },
                        wp.element.createElement(ToggleControl, {
                            label: __('Show Featured Image', 'le-custom'),
                            checked: showImage,
                            onChange: (value) => setAttributes({ showImage: value })
                        }),
                        wp.element.createElement(ToggleControl, {
                            label: __('Show Excerpt', 'le-custom'),
                            checked: showExcerpt,
                            onChange: (value) => setAttributes({ showExcerpt: value })
                        }),
                        showExcerpt && wp.element.createElement(RangeControl, {
                            label: __('Excerpt Length (words)', 'le-custom'),
                            value: excerptLength,
                            onChange: (value) => setAttributes({ excerptLength: value }),
                            min: 10,
                            max: 50
                        })
                    ),
                    wp.element.createElement(
                        PanelBody,
                        { title: __('Sorting', 'le-custom'), initialOpen: false },
                        wp.element.createElement(SelectControl, {
                            label: __('Order By', 'le-custom'),
                            value: orderBy,
                            options: [
                                { label: __('Menu Order', 'le-custom'), value: 'menu_order' },
                                { label: __('Title', 'le-custom'), value: 'title' },
                                { label: __('Date Created', 'le-custom'), value: 'date' },
                                { label: __('Date Modified', 'le-custom'), value: 'modified' }
                            ],
                            onChange: (value) => setAttributes({ orderBy: value })
                        }),
                        wp.element.createElement(SelectControl, {
                            label: __('Order', 'le-custom'),
                            value: order,
                            options: [
                                { label: __('Ascending', 'le-custom'), value: 'ASC' },
                                { label: __('Descending', 'le-custom'), value: 'DESC' }
                            ],
                            onChange: (value) => setAttributes({ order: value })
                        })
                    )
                ),

                // Editor Preview
                wp.element.createElement(
                    'div',
                    {
                        key: 'preview',
                        className: 'child-pages-block-editor-preview',
                        style: {
                            padding: '2rem',
                            backgroundColor: '#f9fafb',
                            borderRadius: '0.5rem',
                            border: '2px dashed #d1d5db'
                        }
                    },
                    wp.element.createElement(
                        'div',
                        { style: { textAlign: 'center' } },
                        wp.element.createElement(
                            'svg',
                            {
                                style: {
                                    width: '48px',
                                    height: '48px',
                                    margin: '0 auto 1rem',
                                    color: '#6b7280'
                                },
                                fill: 'none',
                                stroke: 'currentColor',
                                viewBox: '0 0 24 24'
                            },
                            wp.element.createElement('path', {
                                strokeLinecap: 'round',
                                strokeLinejoin: 'round',
                                strokeWidth: 2,
                                d: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                            })
                        ),
                        wp.element.createElement(
                            'h3',
                            { style: { fontSize: '1.25rem', fontWeight: '600', marginBottom: '0.5rem', color: '#111827' } },
                            __('Child Pages Block', 'le-custom')
                        ),
                        wp.element.createElement(
                            'p',
                            { style: { color: '#6b7280', marginBottom: '1rem' } },
                            __('This block will display all child pages of the current page.', 'le-custom')
                        ),
                        wp.element.createElement(
                            'div',
                            { style: { fontSize: '0.875rem', color: '#6b7280' } },
                            wp.element.createElement('strong', null, __('Layout:', 'le-custom') + ' '),
                            layout === 'grid' ? __('Grid', 'le-custom') + ' (' + columns + ' ' + __('columns', 'le-custom') + ')' : __('List', 'le-custom'),
                            wp.element.createElement('br'),
                            wp.element.createElement('strong', null, __('Show Image:', 'le-custom') + ' '),
                            showImage ? __('Yes', 'le-custom') : __('No', 'le-custom'),
                            wp.element.createElement('br'),
                            wp.element.createElement('strong', null, __('Show Excerpt:', 'le-custom') + ' '),
                            showExcerpt ? __('Yes', 'le-custom') + ' (' + excerptLength + ' ' + __('words', 'le-custom') + ')' : __('No', 'le-custom')
                        )
                    )
                )
            ];
        },

        save: function () {
            // Dynamic block - rendered server-side
            return null;
        }
    });
})(window.wp);
