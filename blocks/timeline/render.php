<?php
/**
 * Timeline Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? 'Fases de Candidatura';
$section_subtitle = $attributes['sectionSubtitle'] ?? '';
$phases = $attributes['phases'] ?? [];
$layout = $attributes['layout'] ?? 'horizontal';
$style = $attributes['style'] ?? 'default';

$block_id = 'timeline-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'timeline-section layout-' . esc_attr($layout) . ' style-' . esc_attr($style),
));

if (empty($phases)) {
    return;
}

// Icons
$icons = array(
    'calendar' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
    'edit' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
    'check' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
    'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
    'star' => '<svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
    'document' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
    'user' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
    'email' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
);

// Color map
$colors = array(
    'cyan' => '#00d084',
    'lavender' => '#8887e2',
    'coral' => '#ff6b6b',
    'purple' => '#572ddf',
    'pink' => '#da2489',
    'green' => '#34d399',
);
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="container">
        <?php if ($section_title || $section_subtitle) : ?>
            <div class="section-header text-center">
                <?php if ($section_title) : ?>
                    <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>
                <?php if ($section_subtitle) : ?>
                    <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="timeline-wrapper">
            <?php if ($layout === 'horizontal') : ?>
                <div class="timeline-line"></div>
            <?php endif; ?>

            <div class="timeline-items">
                <?php foreach ($phases as $index => $phase) :
                    $icon = $phase['icon'] ?? 'calendar';
                    $color = $phase['color'] ?? 'cyan';
                    $color_value = $colors[$color] ?? $colors['cyan'];
                    $label = $phase['label'] ?? '';
                    $title = $phase['title'] ?? '';
                    $dates = $phase['dates'] ?? '';
                    $description = $phase['description'] ?? '';
                ?>
                    <div class="timeline-item" style="--phase-color: <?php echo esc_attr($color_value); ?>;">
                        <div class="timeline-marker">
                            <div class="timeline-icon">
                                <?php echo isset($icons[$icon]) ? $icons[$icon] : $icons['calendar']; ?>
                            </div>
                            <?php if ($layout === 'vertical') : ?>
                                <div class="timeline-connector"></div>
                            <?php endif; ?>
                        </div>

                        <div class="timeline-content">
                            <?php if ($label) : ?>
                                <span class="timeline-label"><?php echo esc_html($label); ?></span>
                            <?php endif; ?>

                            <?php if ($title) : ?>
                                <h3 class="timeline-title"><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>

                            <?php if ($dates) : ?>
                                <div class="timeline-dates">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <?php echo esc_html($dates); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($description) : ?>
                                <p class="timeline-description"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
