<?php
/**
 * Faculty Cards Block Template
 *
 * @package AcessoUPorto
 */

$section_title = get_field('section_title') ?: __('Faculdades', 'acesso-uporto');
$faculties = get_field('faculties') ?: array();
$block_id = 'faculties-' . $block['id'];
?>

<section id="<?php echo esc_attr($block_id); ?>" class="faculty-section section">
    <div class="container">
        <?php if ($section_title) : ?>
            <h2 class="section-title text-center mb-4"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($faculties)) : ?>
            <div class="faculty-grid">
                <?php foreach ($faculties as $faculty) : ?>
                    <a href="<?php echo esc_url($faculty['link'] ?: '#'); ?>" class="faculty-card">
                        <?php if (!empty($faculty['image'])) : ?>
                            <div class="faculty-image">
                                <img src="<?php echo esc_url($faculty['image']['sizes']['medium']); ?>"
                                     alt="<?php echo esc_attr($faculty['name']); ?>"
                                     loading="lazy">
                            </div>
                        <?php else : ?>
                            <div class="faculty-image faculty-placeholder">
                                <span class="faculty-acronym"><?php echo esc_html($faculty['acronym']); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="faculty-content">
                            <span class="faculty-acronym-label"><?php echo esc_html($faculty['acronym']); ?></span>
                            <h3 class="faculty-name"><?php echo esc_html($faculty['name']); ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-center"><?php esc_html_e('No faculties available.', 'acesso-uporto'); ?></p>
        <?php endif; ?>
    </div>
</section>

<style>
#<?php echo esc_attr($block_id); ?> {
    background: var(--color-white);
}

#<?php echo esc_attr($block_id); ?> .faculty-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--spacing-md);
}

#<?php echo esc_attr($block_id); ?> .faculty-card {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: var(--color-white);
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-normal);
    text-decoration: none;
    color: var(--color-dark);
}

#<?php echo esc_attr($block_id); ?> .faculty-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

#<?php echo esc_attr($block_id); ?> .faculty-image {
    height: 180px;
    overflow: hidden;
}

#<?php echo esc_attr($block_id); ?> .faculty-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

#<?php echo esc_attr($block_id); ?> .faculty-card:hover .faculty-image img {
    transform: scale(1.05);
}

#<?php echo esc_attr($block_id); ?> .faculty-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-pink) 100%);
    color: var(--color-white);
}

#<?php echo esc_attr($block_id); ?> .faculty-placeholder .faculty-acronym {
    font-family: var(--font-condensed);
    font-size: 3rem;
    font-weight: 700;
}

#<?php echo esc_attr($block_id); ?> .faculty-content {
    padding: var(--spacing-md);
}

#<?php echo esc_attr($block_id); ?> .faculty-acronym-label {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--color-purple);
    margin-bottom: var(--spacing-xs);
}

#<?php echo esc_attr($block_id); ?> .faculty-name {
    font-size: 1.125rem;
    margin: 0;
    line-height: 1.3;
}

@media (max-width: 768px) {
    #<?php echo esc_attr($block_id); ?> .faculty-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
}
</style>
