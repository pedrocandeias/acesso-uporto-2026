<?php
/**
 * Statistics Block Template
 *
 * @package AcessoUPorto
 */

$statistics = get_field('statistics') ?: array();
$block_id = 'stats-' . $block['id'];

if (empty($statistics)) {
    $statistics = array(
        array('number' => 15, 'label' => 'Faculdades', 'suffix' => ''),
        array('number' => 18, 'label' => 'Bibliotecas', 'suffix' => ''),
        array('number' => 12, 'label' => 'Museus', 'suffix' => ''),
        array('number' => 48, 'label' => 'Unidades de Investigação', 'suffix' => ''),
    );
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="stats-section section alignfull">
    <div class="container">
        <div class="stats-grid">
            <?php foreach ($statistics as $stat) : ?>
                <div class="stat-item">
                    <div class="stat-number" data-count="<?php echo esc_attr($stat['number']); ?>">
                        <span class="count">0</span><?php echo esc_html($stat['suffix']); ?>
                    </div>
                    <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
#<?php echo esc_attr($block_id); ?> {
    background: var(--color-dark);
    color: var(--color-white);
    padding: var(--spacing-xl) 0;
}

#<?php echo esc_attr($block_id); ?> .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--spacing-lg);
    text-align: center;
}

#<?php echo esc_attr($block_id); ?> .stat-item {
    padding: var(--spacing-md);
}

#<?php echo esc_attr($block_id); ?> .stat-number {
    font-family: var(--font-condensed);
    font-size: clamp(3rem, 6vw, 5rem);
    font-weight: 700;
    background: linear-gradient(90deg, var(--color-purple) 0%, var(--color-pink) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: var(--spacing-xs);
}

#<?php echo esc_attr($block_id); ?> .stat-label {
    font-size: 1.125rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.9;
}
</style>
