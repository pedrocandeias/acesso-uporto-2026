<?php
/**
 * Hero Block Template
 *
 * @package AcessoUPorto
 */

$pretitle = get_field('pretitle') ?: 'ISTO É';
$rotating_words = get_field('rotating_words') ?: array();
$title = get_field('title') ?: 'U.PORTO';
$buttons = get_field('buttons') ?: array();
$background_image = get_field('background_image');

$block_id = 'hero-' . $block['id'];
?>

<section id="<?php echo esc_attr($block_id); ?>" class="hero-section alignfull">
    <?php if ($background_image) : ?>
        <div class="hero-background" style="background-image: url('<?php echo esc_url($background_image); ?>');"></div>
    <?php endif; ?>

    <div class="hero-content">
        <?php if ($pretitle) : ?>
            <p class="hero-pretitle"><?php echo esc_html($pretitle); ?></p>
        <?php endif; ?>

        <?php if (!empty($rotating_words)) : ?>
            <div class="hero-rotating-text" data-words='<?php echo esc_attr(wp_json_encode(array_column($rotating_words, 'word'))); ?>'>
                <span class="rotating-word"><?php echo esc_html($rotating_words[0]['word']); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($title) : ?>
            <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>

        <?php if (!empty($buttons)) : ?>
            <div class="hero-buttons">
                <?php foreach ($buttons as $button) : ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="btn btn-<?php echo esc_attr($button['style'] ?: 'primary'); ?>">
                        <?php echo esc_html($button['text']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="hero-scroll-indicator">
        <span></span>
    </div>
</section>

<style>
#<?php echo esc_attr($block_id); ?> {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-pink) 100%);
    overflow: hidden;
    padding-top: 80px;
}

#<?php echo esc_attr($block_id); ?> .hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.3;
}

#<?php echo esc_attr($block_id); ?> .hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: var(--color-white);
    padding: var(--spacing-lg);
    max-width: 1200px;
}

#<?php echo esc_attr($block_id); ?> .hero-pretitle {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: var(--spacing-sm);
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
    animation-delay: 0.2s;
}

#<?php echo esc_attr($block_id); ?> .hero-rotating-text {
    font-family: var(--font-condensed);
    font-size: clamp(3rem, 8vw, 8.75rem);
    font-weight: 900;
    line-height: 1;
    margin-bottom: var(--spacing-md);
    min-height: 1.2em;
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
    animation-delay: 0.4s;
}

#<?php echo esc_attr($block_id); ?> .rotating-word {
    display: inline-block;
    animation: wordRotate 0.5s ease;
}

#<?php echo esc_attr($block_id); ?> .hero-title {
    font-family: var(--font-condensed);
    font-size: clamp(4rem, 10vw, 10rem);
    font-weight: 900;
    line-height: 0.9;
    margin-bottom: var(--spacing-lg);
    color: var(--color-white);
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
    animation-delay: 0.6s;
}

#<?php echo esc_attr($block_id); ?> .hero-buttons {
    display: flex;
    gap: var(--spacing-md);
    justify-content: center;
    flex-wrap: wrap;
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
    animation-delay: 0.8s;
}

#<?php echo esc_attr($block_id); ?> .hero-scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    animation: fadeIn 1s ease forwards;
    animation-delay: 1.2s;
}

#<?php echo esc_attr($block_id); ?> .hero-scroll-indicator span {
    display: block;
    width: 30px;
    height: 50px;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 25px;
    position: relative;
}

#<?php echo esc_attr($block_id); ?> .hero-scroll-indicator span::before {
    content: '';
    position: absolute;
    top: 10px;
    left: 50%;
    width: 6px;
    height: 6px;
    background: var(--color-white);
    border-radius: 50%;
    transform: translateX(-50%);
    animation: scrollBounce 2s infinite;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes wordRotate {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scrollBounce {
    0%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    50% {
        transform: translateX(-50%) translateY(20px);
    }
}
</style>
