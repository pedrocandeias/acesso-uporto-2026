<?php
/**
 * Timeline Block Template
 *
 * @package AcessoUPorto
 */

$section_title = get_field('section_title') ?: __('Fases de Candidatura', 'acesso-uporto');
$phases = get_field('phases') ?: array();
$block_id = 'timeline-' . $block['id'];

if (empty($phases)) {
    $phases = array(
        array(
            'icon'        => 'calendar',
            'color'       => 'cyan',
            'label'       => '1ª Fase',
            'title'       => 'Candidatura',
            'dates'       => '20 Jul - 2 Ago',
            'description' => 'Período de candidatura para a 1ª fase do concurso nacional de acesso.',
        ),
        array(
            'icon'        => 'edit',
            'color'       => 'lavender',
            'label'       => '2ª Fase',
            'title'       => 'Candidatura',
            'dates'       => '12 Set - 23 Set',
            'description' => 'Período de candidatura para a 2ª fase do concurso nacional de acesso.',
        ),
        array(
            'icon'        => 'check',
            'color'       => 'coral',
            'label'       => '3ª Fase',
            'title'       => 'Candidatura',
            'dates'       => '2 Out - 13 Out',
            'description' => 'Período de candidatura para a 3ª fase do concurso nacional de acesso.',
        ),
    );
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="timeline-section section">
    <div class="container">
        <?php if ($section_title) : ?>
            <h2 class="section-title text-center mb-4"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($phases)) : ?>
            <div class="timeline">
                <?php foreach ($phases as $phase) : ?>
                    <div class="timeline-item">
                        <div class="timeline-icon <?php echo esc_attr($phase['color']); ?>">
                            <?php echo acesso_get_icon($phase['icon']); ?>
                        </div>
                        <span class="timeline-phase"><?php echo esc_html($phase['label']); ?></span>
                        <h3 class="timeline-title"><?php echo esc_html($phase['title']); ?></h3>
                        <p class="timeline-dates"><?php echo esc_html($phase['dates']); ?></p>
                        <?php if (!empty($phase['description'])) : ?>
                            <p class="timeline-description"><?php echo esc_html($phase['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
#<?php echo esc_attr($block_id); ?> {
    background: var(--color-white);
}

#<?php echo esc_attr($block_id); ?> .timeline {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--spacing-lg);
}

#<?php echo esc_attr($block_id); ?> .timeline-item {
    text-align: center;
    padding: var(--spacing-lg);
    border-radius: var(--radius-lg);
    background: var(--color-white);
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-normal);
}

#<?php echo esc_attr($block_id); ?> .timeline-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

#<?php echo esc_attr($block_id); ?> .timeline-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto var(--spacing-md);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

#<?php echo esc_attr($block_id); ?> .timeline-icon svg {
    width: 36px;
    height: 36px;
}

#<?php echo esc_attr($block_id); ?> .timeline-icon.cyan {
    background: rgba(0, 208, 132, 0.15);
    color: var(--color-cyan);
}

#<?php echo esc_attr($block_id); ?> .timeline-icon.lavender {
    background: rgba(136, 135, 226, 0.15);
    color: var(--color-lavender);
}

#<?php echo esc_attr($block_id); ?> .timeline-icon.coral {
    background: rgba(255, 107, 107, 0.15);
    color: var(--color-coral);
}

#<?php echo esc_attr($block_id); ?> .timeline-icon.purple {
    background: rgba(87, 45, 223, 0.15);
    color: var(--color-purple);
}

#<?php echo esc_attr($block_id); ?> .timeline-icon.pink {
    background: rgba(218, 36, 137, 0.15);
    color: var(--color-pink);
}

#<?php echo esc_attr($block_id); ?> .timeline-phase {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #666;
    margin-bottom: var(--spacing-xs);
}

#<?php echo esc_attr($block_id); ?> .timeline-title {
    font-size: 1.5rem;
    margin-bottom: var(--spacing-sm);
    color: var(--color-dark);
}

#<?php echo esc_attr($block_id); ?> .timeline-dates {
    font-weight: 600;
    color: var(--color-purple);
    margin-bottom: var(--spacing-sm);
}

#<?php echo esc_attr($block_id); ?> .timeline-description {
    font-size: 0.875rem;
    color: #666;
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 768px) {
    #<?php echo esc_attr($block_id); ?> .timeline {
        gap: var(--spacing-md);
    }

    #<?php echo esc_attr($block_id); ?> .timeline-item {
        padding: var(--spacing-md);
    }
}
</style>
