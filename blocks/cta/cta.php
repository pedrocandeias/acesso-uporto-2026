<?php
/**
 * CTA Block Template
 *
 * @package AcessoUPorto
 */

$title = get_field('title') ?: __('Pronto para começar?', 'acesso-uporto');
$text = get_field('text') ?: __('Descobre o curso ideal para ti e candidata-te à Universidade do Porto.', 'acesso-uporto');
$button_text = get_field('button_text') ?: __('Candidata-te Já', 'acesso-uporto');
$button_url = get_field('button_url') ?: '#';
$style = get_field('style') ?: 'gradient';
$block_id = 'cta-' . $block['id'];
?>

<section id="<?php echo esc_attr($block_id); ?>" class="cta-section section alignfull cta-style-<?php echo esc_attr($style); ?>">
    <div class="container text-center">
        <?php if ($title) : ?>
            <h2 class="cta-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($text) : ?>
            <p class="cta-text"><?php echo esc_html($text); ?></p>
        <?php endif; ?>

        <?php if ($button_text && $button_url) : ?>
            <a href="<?php echo esc_url($button_url); ?>" class="btn <?php echo $style === 'gradient' ? 'btn-white' : 'btn-primary'; ?>">
                <?php echo esc_html($button_text); ?>
                <?php echo acesso_get_icon('arrow-right'); ?>
            </a>
        <?php endif; ?>
    </div>
</section>

<style>
#<?php echo esc_attr($block_id); ?> {
    padding: var(--spacing-xl) 0;
}

#<?php echo esc_attr($block_id); ?>.cta-style-gradient {
    background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-pink) 100%);
    color: var(--color-white);
}

#<?php echo esc_attr($block_id); ?>.cta-style-dark {
    background: var(--color-dark);
    color: var(--color-white);
}

#<?php echo esc_attr($block_id); ?>.cta-style-light {
    background: #f5f5f5;
    color: var(--color-dark);
}

#<?php echo esc_attr($block_id); ?> .cta-title {
    font-size: clamp(2rem, 4vw, 3rem);
    margin-bottom: var(--spacing-md);
}

#<?php echo esc_attr($block_id); ?>.cta-style-gradient .cta-title,
#<?php echo esc_attr($block_id); ?>.cta-style-dark .cta-title {
    color: var(--color-white);
}

#<?php echo esc_attr($block_id); ?> .cta-text {
    font-size: 1.25rem;
    max-width: 600px;
    margin: 0 auto var(--spacing-lg);
    opacity: 0.9;
}

#<?php echo esc_attr($block_id); ?> .btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-xs);
}

#<?php echo esc_attr($block_id); ?> .btn svg {
    width: 20px;
    height: 20px;
    transition: transform var(--transition-fast);
}

#<?php echo esc_attr($block_id); ?> .btn:hover svg {
    transform: translateX(5px);
}
</style>
