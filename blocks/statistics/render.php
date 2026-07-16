<?php
/**
 * Statistics Counter Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? '';
$stats = $attributes['stats'] ?? [];
$layout = $attributes['layout'] ?? 'grid-4';
$variant = $attributes['variant'] ?? 'default';
// Backward compat: this visual variant was a string attribute named "style" before the
// rename to "variant". WordPress now treats the reserved "style" as an object (spacing/
// typography supports) and strips the legacy string from $attributes, so recover it from
// the raw parsed block attributes. A string value unambiguously means legacy saved content.
$legacy_variant = isset($block->parsed_block['attrs']['style']) ? $block->parsed_block['attrs']['style'] : null;
if (is_string($legacy_variant) && $legacy_variant !== '') {
    $variant = $legacy_variant;
}
$animate = $attributes['animateOnScroll'] ?? true;

$block_id = 'statistics-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'statistics-section style-' . esc_attr($variant),
));

// Icon SVGs
$icons = array(
    'star' => '<svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
    'building' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="2"/><line x1="15" y1="22" x2="15" y2="2"/><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="10" x2="20" y2="10"/><line x1="4" y1="14" x2="20" y2="14"/><line x1="4" y1="18" x2="20" y2="18"/></svg>',
    'groups' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    'science' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3h6M12 3v7.5M5.2 19c-.8-1.6-1.2-3.5-.5-5.3.7-1.8 2.3-3 4.3-3.2h6c2 .2 3.6 1.4 4.3 3.2.7 1.8.3 3.7-.5 5.3"/><path d="M8 19h8"/></svg>',
    'library' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
    'globe' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
    'award' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
    'chart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>',
    'graduation' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/></svg>',
);

$grid_class = 'statistics-grid ' . esc_attr($layout);
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="container">
        <?php if ($section_title) : ?>
            <h2 class="section-title text-center"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>

        <div class="<?php echo $grid_class; ?>">
            <?php foreach ($stats as $stat) :
                $number = $stat['number'] ?? '0';
                $suffix = $stat['suffix'] ?? '';
                $label = $stat['label'] ?? '';
                $icon = $stat['icon'] ?? 'star';
            ?>
                <div class="stat-item<?php echo $animate ? ' animate-on-scroll' : ''; ?>" data-number="<?php echo esc_attr($number); ?>">
                    <?php if ($variant === 'icons' && isset($icons[$icon])) : ?>
                        <div class="stat-icon">
                            <?php echo $icons[$icon]; ?>
                        </div>
                    <?php endif; ?>

                    <div class="stat-number">
                        <span class="stat-value"><?php echo esc_html($number); ?></span>
                        <?php if ($suffix) : ?>
                            <span class="stat-suffix"><?php echo esc_html($suffix); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="stat-label"><?php echo esc_html($label); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($animate) : ?>
<script>
(function() {
    var section = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!section) return;

    var statItems = section.querySelectorAll('.stat-item.animate-on-scroll');
    var animated = false;

    function animateCounter(el) {
        var target = parseInt(el.dataset.number, 10);
        var valueEl = el.querySelector('.stat-value');
        if (!valueEl || isNaN(target)) return;

        var current = 0;
        var duration = 2000;
        var increment = target / (duration / 16);

        function update() {
            current += increment;
            if (current >= target) {
                valueEl.textContent = target.toLocaleString('pt-PT');
                return;
            }
            valueEl.textContent = Math.floor(current).toLocaleString('pt-PT');
            requestAnimationFrame(update);
        }

        valueEl.textContent = '0';
        update();
    }

    function checkVisibility() {
        if (animated) return;

        var rect = section.getBoundingClientRect();
        // Evita o operador "&&" no HTML (fica codificado por wptexturize dentro de markup aninhado).
        var visible = false;
        if (rect.top < window.innerHeight * 0.8) {
            if (rect.bottom > 0) {
                visible = true;
            }
        }

        if (visible) {
            animated = true;
            statItems.forEach(function(item, index) {
                setTimeout(function() {
                    item.classList.add('visible');
                    animateCounter(item);
                }, index * 100);
            });
        }
    }

    window.addEventListener('scroll', checkVisibility);
    checkVisibility();
})();
</script>
<?php endif; ?>
