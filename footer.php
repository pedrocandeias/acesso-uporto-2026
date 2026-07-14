    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-inner">
                <?php
                // Redes sociais oficiais da U.Porto (como em up.pt/acesso).
                $footer_social = array(
                    'facebook'  => 'https://www.facebook.com/universidadedoporto',
                    'youtube'   => 'https://www.youtube.com/user/universidadedoporto',
                    'instagram' => 'https://www.instagram.com/uporto/',
                    'linkedin'  => 'https://www.linkedin.com/school/universidadedoporto/',
                );
                ?>
                <div class="footer-social">
                    <?php foreach ($footer_social as $platform => $url) : ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                            <?php echo acesso_get_icon($platform); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?php
                // Logo branco da U.Porto (versão clara do customizer, ou o asset do tema).
                $footer_logo = get_theme_mod('acesso_logo_footer', '') ?: ACESSO_THEME_URI . '/assets/images/logo-uporto-white.png';
                ?>
                <div class="footer-logo">
                    <a href="https://www.up.pt" target="_blank" rel="noopener">
                        <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php esc_attr_e('Universidade do Porto', 'acesso-uporto'); ?>">
                    </a>
                </div>

                <p class="footer-copyright">
                    <?php echo esc_html(date('Y')); ?> &copy; <?php esc_html_e('UNIVERSIDADE DO PORTO', 'acesso-uporto'); ?>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
