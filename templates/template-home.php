<?php
/**
 * Template Name: Home Page
 * Template Post Type: page
 *
 * Full-width home page template with pre-placed Gutenberg blocks
 * matching the UP.pt Acesso design.
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main home-page">
    <?php
    while (have_posts()) :
        the_post();

        // Check if page has content
        $content = get_the_content();

        if (!empty(trim($content))) {
            // Page has custom content, display it
            the_content();
        } else {
            // Page is empty, display default home page blocks
            echo acesso_get_default_home_content();
        }
    endwhile;
    ?>
</main>

<?php
get_footer();
