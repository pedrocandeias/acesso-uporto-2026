<?php
/**
 * The template for displaying 404 pages
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main">
    <section class="error-404 section">
        <div class="container text-center">
            <div class="error-content">
                <h1 class="error-title gradient-text">404</h1>
                <h2><?php esc_html_e('Page Not Found', 'acesso-uporto'); ?></h2>
                <p><?php esc_html_e('Sorry, the page you are looking for doesn\'t exist or has been moved.', 'acesso-uporto'); ?></p>

                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Go to Homepage', 'acesso-uporto'); ?>
                    </a>
                </div>

                <div class="error-search">
                    <p><?php esc_html_e('Or try searching:', 'acesso-uporto'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.error-404 {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    padding-top: 80px;
}

.error-content {
    max-width: 600px;
    margin: 0 auto;
}

.error-title {
    font-family: var(--font-condensed);
    font-size: clamp(8rem, 20vw, 15rem);
    font-weight: 900;
    line-height: 1;
    margin-bottom: var(--spacing-md);
}

.error-404 h2 {
    font-size: clamp(1.5rem, 4vw, 2.5rem);
    margin-bottom: var(--spacing-sm);
}

.error-404 p {
    font-size: 1.125rem;
    color: #666;
    margin-bottom: var(--spacing-lg);
}

.error-actions {
    margin-bottom: var(--spacing-lg);
}

.error-search {
    padding-top: var(--spacing-lg);
    border-top: 3px solid var(--color-ink);
}

.error-search p {
    margin-bottom: var(--spacing-sm);
}

.error-search .search-form {
    display: flex;
    gap: var(--spacing-sm);
    max-width: 400px;
    margin: 0 auto;
}

.error-search .search-field {
    flex: 1;
    padding: 0.75rem 1rem;
    border: var(--border-hard);
    border-radius: var(--radius-sm);
    font-family: var(--font-primary);
    font-size: 1rem;
    transition: border-color var(--transition-fast);
}

.error-search .search-field:focus {
    outline: 3px solid var(--color-cyan);
    outline-offset: 2px;
}

.error-search .search-submit {
    padding: 0.8125rem 1.375rem;
    background: var(--color-btn-bg, var(--color-yellow));
    color: var(--color-btn-text, var(--color-ink));
    border: var(--border-hard);
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow-hard);
    clip-path: var(--pixel-clip-shadow);
    font-family: var(--font-ui);
    font-weight: var(--font-ui-weight);
    font-size: 0.9375rem;
    line-height: 1;
    text-transform: var(--ui-text-transform, uppercase);
    letter-spacing: 0.05em;
    cursor: pointer;
}

.error-search .search-submit:active {
    transform: translate(3px, 3px);
    box-shadow: 2px 2px 0 var(--color-ink);
}
</style>

<?php
get_footer();
