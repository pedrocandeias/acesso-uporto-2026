<?php
/**
 * The template for displaying search results
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main">
    <header class="page-header container">
        <h1 class="page-title">
            <?php
            printf(
                /* translators: %s: search query */
                esc_html__('Search Results for: %s', 'acesso-uporto'),
                '<span class="gradient-text">' . get_search_query() . '</span>'
            );
            ?>
        </h1>
    </header>

    <div class="container section">
        <?php if (have_posts()) : ?>
            <p class="results-count">
                <?php
                global $wp_query;
                printf(
                    /* translators: %d: number of results */
                    esc_html(_n('%d result found', '%d results found', $wp_query->found_posts, 'acesso-uporto')),
                    $wp_query->found_posts
                );
                ?>
            </p>

            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-card-content">
                            <header class="post-card-header">
                                <span class="post-type-label">
                                    <?php
                                    $post_type_obj = get_post_type_object(get_post_type());
                                    echo esc_html($post_type_obj->labels->singular_name);
                                    ?>
                                </span>
                                <?php the_title('<h2 class="post-card-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                            </header>

                            <div class="post-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="post-card-footer">
                                <a href="<?php the_permalink(); ?>" class="btn btn-secondary">
                                    <?php esc_html_e('View', 'acesso-uporto'); ?>
                                </a>
                            </footer>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '&laquo; ' . __('Previous', 'acesso-uporto'),
                'next_text' => __('Next', 'acesso-uporto') . ' &raquo;',
            )); ?>

        <?php else : ?>
            <div class="no-results">
                <h2><?php esc_html_e('Nothing Found', 'acesso-uporto'); ?></h2>
                <p><?php esc_html_e('Sorry, no results were found for your search. Please try again with different keywords.', 'acesso-uporto'); ?></p>

                <div class="search-again">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.results-count {
    color: #666;
    margin-bottom: var(--spacing-lg);
}

.post-type-label {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--color-purple);
    margin-bottom: var(--spacing-xs);
}

.search-again {
    max-width: 500px;
    margin: var(--spacing-lg) auto 0;
}

.search-again .search-form {
    display: flex;
    gap: var(--spacing-sm);
}

.search-again .search-field {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e5e5;
    border-radius: var(--radius-full);
    font-family: var(--font-primary);
    font-size: 1rem;
}

.search-again .search-field:focus {
    outline: none;
    border-color: var(--color-purple);
}

.search-again .search-submit {
    padding: 0.75rem 1.5rem;
    background: var(--gradient-primary);
    color: var(--color-white);
    border: none;
    border-radius: var(--radius-full);
    font-weight: 600;
    cursor: pointer;
}
</style>

<?php
get_footer();
