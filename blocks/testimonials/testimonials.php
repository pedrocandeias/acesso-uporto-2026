<?php
/**
 * Testimonials Block Template
 *
 * @package AcessoUPorto
 */

$section_title = get_field('section_title') ?: __('Os teus futuros colegas', 'acesso-uporto');
$testimonials = get_field('testimonials') ?: array();
$block_id = 'testimonials-' . $block['id'];
?>

<section id="<?php echo esc_attr($block_id); ?>" class="testimonials-section section alignfull">
    <div class="container">
        <?php if ($section_title) : ?>
            <h2 class="section-title text-center mb-4"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>
    </div>

    <?php if (!empty($testimonials)) : ?>
        <div class="testimonials-wrapper">
            <div class="testimonials-slider">
                <?php foreach ($testimonials as $testimonial) : ?>
                    <div class="testimonial-card">
                        <?php if (!empty($testimonial['image'])) : ?>
                            <img src="<?php echo esc_url($testimonial['image']['sizes']['medium_large']); ?>"
                                 alt="<?php echo esc_attr($testimonial['name']); ?>"
                                 class="testimonial-image"
                                 loading="lazy">
                        <?php else : ?>
                            <div class="testimonial-image testimonial-placeholder"></div>
                        <?php endif; ?>

                        <div class="testimonial-overlay">
                            <h3 class="testimonial-name"><?php echo esc_html($testimonial['name']); ?></h3>
                            <p class="testimonial-course"><?php echo esc_html($testimonial['course']); ?></p>
                            <?php if (!empty($testimonial['quote'])) : ?>
                                <p class="testimonial-quote"><?php echo esc_html($testimonial['quote']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="testimonials-nav">
                <button class="testimonials-nav-btn prev" aria-label="<?php esc_attr_e('Previous', 'acesso-uporto'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="testimonials-nav-btn next" aria-label="<?php esc_attr_e('Next', 'acesso-uporto'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    <?php else : ?>
        <p class="text-center"><?php esc_html_e('No testimonials available.', 'acesso-uporto'); ?></p>
    <?php endif; ?>
</section>

<style>
#<?php echo esc_attr($block_id); ?> {
    background: #f5f5f5;
    overflow: hidden;
}

#<?php echo esc_attr($block_id); ?> .testimonials-wrapper {
    position: relative;
    padding: 0 var(--spacing-md);
}

#<?php echo esc_attr($block_id); ?> .testimonials-slider {
    display: flex;
    gap: var(--spacing-md);
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding: var(--spacing-md) 0;
    scroll-behavior: smooth;
}

#<?php echo esc_attr($block_id); ?> .testimonials-slider::-webkit-scrollbar {
    display: none;
}

#<?php echo esc_attr($block_id); ?> .testimonial-card {
    flex: 0 0 350px;
    scroll-snap-align: start;
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: var(--color-white);
    box-shadow: var(--shadow-md);
    transition: transform var(--transition-normal), box-shadow var(--transition-normal);
}

#<?php echo esc_attr($block_id); ?> .testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

#<?php echo esc_attr($block_id); ?> .testimonial-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
}

#<?php echo esc_attr($block_id); ?> .testimonial-placeholder {
    background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-pink) 100%);
}

#<?php echo esc_attr($block_id); ?> .testimonial-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: var(--spacing-md);
    background: rgba(24, 27, 49, 0.9);
    color: var(--color-white);
    transform: translateY(calc(100% - 80px));
    transition: transform var(--transition-normal);
}

#<?php echo esc_attr($block_id); ?> .testimonial-card:hover .testimonial-overlay {
    transform: translateY(0);
}

#<?php echo esc_attr($block_id); ?> .testimonial-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0 0 var(--spacing-xs) 0;
    color: var(--color-white);
}

#<?php echo esc_attr($block_id); ?> .testimonial-course {
    font-size: 0.875rem;
    opacity: 0.8;
    margin: 0 0 var(--spacing-sm) 0;
}

#<?php echo esc_attr($block_id); ?> .testimonial-quote {
    font-size: 0.875rem;
    line-height: 1.6;
    margin: 0;
    opacity: 0;
    transition: opacity var(--transition-normal);
}

#<?php echo esc_attr($block_id); ?> .testimonial-card:hover .testimonial-quote {
    opacity: 1;
}

#<?php echo esc_attr($block_id); ?> .testimonials-nav {
    display: flex;
    justify-content: center;
    gap: var(--spacing-sm);
    margin-top: var(--spacing-md);
}

#<?php echo esc_attr($block_id); ?> .testimonials-nav-btn {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-white);
    border: 2px solid var(--color-purple);
    border-radius: 50%;
    color: var(--color-purple);
    cursor: pointer;
    transition: all var(--transition-fast);
}

#<?php echo esc_attr($block_id); ?> .testimonials-nav-btn:hover {
    background: var(--color-purple);
    color: var(--color-white);
}

#<?php echo esc_attr($block_id); ?> .testimonials-nav-btn svg {
    width: 24px;
    height: 24px;
}

@media (max-width: 768px) {
    #<?php echo esc_attr($block_id); ?> .testimonial-card {
        flex: 0 0 280px;
    }

    #<?php echo esc_attr($block_id); ?> .testimonial-image {
        height: 350px;
    }

    #<?php echo esc_attr($block_id); ?> .testimonial-overlay {
        transform: translateY(0);
    }

    #<?php echo esc_attr($block_id); ?> .testimonial-quote {
        opacity: 1;
    }
}
</style>
