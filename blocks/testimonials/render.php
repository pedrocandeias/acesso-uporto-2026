<?php
/**
 * Testimonials Carousel Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? 'Os teus futuros colegas';
$section_subtitle = $attributes['sectionSubtitle'] ?? '';
$testimonials = $attributes['testimonials'] ?? [];
$autoplay = $attributes['autoplay'] ?? true;
$autoplay_speed = $attributes['autoplaySpeed'] ?? 5000;
$variant = $attributes['variant'] ?? 'cards';
// Backward compat: this visual variant was a string attribute named "style" before the
// rename to "variant". WordPress now treats the reserved "style" as an object (spacing/
// typography supports) and strips the legacy string from $attributes, so recover it from
// the raw parsed block attributes. A string value unambiguously means legacy saved content.
$legacy_variant = isset($block->parsed_block['attrs']['style']) ? $block->parsed_block['attrs']['style'] : null;
if (is_string($legacy_variant) && $legacy_variant !== '') {
    $variant = $legacy_variant;
}
$bg_color = $attributes['backgroundColor'] ?? '#f9f9f9';

$block_id = 'testimonials-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'testimonials-section style-' . esc_attr($variant),
));

if (empty($testimonials)) {
    return;
}
?>

<section <?php echo $wrapper_attributes; ?> style="background-color: <?php echo esc_attr($bg_color); ?>;">
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

        <div class="testimonials-wrapper <?php echo $variant === 'carousel' ? 'testimonials-carousel' : 'testimonials-grid'; ?>"
             data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
             data-speed="<?php echo esc_attr($autoplay_speed); ?>">

            <?php foreach ($testimonials as $index => $testimonial) :
                $name = $testimonial['name'] ?? '';
                $course = $testimonial['course'] ?? '';
                $quote = $testimonial['quote'] ?? '';
                $image = $testimonial['image'] ?? '';
            ?>
                <div class="testimonial-card<?php echo $index === 0 ? ' active' : ''; ?>">
                    <div class="testimonial-card-inner">
                        <div class="testimonial-quote">
                            <svg class="quote-icon" viewBox="0 0 24 24" fill="currentColor" width="40" height="40">
                                <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                            </svg>
                            <blockquote><?php echo esc_html($quote); ?></blockquote>
                        </div>

                        <div class="testimonial-author">
                            <?php if ($image) : ?>
                                <div class="testimonial-image">
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy">
                                </div>
                            <?php else : ?>
                                <div class="testimonial-image testimonial-image-placeholder">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="testimonial-info">
                                <?php if ($name) : ?>
                                    <span class="testimonial-name"><?php echo esc_html($name); ?></span>
                                <?php endif; ?>
                                <?php if ($course) : ?>
                                    <span class="testimonial-course"><?php echo esc_html($course); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($variant === 'carousel' && count($testimonials) > 1) : ?>
            <div class="testimonials-nav">
                <button class="testimonial-nav-btn testimonial-prev" aria-label="<?php esc_attr_e('Anterior', 'acesso-uporto'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </button>
                <div class="testimonials-dots">
                    <?php foreach ($testimonials as $index => $testimonial) : ?>
                        <button class="testimonial-dot<?php echo $index === 0 ? ' active' : ''; ?>"
                                data-index="<?php echo $index; ?>"
                                aria-label="<?php printf(esc_attr__('Ir para testemunho %d', 'acesso-uporto'), $index + 1); ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
                <button class="testimonial-nav-btn testimonial-next" aria-label="<?php esc_attr_e('Próximo', 'acesso-uporto'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
(function() {
    var section = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!section) return;

    var wrapper = section.querySelector('.testimonials-carousel');
    if (!wrapper) return;

    var cards = wrapper.querySelectorAll('.testimonial-card');
    var dots = section.querySelectorAll('.testimonial-dot');
    var prevBtn = section.querySelector('.testimonial-prev');
    var nextBtn = section.querySelector('.testimonial-next');
    var autoplay = wrapper.dataset.autoplay === 'true';
    var speed = parseInt(wrapper.dataset.speed, 10) || 5000;
    var currentIndex = 0;
    var interval = null;

    function showSlide(index) {
        if (index >= cards.length) index = 0;
        if (index < 0) index = cards.length - 1;

        currentIndex = index;

        cards.forEach(function(card, i) {
            card.classList.toggle('active', i === index);
        });

        dots.forEach(function(dot, i) {
            dot.classList.toggle('active', i === index);
        });
    }

    function nextSlide() {
        showSlide(currentIndex + 1);
    }

    function prevSlide() {
        showSlide(currentIndex - 1);
    }

    function startAutoplay() {
        // Sem "&&" (fica codificado por wptexturize dentro de markup aninhado).
        if (autoplay) {
            if (cards.length > 1) {
                interval = setInterval(nextSlide, speed);
            }
        }
    }

    function stopAutoplay() {
        if (interval) {
            clearInterval(interval);
            interval = null;
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            stopAutoplay();
            prevSlide();
            startAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            stopAutoplay();
            nextSlide();
            startAutoplay();
        });
    }

    dots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            stopAutoplay();
            showSlide(parseInt(dot.dataset.index, 10));
            startAutoplay();
        });
    });

    wrapper.addEventListener('mouseenter', stopAutoplay);
    wrapper.addEventListener('mouseleave', startAutoplay);

    startAutoplay();
})();
</script>
