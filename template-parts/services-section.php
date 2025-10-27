<?php

/**
 * Services Section Template Part
 * 
 * Displays the services section with glassmorphism design
 */

// Ensure WordPress functions are available
if (!function_exists('esc_attr')) {
    function esc_attr($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_html')) {
    function esc_html($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_url')) {
    function esc_url($url)
    {
        return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    }
}

// Get services data
$services_data = le_custom_get_services_data();
$services_title = $services_data['title'];
$services_description = $services_data['description'];
$services_list = $services_data['list'];
$show_services = $services_data['show'];
$services_position = $services_data['position'];

// Fallback: If no services are configured, show default ones
if (empty($services_list)) {
    $services_list = [
        [
            'title' => 'Zahnästhetik',
            'description' => 'Lücken, Fehlstellungen und Verfärbungen beeinträchtigen unser ästhetisches Empfinden. Mit Veneers, Bleaching und Co. verbessern wir die Zahnästhetik!',
            'button_text' => 'Mehr erfahren',
            'button_url' => '#',
            'icon' => 'aesthetic'
        ],
        [
            'title' => 'Zahnersatz & Zahnerhaltung',
            'description' => 'Geht es um Zahnersatz oder die Rettung Ihrer Zähne, bieten sich verschiedene Optionen an. Gerne beraten wir Sie in unserer Praxis individuell und fachgerecht!',
            'button_text' => 'Mehr erfahren',
            'button_url' => '#',
            'icon' => 'prosthetics'
        ],
        [
            'title' => 'Kinderzahnheilkunde',
            'description' => 'Als Kinderzahnarzt haben wir uns auf die Behandlung kleiner Patienten spezialisiert. Wir begleiten Ihr Kind in allen Fragen der Zahnmedizin!',
            'button_text' => 'Mehr erfahren',
            'button_url' => '#',
            'icon' => 'pediatric'
        ],
        [
            'title' => 'Parodontologie',
            'description' => 'Parodontitis ist als Volkskrankheit einzustufen - fast jeder Mensch ist im Laufe seines Lebens davon betroffen. Erfahren Sie mehr über die Behandlung!',
            'button_text' => 'Mehr erfahren',
            'button_url' => '#',
            'icon' => 'periodontics'
        ]
    ];
}

// Don't display if disabled
if (!$show_services || empty($services_list)) {
    return;
}



// Get icon SVG based on icon name
function le_custom_get_service_icon($icon_name)
{
    $icons = [
        'aesthetic' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 7l3-3m0 0h-3m3 0v3"></path></svg>',
        'prosthetics' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'pediatric' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>',
        'periodontics' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>',
        'surgery' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'hygiene' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
        'orthodontics' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 7l3-3m0 0h-3m3 0v3"></path></svg>',
        'implantology' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>',
        'emergency' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
        'default' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'
    ];

    return $icons[$icon_name] ?? $icons['default'];
}

// Get color scheme data
$color_scheme = le_custom_get_color_scheme_data();

// Determine section classes based on position
$section_classes = 'services-section ';
$container_classes = '';

if ($services_position === 'overlay') {
    $section_classes .= 'relative -mt-16 py-10';
    $container_classes = 'backdrop-blur-md border shadow-2xl';
} else {
    $section_classes .= 'py-20 my-24';
    $container_classes = 'bg-white/80 backdrop-blur-sm border';
}
?>

<section class="<?php echo esc_attr($section_classes); ?>"
    style="background-color: <?php echo esc_attr($color_scheme['primary_light']); ?>;">
    <div class="container mx-auto px-4">
        <?php if ($services_position === 'separate'): ?>
            <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html($services_title); ?>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    <?php echo esc_html($services_description); ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($services_list as $index => $service): ?>
                <div class="<?php echo esc_attr($container_classes); ?> p-6 rounded-xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 text-gray-900"
                    style="border-color: <?php echo esc_attr($color_scheme['primary']); ?>20;"
                    data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>" data-aos-duration="800">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4"
                        style="background-color: <?php echo esc_attr($color_scheme['primary_light']); ?>;">
                        <?php echo le_custom_get_service_icon($service['icon'] ?? 'default'); ?>
                    </div>
                    <h3 class="text-lg font-semibold mb-3 text-gray-900">
                        <?php echo esc_html($service['title']); ?>
                    </h3>
                    <p class="text-sm mb-4 text-gray-700 leading-relaxed">
                        <?php echo esc_html($service['description']); ?>
                    </p>
                    <?php if (!empty($service['button_text'])): ?>
                        <a href="<?php echo esc_url($service['button_url']); ?>"
                            class="inline-block text-white border px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                            style="background-color: <?php echo esc_attr($color_scheme['primary']); ?>; border-color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                            <?php echo esc_html($service['button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>