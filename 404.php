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
    border-top: 1px solid #eee;
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
    border: 2px solid #e5e5e5;
    border-radius: var(--radius-full);
    font-family: var(--font-primary);
    font-size: 1rem;
    transition: border-color var(--transition-fast);
}

.error-search .search-field:focus {
    outline: none;
    border-color: var(--color-purple);
}

.error-search .search-submit {
    padding: 0.75rem 1.5rem;
    background: var(--gradient-primary);
    color: var(--color-white);
    border: none;
    border-radius: var(--radius-full);
    font-family: var(--font-primary);
    font-weight: 600;
    cursor: pointer;
    transition: transform var(--transition-fast);
}

.error-search .search-submit:hover {
    transform: translateY(-2px);
}
</style>

<?php
get_footer();
