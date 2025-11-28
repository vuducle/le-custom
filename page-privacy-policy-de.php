<?php

/**
 * Template Name: Privacy Policy - German
 * 
 * Custom page template for German privacy policy
 */

// Get meta description and structured data
$meta_description = le_custom_get_meta_description();
$contact_data = le_custom_get_contact_data();

// Add SEO meta tags
add_action('wp_head', function () use ($meta_description, $contact_data) {
    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:title" content="Datenschutz - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:locale" content="de_DE" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="Datenschutz - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '" />' . "\n";
});

// Output structured data
le_custom_output_subpage_structured_data();

get_header();

// Get customizer data
$contact_data = le_custom_get_contact_data();
$legal_data = $contact_data['legal'];
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 lg:py-20">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12 lg:mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Datenschutzerklärung
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Informationen zum Schutz Ihrer persönlichen Daten
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                <?php if (!empty($legal_data['privacy_policy_de'])) : ?>
                    <div class="prose prose-lg max-w-none">
                        <?php echo wp_kses_post($legal_data['privacy_policy_de']); ?>
                    </div>
                <?php else : ?>
                    <!-- Default Privacy Policy Content -->
                    <div class="prose prose-lg max-w-none">
                        <h2>1. Datenschutz auf einen Blick</h2>

                        <h3>Allgemeine Hinweise</h3>
                        <p>Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren personenbezogenen
                            Daten passiert, wenn Sie diese Website besuchen. Personenbezogene Daten sind alle Daten, mit
                            denen Sie persönlich identifiziert werden können. Ausführliche Informationen zum Thema
                            Datenschutz entnehmen Sie unserer unter diesem Text aufgeführten Datenschutzerklärung.</p>

                        <h3>Datenerfassung auf dieser Website</h3>
                        <p><strong>Wer ist verantwortlich für die Datenerfassung auf dieser Website?</strong></p>
                        <p>Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen Kontaktdaten
                            können Sie dem Abschnitt „Hinweis zur Verantwortlichen Stelle" in dieser Datenschutzerklärung
                            entnehmen.</p>

                        <h3>Wie erfassen wir Ihre Daten?</h3>
                        <p>Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen. Hierbei kann es sich
                            z. B. um Daten handeln, die Sie in ein Kontaktformular eingeben.</p>
                        <p>Andere Daten werden automatisch oder nach Ihrer Einwilligung beim Besuch der Website durch unsere
                            IT-Systeme erfasst. Das sind vor allem technische Daten (z. B. Internetbrowser, Betriebssystem
                            oder Uhrzeit des Seitenaufrufs). Die Erfassung dieser Daten erfolgt automatisch, sobald Sie
                            diese Website betreten.</p>

                        <h3>Wofür nutzen wir Ihre Daten?</h3>
                        <p>Ein Teil der Daten wird erhoben, um eine fehlerfreie Bereitstellung der Website zu gewährleisten.
                            Andere Daten können zur Analyse Ihres Nutzerverhaltens verwendet werden.</p>

                        <h3>Welche Rechte haben Sie bezüglich Ihrer Daten?</h3>
                        <p>Sie haben jederzeit das Recht, unentgeltlich Auskunft über Herkunft, Empfänger und Zweck Ihrer
                            gespeicherten personenbezogenen Daten zu erhalten. Sie haben außerdem ein Recht, die
                            Berichtigung oder Löschung dieser Daten zu verlangen. Wenn Sie eine Einwilligung zur
                            Datenverarbeitung erteilt haben, können Sie diese Einwilligung jederzeit für die Zukunft
                            widerrufen. Außerdem haben Sie das Recht, unter bestimmten Umständen die Einschränkung der
                            Verarbeitung Ihrer personenbezogenen Daten zu verlangen. Des Weiteren steht Ihnen ein
                            Beschwerderecht bei der zuständigen Aufsichtsbehörde zu.</p>

                        <h2>2. Hosting</h2>
                        <p>Wir hosten unsere Website bei einem professionellen Hosting-Dienstleister, der die technische
                            Infrastruktur für unsere Website bereitstellt.</p>

                        <h2>3. Allgemeine Hinweise und Pflichtinformationen</h2>

                        <h3>Datenschutz</h3>
                        <p>Die Betreiber dieser Seiten nehmen den Schutz Ihrer persönlichen Daten sehr ernst. Wir behandeln
                            Ihre personenbezogenen Daten vertraulich und entsprechend den gesetzlichen
                            Datenschutzvorschriften sowie dieser Datenschutzerklärung.</p>

                        <h3>Hinweis zur verantwortlichen Stelle</h3>
                        <p>Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>
                        <p>
                            <strong><?php echo esc_html($contact_data['practice_name']); ?></strong><br>
                            <?php echo esc_html($contact_data['address']['street']); ?><br>
                            <?php echo esc_html($contact_data['address']['city']); ?><br>
                            <?php echo esc_html($contact_data['address']['country']); ?>
                        </p>
                        <p>
                            Telefon: <a
                                href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"><?php echo esc_html($contact_data['phone']['display']); ?></a><br>
                            E-Mail: <a
                                href="mailto:<?php echo esc_attr($contact_data['email']); ?>"><?php echo esc_html($contact_data['email']); ?></a>
                        </p>

                        <h2>4. Welchem Zweck dienen Ihre Daten und mit welcher Rechtfertigung dürfen wir diese nutzen?</h2>

                        <p>Wenn Sie unsere Internetseite nutzen, um sich über unsere Praxis zu informieren, erheben wir
                            grundsätzlich keine personenbezogenen Daten. Wird die Website jedoch technisch ausgeliefert,
                            erhebt unser Serviceprovider Daten, die aus technischen Gründen erforderlich sind, um Ihnen
                            die Seite anzuzeigen und die Stabilität sowie Sicherheit zu gewährleisten. Die Rechtsgrundlage
                            hierfür ist Art. 6 Abs. 1 S. 1 lit. f DSGVO (berechtigtes Interesse):</p>

                        <ul>
                            <li>IP-Adresse</li>
                            <li>Datum und Uhrzeit der Anfrage</li>
                            <li>Zeitzonendifferenz zur Greenwich Mean Time (GMT)</li>
                            <li>Inhalt der Anforderung (konkrete Seite)</li>
                            <li>Zugriffsstatus / HTTP-Statuscode</li>
                            <li>Jeweils übertragene Datenmenge</li>
                            <li>Website, von der die Anforderung kommt (Referrer)</li>
                            <li>Browser</li>
                            <li>Betriebssystem und dessen Oberfläche</li>
                            <li>Sprache und Version der Browsersoftware</li>
                        </ul>

                        <p>Bei der Nutzung unserer Internetseite werden von uns keine Cookies auf Ihrem Rechner gespeichert.
                        </p>

                        <h2>5. Welche Rechte haben Sie im Zusammenhang mit dem Datenschutz?</h2>

                        <p>Grundsätzlich stehen Ihnen die nachfolgenden Rechte zu. Da im Rahmen des bloßen Besuchs unserer
                            Website keine personenbezogenen Daten von uns erhoben werden (siehe oben), sind diese Rechte
                            für einen rein informatorischen Webseitenbesuch in der Regel nicht einschlägig. Für den Fall,
                            dass personenbezogene Daten im Rahmen eines telefonischen oder E‑Mail-Kontakts anfallen,
                            gelten jedoch die folgenden Rechte:</p>

                        <ul>
                            <li>Recht auf Auskunft</li>
                            <li>Recht auf Berichtigung oder Löschung</li>
                            <li>Recht auf Einschränkung der Verarbeitung</li>
                            <li>Recht auf Widerspruch gegen die Verarbeitung</li>
                            <li>Recht auf Datenübertragbarkeit</li>
                        </ul>

                        <h2>6. Externe Daten</h2>

                        <p>Für einzelne Funktionen unserer Internetseite greifen wir weitestgehend nicht auf externe
                            Dienstleister zurück. Wo externe Inhalte eingebunden sind, handelt es sich überwiegend um
                            Links (z. B. zu Google Maps). Auf die Inhalte dieser externen Anbieter haben wir keinen
                            Einfluss; die Verantwortung hierfür liegt bei den jeweiligen Anbietern.</p>

                        <h2>7. Wie können Sie sich ggf. beschweren?</h2>

                        <p>Sie haben die Möglichkeit, sich mit einer Beschwerde im Zusammenhang mit der Datenverarbeitung
                            an die für uns zuständige Datenschutzaufsicht zu wenden:</p>

                        <p>
                            Frau<br>
                            Maja Smoltczyk<br>
                            Friedrichstr. 219<br>
                            10969 Berlin<br>
                            Telefon: 030/13889-0
                        </p>

                        <h2>8. Änderungen</h2>
                        <p>Wir behalten uns vor, diese Datenschutzerklärung anzupassen, damit sie stets den aktuellen
                            rechtlichen Anforderungen entspricht oder um Änderungen unserer Leistungen in der
                            Datenschutzerklärung umzusetzen, z. B. bei der Einführung neuer Services.</p>

                        <h2>9. Einsatz von Google reCAPTCHA</h2>
                        <p>Zum Schutz unserer Kontaktformulare und zur Verhinderung von automatisiertem Spam setzen wir
                            Google reCAPTCHA der Firma Google LLC ein. Dabei können personenbezogene Daten wie Ihre
                            IP‑Adresse und weitere Informationen an Server von Google in den USA übertragen und dort
                            verarbeitet werden. Zweck der Datenverarbeitung ist die Unterscheidung zwischen menschlichen
                            Nutzern und automatisierten Zugriffen. Die Rechtsgrundlage ist Art. 6 Abs. 1 S. 1 lit. f DSGVO
                            (berechtigtes Interesse), sofern nicht zuvor eine Einwilligung eingeholt wurde.</p>

                        <p>Weitere Informationen zu Google reCAPTCHA und den Datenverarbeitungspraktiken von Google finden
                            Sie in den Google‑Datenschutzhinweisen: <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">https://policies.google.com/privacy</a>
                            und der reCAPTCHA‑Dokumentation: <a href="https://developers.google.com/recaptcha" target="_blank" rel="noopener">https://developers.google.com/recaptcha</a>.</p>

                        <h2>10. Verwendung von WordPress</h2>
                        <p>Unsere Website basiert auf dem Content‑Management‑System WordPress. WordPress kann technische
                            Daten, Benutzerdaten (z. B. bei Anmeldung) und ggf. Kommentardaten in unserer Datenbank
                            speichern. Darüber hinaus verwendet WordPress funktionale Cookies für eingeloggte Benutzer.
                            Zweck und Umfang der Datenerhebung richten sich nach den eingesetzten Funktionen (z. B.
                            Login/Administrationsbereich oder Kommentarfunktion).</p>

                        <p>Weitere Informationen zum Datenschutz im Zusammenhang mit WordPress finden Sie hier:
                            <a href="https://wordpress.org/about/privacy/" target="_blank" rel="noopener">https://wordpress.org/about/privacy/</a>.
                        </p>

                        <p><em>Stand: <?php echo date('d.m.Y'); ?></em></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>