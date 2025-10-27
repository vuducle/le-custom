/**
 * LE Custom Theme Customizer JavaScript
 * 
 * Handles live preview updates for the contact information bar
 * 
 * Valve-style documentation:
 * - denisKunz: Main contact bar element selector
 * - addressElement: DOM element for address display
 * - phoneElement: DOM element for phone number display
 * - emailElement: DOM element for email display
 * - contactBar: Main contact information bar container
 * - newval: New value from customizer setting
 * - placement: Selective refresh placement object
 */

(function() {
    'use strict';

    // Contact Information Bar Live Preview
    wp.customize('contact_address', function(value) {
        value.bind(function(newval) {
            var addressElement = document.querySelector('.contact-info-bar span:first-child');
            if (addressElement) {
                addressElement.textContent = newval;
            }
        });
    });

    wp.customize('contact_phone', function(value) {
        value.bind(function(newval) {
            var phoneElement = document.querySelector('.contact-info-bar a[href^="tel:"]');
            if (phoneElement) {
                phoneElement.textContent = 'Telefon: ' + newval;
            }
        });
    });

    wp.customize('contact_phone_link', function(value) {
        value.bind(function(newval) {
            var phoneElement = document.querySelector('.contact-info-bar a[href^="tel:"]');
            if (phoneElement) {
                phoneElement.setAttribute('href', 'tel:' + newval);
            }
        });
    });

    wp.customize('contact_email', function(value) {
        value.bind(function(newval) {
            var emailElement = document.querySelector('.contact-info-bar a[href^="mailto:"]');
            if (emailElement) {
                emailElement.textContent = 'E-Mail: ' + newval;
                emailElement.setAttribute('href', 'mailto:' + newval);
            }
        });
    });

    wp.customize('show_contact_bar', function(value) {
        value.bind(function(newval) {
            var contactBar = document.querySelector('.contact-info-bar');
            if (contactBar) {
                if (newval) {
                    contactBar.style.display = 'block';
                } else {
                    contactBar.style.display = 'none';
                }
            }
        });
    });

    wp.customize('contact_bar_bg_color', function(value) {
        value.bind(function(newval) {
            var denisKunz = document.querySelector('.contact-info-bar');
            if (denisKunz) {
                denisKunz.style.backgroundColor = newval;
            }
        });
    });

    wp.customize('contact_bar_text_color', function(value) {
        value.bind(function(newval) {
            var flexElement = document.querySelector('.contact-info-bar .flex');
            var linkElements = document.querySelectorAll('.contact-info-bar a');
            
            if (flexElement) {
                flexElement.style.color = newval;
            }
            
            linkElements.forEach(function(linkElement) {
                linkElement.style.color = newval;
            });
        });
    });

    // Footer Background Image Live Preview
    wp.customize('footer_background_image', function(value) {
        value.bind(function(newval) {
            var footer = document.querySelector('footer');
            var overlay = document.querySelector('footer .absolute.inset-0');
            
            if (footer) {
                if (newval) {
                    footer.style.backgroundImage = 'url(' + newval + ')';
                    footer.style.backgroundSize = 'cover';
                    footer.style.backgroundPosition = 'center';
                    footer.style.backgroundRepeat = 'no-repeat';
                    
                    // Add overlay if it doesn't exist
                    if (!overlay) {
                        var newOverlay = document.createElement('div');
                        newOverlay.className = 'absolute inset-0 bg-gray-900 bg-opacity-80';
                        footer.insertBefore(newOverlay, footer.firstChild);
                    }
                } else {
                    footer.style.backgroundImage = '';
                    footer.style.backgroundSize = '';
                    footer.style.backgroundPosition = '';
                    footer.style.backgroundRepeat = '';
                    
                    // Remove overlay if it exists
                    if (overlay) {
                        overlay.remove();
                    }
                }
            }
        });
    });

    // Google Maps iframe URL Live Preview
    wp.customize('google_maps_iframe_url', function(value) {
        value.bind(function(newval) {
            var iframe = document.querySelector('footer iframe');
            var mapsColumn = document.querySelector('footer .lg\\:grid-cols-3 > div:nth-child(2)');
            
            if (newval && iframe) {
                iframe.src = newval;
            } else if (newval && !iframe && mapsColumn) {
                // Create new maps section if it doesn't exist
                mapsColumn.innerHTML = '<div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-4 shadow-2xl h-full"><iframe src="' + newval + '" width="100%" height="400" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>';
            } else if (!newval && mapsColumn) {
                mapsColumn.innerHTML = '<div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-8 shadow-2xl h-full flex items-center justify-center"><p class="text-white/80">Google Maps wird hier angezeigt</p></div>';
            }
        });
    });

    // Show/Hide Google Maps Live Preview
    wp.customize('show_google_maps', function(value) {
        value.bind(function(newval) {
            var mapsColumn = document.querySelector('footer .lg\\:grid-cols-3 > div:nth-child(2)');
            
            if (mapsColumn) {
                if (newval) {
                    mapsColumn.style.display = 'block';
                } else {
                    mapsColumn.style.display = 'none';
                }
            }
        });
    });

    // Google My Business Name Live Preview
    wp.customize('google_my_business_name', function(value) {
        value.bind(function(newval) {
            // Trigger a page refresh to update the dynamic Google Maps URL
            // This is necessary because the maps URL is generated server-side
            wp.customize.previewer.refresh();
        });
    });

    // Footer Contact Information Live Preview
    wp.customize('footer_practice_name', function(value) {
        value.bind(function(newval) {
            var practiceName = document.querySelector('footer h2');
            if (practiceName) {
                practiceName.textContent = newval;
            }
        });
    });

    wp.customize('footer_address_street', function(value) {
        value.bind(function(newval) {
            var addressStreet = document.querySelector('footer .text-white\\/80:nth-of-type(1)');
            if (addressStreet) {
                addressStreet.textContent = newval;
            }
        });
    });

    wp.customize('footer_address_city', function(value) {
        value.bind(function(newval) {
            var addressCity = document.querySelector('footer .text-white\\/80:nth-of-type(2)');
            if (addressCity) {
                addressCity.textContent = newval;
            }
        });
    });

    wp.customize('footer_phone', function(value) {
        value.bind(function(newval) {
            var phoneElement = document.querySelector('footer .text-white\\/80:nth-of-type(3)');
            if (phoneElement) {
                phoneElement.textContent = newval;
            }
        });
    });

    wp.customize('footer_email', function(value) {
        value.bind(function(newval) {
            var emailLink = document.querySelector('footer a[href^="mailto:"]');
            if (emailLink) {
                emailLink.textContent = newval;
                emailLink.href = 'mailto:' + newval;
            }
        });
    });

    wp.customize('footer_opening_monday', function(value) {
        value.bind(function(newval) {
            var mondayHours = document.querySelector('footer .text-white\\/80:nth-of-type(5)');
            if (mondayHours) {
                mondayHours.textContent = newval;
            }
        });
    });

    wp.customize('footer_opening_tuesday_thursday', function(value) {
        value.bind(function(newval) {
            var tuesdayThursdayHours = document.querySelector('footer .text-white\\/80:nth-of-type(6)');
            if (tuesdayThursdayHours) {
                tuesdayThursdayHours.textContent = newval;
            }
        });
    });

    wp.customize('footer_opening_wednesday_friday', function(value) {
        value.bind(function(newval) {
            var wednesdayFridayHours = document.querySelector('footer .text-white\\/80:nth-of-type(7)');
            if (wednesdayFridayHours) {
                wednesdayFridayHours.textContent = newval;
            }
        });
    });

    wp.customize('footer_languages', function(value) {
        value.bind(function(newval) {
            var languagesElement = document.querySelector('footer .text-white\\/80:last-of-type');
            if (languagesElement) {
                languagesElement.textContent = newval;
            }
        });
    });



    // Color Scheme Live Preview
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--primary-color', newval);
            
            // Update specific elements that use primary color
            var navLinks = document.querySelectorAll('.nav-link::after');
            var currentMenuItems = document.querySelectorAll('.current-menu-item > a');
            var focusElements = document.querySelectorAll('.nav-link:focus, button:focus');
            var scrollbarThumb = document.querySelector('::-webkit-scrollbar-thumb');
            
            // Update active menu items
            currentMenuItems.forEach(function(element) {
                element.style.color = newval + ' !important';
                element.style.borderBottomColor = newval;
            });
            
            // Update focus states
            focusElements.forEach(function(element) {
                element.style.outlineColor = newval;
            });
        });
    });

    wp.customize('secondary_color', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--secondary-color', newval);
            
            // Update scrollbar hover state
            var scrollbarThumb = document.querySelector('::-webkit-scrollbar-thumb');
            if (scrollbarThumb) {
                scrollbarThumb.style.setProperty('--secondary-color', newval);
            }
        });
    });

    wp.customize('primary_color_light', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--primary-color-light', newval);
            
            // Update services section background
            var servicesSection = document.querySelector('.services-section');
            if (servicesSection) {
                servicesSection.style.backgroundColor = newval;
            }
            
            // Update submenu hover states
            var submenuLinks = document.querySelectorAll('.submenu a:hover');
            submenuLinks.forEach(function(element) {
                element.style.backgroundColor = newval;
            });
        });
    });

    wp.customize('secondary_color_light', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--secondary-color-light', newval);
        });
    });

    // Selective refresh for contact information
    wp.customize.selectiveRefresh.bind('partial-content-rendered', function(placement) {
        if (placement.partial.id === 'contact_information') {
            // Re-initialize any JavaScript that might be needed for the contact bar
            console.log('Contact information bar refreshed');
        }
    });

})(); 