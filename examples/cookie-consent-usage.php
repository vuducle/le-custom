<?php

/**
 * Cookie Consent Usage Examples
 * 
 * This file demonstrates how to properly use the cookie consent system
 * with analytics and marketing scripts.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Example: Conditional Analytics Loading
 * 
 * Only load Google Analytics if the user has given consent
 */
function example_conditional_analytics()
{
    // Get cookie consent instance
    $cookie_consent = new LE_Cookie_Consent();

    // Check if user has given analytics consent
    if ($cookie_consent->has_consent('analytics')) {
        // Load Google Analytics
        wp_enqueue_script('google-analytics', 'https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID', [], null, false);

        // Add inline script to initialize GA
        wp_add_inline_script('google-analytics', "
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'GA_MEASUREMENT_ID', {
                'anonymize_ip': true,
                'cookie_flags': 'SameSite=None;Secure'
            });
        ");
    }
}
add_action('wp_enqueue_scripts', 'example_conditional_analytics');

/**
 * Example: Conditional Marketing Scripts
 * 
 * Only load Facebook Pixel if the user has given marketing consent
 */
function example_conditional_marketing()
{
    $cookie_consent = new LE_Cookie_Consent();

    if ($cookie_consent->has_consent('marketing')) {
        // Load Facebook Pixel
        wp_enqueue_script('facebook-pixel', 'https://connect.facebook.net/en_US/fbevents.js', [], null, false);

        wp_add_inline_script('facebook-pixel', "
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', 'YOUR_PIXEL_ID');
            fbq('track', 'PageView');
        ");
    }
}
add_action('wp_enqueue_scripts', 'example_conditional_marketing');

/**
 * Example: JavaScript-based Consent Checking
 * 
 * Add this to your theme's JavaScript file to handle consent changes
 */
function example_consent_change_handler()
{
?>
    <script>
        // Listen for consent changes
        document.addEventListener('cookieConsentChanged', function(event) {
            const consent = event.detail.consent;

            // Handle analytics consent
            if (consent.analytics) {
                // Initialize Google Analytics
                if (typeof gtag !== 'undefined') {
                    gtag('consent', 'update', {
                        'analytics_storage': 'granted'
                    });
                }

                // Initialize other analytics tools
                if (typeof _paq !== 'undefined') {
                    _paq.push(['rememberConsentGiven']);
                }
            } else {
                // Revoke analytics consent
                if (typeof gtag !== 'undefined') {
                    gtag('consent', 'update', {
                        'analytics_storage': 'denied'
                    });
                }
            }

            // Handle marketing consent
            if (consent.marketing) {
                // Initialize Facebook Pixel
                if (typeof fbq !== 'undefined') {
                    fbq('consent', 'grant');
                }

                // Initialize Google Ads
                if (typeof gtag !== 'undefined') {
                    gtag('consent', 'update', {
                        'ad_storage': 'granted'
                    });
                }
            } else {
                // Revoke marketing consent
                if (typeof fbq !== 'undefined') {
                    fbq('consent', 'revoke');
                }

                if (typeof gtag !== 'undefined') {
                    gtag('consent', 'update', {
                        'ad_storage': 'denied'
                    });
                }
            }
        });

        // Check consent on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof LE_Cookie_Consent !== 'undefined') {
                const hasAnalytics = LE_Cookie_Consent.hasConsent('analytics');
                const hasMarketing = LE_Cookie_Consent.hasConsent('marketing');

                if (hasAnalytics) {
                    // Load analytics scripts dynamically
                    loadAnalyticsScripts();
                }

                if (hasMarketing) {
                    // Load marketing scripts dynamically
                    loadMarketingScripts();
                }
            }
        });

        function loadAnalyticsScripts() {
            // Load Google Analytics
            const gaScript = document.createElement('script');
            gaScript.src = 'https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID';
            gaScript.async = true;
            document.head.appendChild(gaScript);

            gaScript.onload = function() {
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());
                gtag('config', 'GA_MEASUREMENT_ID', {
                    'anonymize_ip': true,
                    'cookie_flags': 'SameSite=None;Secure'
                });
            };
        }

        function loadMarketingScripts() {
            // Load Facebook Pixel
            const fbScript = document.createElement('script');
            fbScript.src = 'https://connect.facebook.net/en_US/fbevents.js';
            fbScript.async = true;
            document.head.appendChild(fbScript);

            fbScript.onload = function() {
                ! function(f, b, e, v, n, t, s) {
                    if (f.fbq) return;
                    n = f.fbq = function() {
                        n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                    };
                    if (!f._fbq) f._fbq = n;
                    n.push = n;
                    n.loaded = !0;
                    n.version = '2.0';
                    n.queue = [];
                    t = b.createElement(e);
                    t.async = !0;
                    t.src = v;
                    s = b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t, s)
                }(window, document, 'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', 'YOUR_PIXEL_ID');
                fbq('track', 'PageView');
            };
        }
    </script>
    <?php
}
add_action('wp_footer', 'example_consent_change_handler');

/**
 * Example: Custom Consent Management
 * 
 * Add a consent management page or widget
 */
function example_consent_management_widget()
{
    $cookie_consent = new LE_Cookie_Consent();
    $has_consent = $cookie_consent->has_consent();

    if ($has_consent) {
    ?>
        <div class="consent-management-widget">
            <h3>Cookie-Einstellungen</h3>
            <p>Sie können Ihre Cookie-Einstellungen jederzeit ändern:</p>

            <div class="consent-options">
                <label>
                    <input type="checkbox"
                        id="manage-analytics"
                        <?php echo $cookie_consent->has_consent('analytics') ? 'checked' : ''; ?>
                        onchange="updateConsent('analytics', this.checked)">
                    Analyse-Cookies
                </label>

                <label>
                    <input type="checkbox"
                        id="manage-marketing"
                        <?php echo $cookie_consent->has_consent('marketing') ? 'checked' : ''; ?>
                        onchange="updateConsent('marketing', this.checked)">
                    Marketing-Cookies
                </label>
            </div>

            <button onclick="saveConsentPreferences()" class="button">
                Einstellungen speichern
            </button>
        </div>

        <script>
            function updateConsent(type, enabled) {
                const consentData = LE_Cookie_Consent.getConsentData() || {};
                consentData[type] = enabled;

                // Update cookie locally
                const cookieValue = JSON.stringify({
                    consent_given: true,
                    timestamp: Math.floor(Date.now() / 1000),
                    necessary: true,
                    analytics: consentData.analytics || false,
                    marketing: consentData.marketing || false,
                    version: '1.0'
                });

                const expires = new Date(Date.now() + (31536000 * 1000));
                document.cookie = `le_cookie_consent=${encodeURIComponent(cookieValue)}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
            }

            function saveConsentPreferences() {
                const analytics = document.getElementById('manage-analytics').checked;
                const marketing = document.getElementById('manage-marketing').checked;

                const consentData = {
                    necessary: true,
                    analytics: analytics,
                    marketing: marketing
                };

                // Trigger consent change event
                const event = new CustomEvent('cookieConsentChanged', {
                    detail: {
                        consent: consentData,
                        timestamp: Date.now()
                    }
                });

                document.dispatchEvent(event);

                alert('Einstellungen gespeichert!');
            }
        </script>
    <?php
    }
}

/**
 * Example: Privacy Policy Integration
 * 
 * Add consent information to privacy policy
 */
function example_privacy_policy_content()
{
    if (is_page('privacy-policy-de') || is_page('privacy-policy-en')) {
    ?>
        <div class="cookie-consent-info">
            <h2>Cookie-Einstellungen</h2>
            <p>Diese Website verwendet Cookies und ähnliche Technologien. Sie können Ihre Einstellungen jederzeit ändern:</p>

            <h3>Notwendige Cookies</h3>
            <p>Diese Cookies sind für die Grundfunktionen der Website erforderlich und können nicht deaktiviert werden.</p>

            <h3>Analyse-Cookies</h3>
            <p>Diese Cookies helfen uns dabei, die Nutzung unserer Website zu verstehen und zu verbessern.</p>

            <h3>Marketing-Cookies</h3>
            <p>Diese Cookies werden verwendet, um Ihnen relevante Werbung und Inhalte anzuzeigen.</p>

            <?php example_consent_management_widget(); ?>
        </div>
    <?php
    }
}
add_action('the_content', 'example_privacy_policy_content');

/**
 * Example: GDPR Compliance Helper
 * 
 * Add GDPR compliance information to footer
 */
function example_gdpr_footer_info()
{
    $cookie_consent = new LE_Cookie_Consent();

    if ($cookie_consent->has_consent()) {
        $consent_data = $cookie_consent->get_consent_status();
        $consent_date = date('d.m.Y H:i', $consent_data['timestamp']);

    ?>
        <div class="gdpr-info">
            <small>
                Cookie-Zustimmung erteilt am: <?php echo $consent_date; ?> |
                <a href="<?php echo get_privacy_policy_url(); ?>">Datenschutzerklärung</a> |
                <a href="#" onclick="showConsentOverlay()">Einstellungen ändern</a>
            </small>
        </div>

        <script>
            function showConsentOverlay() {
                // Clear existing consent to show overlay again
                document.cookie = 'le_cookie_consent=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                location.reload();
            }
        </script>
        <?php
    }
}
add_action('wp_footer', 'example_gdpr_footer_info');

/**
 * Example: E-commerce Integration
 * 
 * Handle consent for e-commerce tracking
 */
function example_ecommerce_consent()
{
    $cookie_consent = new LE_Cookie_Consent();

    if ($cookie_consent->has_consent('marketing') && is_woocommerce()) {
        // Add enhanced e-commerce tracking
        wp_add_inline_script('google-analytics', "
            gtag('config', 'GA_MEASUREMENT_ID', {
                'send_page_view': false,
                'enhanced_ecommerce': true
            });
        ");

        // Track purchases
        add_action('woocommerce_thankyou', function ($order_id) {
            $order = wc_get_order($order_id);
            if ($order) {
        ?>
                <script>
                    gtag('event', 'purchase', {
                        'transaction_id': '<?php echo $order->get_id(); ?>',
                        'value': <?php echo $order->get_total(); ?>,
                        'currency': '<?php echo $order->get_currency(); ?>',
                        'items': [
                            <?php
                            foreach ($order->get_items() as $item) {
                                $product = $item->get_product();
                                echo "{
                                'item_id': '" . $product->get_id() . "',
                                'item_name': '" . addslashes($product->get_name()) . "',
                                'quantity': " . $item->get_quantity() . ",
                                'price': " . $item->get_total() . "
                            },";
                            }
                            ?>
                        ]
                    });
                </script>
<?php
            }
        });
    }
}
add_action('wp_enqueue_scripts', 'example_ecommerce_consent');
