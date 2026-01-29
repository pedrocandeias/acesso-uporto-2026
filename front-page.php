<?php
/**
 * Front Page Template
 *
 * Displays the home page with pre-placed Gutenberg blocks
 * if no custom content has been added.
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main front-page">
    <?php
    while (have_posts()) :
        the_post();

        // Get the page content
        $content = get_the_content();

        // Check if page has custom content
        if (!empty(trim(strip_tags($content, '<div><section><figure><img>')))) {
            // Page has custom content, display it
            the_content();
        } else {
            // Page is empty, check if we have the function to get default content
            if (function_exists('acesso_get_default_home_content')) {
                // Parse and render the default blocks
                $default_content = acesso_get_default_home_content();
                echo apply_filters('the_content', $default_content);
            } else {
                // Fallback: display whatever content exists
                the_content();
            }
        }
    endwhile;
    ?>
</main>

<?php
get_footer();
