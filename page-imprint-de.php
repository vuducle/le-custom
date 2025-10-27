<?php

/**
 * Template Name: Imprint - German
 * 
 * Custom page template for German imprint
 */

// Get meta description and structured data
$meta_description = le_custom_get_meta_description();
$contact_data = le_custom_get_contact_data();

// Add SEO meta tags
add_action('wp_head', function () use ($meta_description, $contact_data) {
    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:title" content="Impressum - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:locale" content="de_DE" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="Impressum - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
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
                Impressum
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Rechtliche Informationen und Angaben gemäß § 5 TMG
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                <?php if (!empty($legal_data['imprint_de'])) : ?>
                    <div class="prose prose-lg max-w-none">
                        <?php echo wp_kses_post($legal_data['imprint_de']); ?>
                    </div>
                <?php else : ?>
                    <!-- Default Imprint Content -->
                    <div class="prose prose-lg max-w-none">
                        <h2>Angaben gemäß § 5 TMG</h2>

                        <h3>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h3>
                        <p>
                            <strong><?php echo esc_html($contact_data['practice_name']); ?></strong><br>
                            <?php echo esc_html($contact_data['address']['street']); ?><br>
                            <?php echo esc_html($contact_data['address']['city']); ?><br>
                            <?php echo esc_html($contact_data['address']['country']); ?>
                        </p>

                        <h3>Kontakt</h3>
                        <p>
                            Telefon: <a href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"><?php echo esc_html($contact_data['phone']['display']); ?></a><br>
                            E-Mail: <a href="mailto:<?php echo esc_attr($contact_data['email']); ?>"><?php echo esc_html($contact_data['email']); ?></a>
                        </p>

                        <h2>Berufsbezeichnung und berufsrechtliche Regelungen</h2>
                        <p><strong>Berufsbezeichnung:</strong> Zahnarzt</p>
                        <p><strong>Zuständige Kammer:</strong> Zahnärztekammer Berlin</p>
                        <p><strong>Verliehen durch:</strong> Deutschland</p>

                        <h2>Umsatzsteuer-ID</h2>
                        <p>Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:<br>
                            [Ihre USt-IdNr. hier einfügen]</p>

                        <h2>Redaktionell verantwortlich</h2>
                        <p>
                            <?php echo esc_html($contact_data['practice_name']); ?><br>
                            <?php echo esc_html($contact_data['address']['street']); ?><br>
                            <?php echo esc_html($contact_data['address']['city']); ?>
                        </p>

                        <h2>EU-Streitschlichtung</h2>
                        <p>Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit: <a href="https://ec.europa.eu/consumers/odr/" target="_blank" rel="noopener">https://ec.europa.eu/consumers/odr/</a>.<br>
                            Unsere E-Mail-Adresse finden Sie oben im Impressum.</p>

                        <h2>Verbraucherstreitbeilegung/Universalschlichtungsstelle</h2>
                        <p>Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p>

                        <h2>Haftung für Inhalte</h2>
                        <p>Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.</p>

                        <p>Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</p>

                        <h2>Haftung für Links</h2>
                        <p>Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.</p>

                        <p>Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.</p>

                        <h2>Urheberrecht</h2>
                        <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet.</p>

                        <p>Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.</p>

                        <p><em>Stand: <?php echo date('d.m.Y'); ?></em></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>