    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4><?php esc_html_e('About', 'acesso-uporto'); ?></h4>
                    <?php if (function_exists('get_field') && get_field('footer_text', 'option')) : ?>
                        <p><?php echo esc_html(get_field('footer_text', 'option')); ?></p>
                    <?php else : ?>
                        <p><?php esc_html_e('University of Porto - One of the largest and most prestigious universities in Portugal.', 'acesso-uporto'); ?></p>
                    <?php endif; ?>
                </div>

                <div class="footer-column">
                    <h4><?php esc_html_e('Quick Links', 'acesso-uporto'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <div class="footer-column">
                    <h4><?php esc_html_e('Contact', 'acesso-uporto'); ?></h4>
                    <ul>
                        <li><?php esc_html_e('Praça de Gomes Teixeira', 'acesso-uporto'); ?></li>
                        <li><?php esc_html_e('4099-002 Porto, Portugal', 'acesso-uporto'); ?></li>
                        <li><a href="mailto:acesso@reit.up.pt">acesso@reit.up.pt</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4><?php esc_html_e('Follow Us', 'acesso-uporto'); ?></h4>
                    <div class="footer-social">
                        <?php
                        $social_links = acesso_get_social_links();
                        foreach ($social_links as $platform => $url) :
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                                <?php echo acesso_get_icon($platform); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
                    <?php esc_html_e('All rights reserved.', 'acesso-uporto'); ?>
                </p>
                <p class="credits">
                    <a href="https://www.up.pt" target="_blank" rel="noopener">Universidade do Porto</a>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
