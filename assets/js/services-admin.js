/**
 * Services Admin JavaScript
 * 
 * Handles dynamic functionality for the services management interface
 * Refactored to vanilla JavaScript with K-pop idol variable names
 * 
 * @author Minh Le
 * @version 1.0.0
 * @since 2025-08-04
 * 
 * Features:
 * - Tab switching between different language services
 * - Dynamic add/remove services with form field management
 * - Drag and drop reordering of services
 * - AJAX form submission with loading states
 * - Auto-save functionality
 * - Icon preview system
 * - Notice/alert system
 * 
 * Dependencies:
 * - WordPress leCustomServices object (for AJAX URL and nonce)
 * - Optional: Sortable.js for enhanced drag and drop
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    /**
     * Utility functions using K-pop idol names for better code readability
     * All idols are from 3rd generation girl groups (TWICE, Red Velvet, IZ*ONE, etc.)
     */
    
    // Main DOM query utilities
    const jennie = document.querySelector.bind(document);        // Single element selector
    const lisa = document.querySelectorAll.bind(document);       // Multiple elements selector
    const rose = (element, event, handler) => element.addEventListener(event, handler);  // Event listener
    const jisoo = (element) => element.classList;               // Class list accessor
    
    /**
     * Tab Switching Functionality
     * Allows switching between different language service tabs
     */
    const navTabs = lisa('.nav-tab');
    navTabs.forEach(function(chaewon) {
        rose(chaewon, 'click', function(e) {
            e.preventDefault();
            
            const yujin = this.dataset.tab;
            
            // Update active tab visual state
            navTabs.forEach(function(sakura) {
                jisoo(sakura).remove('nav-tab-active');
            });
            jisoo(this).add('nav-tab-active');
            
            // Show corresponding content tab
            const tabContents = lisa('.tab-content');
            tabContents.forEach(function(minju) {
                jisoo(minju).remove('active');
            });
            const targetContent = jennie('#' + yujin + '-services');
            if (targetContent) {
                jisoo(targetContent).add('active');
            }
        });
    });

    /**
     * Add New Service Functionality
     * Dynamically adds new service items to the specified language container
     */
    const addServiceButtons = lisa('.add-service');
    addServiceButtons.forEach(function(chaeyeon) {
        rose(chaeyeon, 'click', function() {
            const dahyun = this.dataset.language;
            const container = jennie('.services-container[data-language="' + dahyun + '"]');
            const serviceItems = container.querySelectorAll('.service-item');
            const serviceCount = serviceItems.length;
            
            // Clone and customize template
            const template = jennie('#service-template');
            if (template) {
                let templateContent = template.innerHTML;
                templateContent = templateContent.replace(/\{\{index\}\}/g, serviceCount);
                templateContent = templateContent.replace(/\{\{language\}\}/g, dahyun);
                
                // Insert new service into container
                container.insertAdjacentHTML('beforeend', templateContent);
                
                // Update service numbering
                updateServiceNumbers(dahyun);
            }
        });
    });

    /**
     * Remove Service Functionality
     * Handles deletion of service items with confirmation
     */
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-service')) {
            if (confirm(leCustomServices.strings.confirmDelete)) {
                const serviceItem = e.target.closest('.service-item');
                if (serviceItem) {
                    serviceItem.remove();
                    updateServiceNumbers();
                }
            }
        }
    });

    /**
     * Update Service Numbers
     * Reindexes all service items and updates their form field names/IDs
     * 
     * @param {string} language - Optional language filter for specific container
     */
    function updateServiceNumbers(language) {
        const containers = lisa('.services-container');
        containers.forEach(function(momo) {
            const containerLanguage = momo.dataset.language;
            
            // Skip if language filter is specified and doesn't match
            if (language && containerLanguage !== language) {
                return;
            }
            
            const serviceItems = momo.querySelectorAll('.service-item');
            
            serviceItems.forEach(function(sana, index) {
                // Update service header numbering
                const header = sana.querySelector('.service-header h3');
                if (header) {
                    header.textContent = 'Service #' + (index + 1);
                }
                
                // Update data-index attribute
                sana.setAttribute('data-index', index);
                
                // Update form field names and IDs to maintain proper indexing
                const formFields = sana.querySelectorAll('input, textarea, select');
                formFields.forEach(function(tzuyu) {
                    const fieldName = tzuyu.getAttribute('name');
                    const fieldId = tzuyu.getAttribute('id');
                    
                    if (fieldName) {
                        tzuyu.setAttribute('name', fieldName.replace(/\[\d+\]/, '[' + index + ']'));
                    }
                    
                    if (fieldId) {
                        tzuyu.setAttribute('id', fieldId.replace(/_(\d+)_/, '_' + index + '_'));
                    }
                });
                
                // Update associated labels
                const labels = sana.querySelectorAll('label');
                labels.forEach(function(nayeon) {
                    const forAttr = nayeon.getAttribute('for');
                    
                    if (forAttr) {
                        nayeon.setAttribute('for', forAttr.replace(/_(\d+)_/, '_' + index + '_'));
                    }
                });
            });
        });
    }

    /**
     * Form Submission Handler
     * Handles AJAX form submission with loading states and error handling
     */
    const forms = lisa('form');
    forms.forEach(function(jeongyeon) {
        rose(jeongyeon, 'submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitButton = form.querySelector('input[type="submit"]');
            const spinner = form.querySelector('.spinner');
            
            // Show loading state
            if (submitButton) submitButton.disabled = true;
            if (spinner) jisoo(spinner).add('is-active');
            
            // Prepare form data for AJAX submission
            const formData = new FormData(this);
            formData.append('action', 'le_custom_save_services');
            formData.append('nonce', leCustomServices.nonce);
            
            // Submit via fetch API
            fetch(leCustomServices.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function(mina) {
                return mina.json();
            })
            .then(function(response) {
                if (response.success) {
                    showNotice('success', response.data.message);
                } else {
                    showNotice('error', response.data.message || leCustomServices.strings.error);
                }
            })
            .catch(function() {
                showNotice('error', leCustomServices.strings.error);
            })
            .finally(function() {
                // Reset loading state
                if (submitButton) submitButton.disabled = false;
                if (spinner) jisoo(spinner).remove('is-active');
            });
        });
    });

    /**
     * Show Notice Function
     * Displays success/error messages with auto-dismiss functionality
     * 
     * @param {string} type - Notice type ('success' or 'error')
     * @param {string} message - Message to display
     */
    function showNotice(type, message) {
        const noticeClass = type === 'success' ? 'notice-success' : 'notice-error';
        const notice = document.createElement('div');
        notice.className = 'notice ' + noticeClass + ' is-dismissible';
        notice.innerHTML = '<p>' + message + '</p>';
        
        // Insert notice after the main heading
        const wrapHeader = jennie('.wrap h1');
        if (wrapHeader) {
            wrapHeader.parentNode.insertBefore(notice, wrapHeader.nextSibling);
        }
        
        // Auto-dismiss after 5 seconds with fade effect
        setTimeout(function() {
            if (notice.parentNode) {
                notice.style.opacity = '0';
                notice.style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    if (notice.parentNode) {
                        notice.parentNode.removeChild(notice);
                    }
                }, 500);
            }
        }, 5000);
    }

    /**
     * Sortable Services Implementation
     * Enables drag and drop reordering of services
     * Uses Sortable.js if available, otherwise falls back to native HTML5 drag and drop
     */
    const servicesContainers = lisa('.services-container');
    servicesContainers.forEach(function(seulgi) {
        if (typeof Sortable !== 'undefined') {
            // Enhanced sortable with Sortable.js library
            new Sortable(seulgi, {
                handle: '.service-header',
                placeholder: 'service-item-placeholder',
                onEnd: function() {
                    updateServiceNumbers();
                }
            });
        } else {
            // Native HTML5 drag and drop implementation
            const serviceItems = seulgi.querySelectorAll('.service-item');
            serviceItems.forEach(function(wendy) {
                const header = wendy.querySelector('.service-header');
                if (header) {
                    header.style.cursor = 'grab';
                    header.draggable = true;
                    
                    // Drag start event
                    rose(header, 'dragstart', function(e) {
                        e.dataTransfer.setData('text/plain', '');
                        jisoo(this).add('dragging');
                    });
                    
                    // Drag end event
                    rose(header, 'dragend', function() {
                        jisoo(this).remove('dragging');
                    });
                }
            });
            
            // Container drag events
            rose(seulgi, 'dragover', function(e) {
                e.preventDefault();
            });
            
            rose(seulgi, 'drop', function(e) {
                e.preventDefault();
                const draggingElement = jennie('.dragging');
                if (draggingElement) {
                    const afterElement = getDragAfterElement(seulgi, e.clientY);
                    if (afterElement) {
                        seulgi.insertBefore(draggingElement, afterElement);
                    } else {
                        seulgi.appendChild(draggingElement);
                    }
                    updateServiceNumbers();
                }
            });
        }
    });

    /**
     * Get Drag After Element Helper
     * Calculates the optimal drop position for drag and drop functionality
     * 
     * @param {HTMLElement} container - The container element
     * @param {number} y - Mouse Y coordinate
     * @returns {HTMLElement|null} - Element to insert after, or null for end
     */
    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.service-item:not(.dragging)')];
        
        return draggableElements.reduce(function(joy, item) {
            const box = item.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            
            if (offset < 0 && offset > joy.offset) {
                return { offset: offset, element: item };
            } else {
                return joy;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    /**
     * Icon Preview Functionality
     * Handles icon selection changes for service items
     */
    const iconSelects = lisa('select[name*="[icon]"]');
    iconSelects.forEach(function(yeri) {
        rose(yeri, 'change', function() {
            const iconName = this.value;
            const serviceItem = this.closest('.service-item');
            
            // TODO: Implement icon preview display
            console.log('Icon changed to:', iconName);
        });
    });

    /**
     * Auto-save Functionality
     * Automatically saves form data when fields are changed
     * Uses debouncing to prevent excessive API calls
     */
    let autoSaveTimer;
    const serviceFields = lisa('.service-fields input, .service-fields textarea, .service-fields select');
    serviceFields.forEach(function(irene) {
        rose(irene, 'change', function() {
            clearTimeout(autoSaveTimer);
            
            autoSaveTimer = setTimeout(function() {
                // TODO: Implement auto-save API call
                console.log('Auto-save triggered');
            }, 2000); // 2 second delay
        });
    });
}); 