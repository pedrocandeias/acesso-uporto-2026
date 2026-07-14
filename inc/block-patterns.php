<?php
/**
 * Block Patterns Registration
 *
 * Registers block patterns for the Acesso U.Porto theme.
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Block Pattern Category
 */
function acesso_register_pattern_category() {
    register_block_pattern_category(
        'acesso-uporto',
        array(
            'label' => __('Acesso U.Porto', 'acesso-uporto'),
        )
    );
}
add_action('init', 'acesso_register_pattern_category');

/**
 * Register patterns directory
 */
function acesso_register_patterns_directory() {
    register_block_pattern_category('acesso-uporto', array(
        'label' => __('Acesso U.Porto', 'acesso-uporto'),
    ));
}
add_action('init', 'acesso_register_patterns_directory');

/**
 * Register Block Patterns
 */
function acesso_register_block_patterns() {
    // Full Home Page Pattern
    register_block_pattern(
        'acesso-uporto/home-page',
        array(
            'title'       => __('Home Page Completa', 'acesso-uporto'),
            'description' => __('Layout completo da página inicial com todos os blocos.', 'acesso-uporto'),
            'categories'  => array('acesso-uporto'),
            'content'     => acesso_get_default_home_content(),
        )
    );

    // Hero Section Pattern
    register_block_pattern(
        'acesso-uporto/hero-section',
        array(
            'title'       => __('Hero Section', 'acesso-uporto'),
            'description' => __('Secção hero com texto rotativo e botões.', 'acesso-uporto'),
            'categories'  => array('acesso-uporto'),
            'content'     => '<!-- wp:acesso/hero {"rotatingWords":["Conhecimento","Investigação","Inovação","Futuro"],"staticTextBefore":"ISTO É","mainTitle":"U.PORTO","tagline":"...e tu também podes ser!","primaryButtonText":"Explorar Cursos","primaryButtonUrl":"#cursos","secondaryButtonText":"Ver Vídeo","secondaryButtonUrl":"#video","gradientStart":"#572ddf","gradientEnd":"#da2489"} /-->',
        )
    );

    // Statistics Pattern
    register_block_pattern(
        'acesso-uporto/statistics-section',
        array(
            'title'       => __('Estatísticas', 'acesso-uporto'),
            'description' => __('Secção de estatísticas com contadores animados.', 'acesso-uporto'),
            'categories'  => array('acesso-uporto'),
            'content'     => '<!-- wp:acesso/statistics {"sectionTitle":"A U.Porto em Números","stats":[{"number":"15","suffix":"","label":"Faculdades","icon":"building"},{"number":"35700","suffix":"+","label":"Estudantes","icon":"groups"},{"number":"48","suffix":"","label":"Centros de Investigação","icon":"science"},{"number":"300","suffix":"+","label":"Cursos","icon":"graduation"}],"layout":"grid-4","style":"icons","animateOnScroll":true} /-->',
        )
    );

    // Testimonials Pattern
    register_block_pattern(
        'acesso-uporto/testimonials-section',
        array(
            'title'       => __('Testemunhos', 'acesso-uporto'),
            'description' => __('Carrossel de testemunhos de estudantes.', 'acesso-uporto'),
            'categories'  => array('acesso-uporto'),
            'content'     => '<!-- wp:acesso/testimonials {"sectionTitle":"Os teus futuros colegas","sectionSubtitle":"Descobre o que os estudantes da U.Porto têm a dizer","testimonials":[{"name":"Maria Silva","course":"Engenharia Informática - FEUP","quote":"O ambiente universitário é pautado pela união e pelo espírito de entreajuda entre colegas. A U.Porto proporcionou-me experiências únicas.","image":"","imageId":0},{"name":"João Santos","course":"Medicina - FMUP","quote":"A qualidade do ensino e a dedicação dos professores fazem toda a diferença. Sinto-me preparado para o futuro.","image":"","imageId":0},{"name":"Ana Costa","course":"Arquitetura - FAUP","quote":"A FAUP é reconhecida mundialmente e estudar aqui foi a melhor decisão que tomei. Os projetos são desafiantes e inspiradores.","image":"","imageId":0}],"style":"carousel","autoplay":true} /-->',
        )
    );

    // CTA Pattern
    register_block_pattern(
        'acesso-uporto/cta-section',
        array(
            'title'       => __('Call to Action', 'acesso-uporto'),
            'description' => __('Secção de chamada para ação.', 'acesso-uporto'),
            'categories'  => array('acesso-uporto'),
            'content'     => '<!-- wp:acesso/cta {"title":"Pronto para começar a tua jornada?","text":"Descobre os cursos disponíveis na U.Porto e encontra o teu futuro.","primaryButtonText":"Explorar Cursos","primaryButtonUrl":"#cursos","secondaryButtonText":"Fala Connosco","secondaryButtonUrl":"#contacto","style":"gradient"} /-->',
        )
    );
}
add_action('init', 'acesso_register_block_patterns');

/**
 * Get Default Home Page Content
 *
 * Returns the default block content for the home page template.
 *
 * @return string Block content
 */
function acesso_get_default_home_content() {
    ob_start();
    ?>
<!-- wp:acesso/hero {"align":"full","rotatingWords":["Conhecimento","Investigação","Inovação","Futuro"],"staticTextBefore":"ISTO É","mainTitle":"U.PORTO","tagline":"...e tu também podes ser!","primaryButtonText":"Explorar Cursos","primaryButtonUrl":"#cursos","secondaryButtonText":"Ver Vídeo","secondaryButtonUrl":"#video","gradientStart":"#572ddf","gradientEnd":"#da2489","overlayOpacity":75,"minHeight":"100vh"} /-->

<!-- wp:acesso/statistics {"align":"wide","sectionTitle":"A U.Porto em Números","stats":[{"number":"15","suffix":"","label":"Faculdades + 1 Business School","icon":"building"},{"number":"35700","suffix":"+","label":"Estudantes Inscritos","icon":"groups"},{"number":"48","suffix":"","label":"Centros de Investigação","icon":"science"},{"number":"300","suffix":"+","label":"Cursos de Licenciatura e Mestrado","icon":"graduation"},{"number":"18","suffix":"","label":"Bibliotecas","icon":"library"}],"layout":"grid-5","style":"icons","animateOnScroll":true} /-->

<!-- wp:acesso/feature-cards {"align":"wide","sectionTitle":"Porquê a U.Porto?","sectionSubtitle":"Uma universidade de referência em Portugal e no mundo","features":[{"icon":"award","title":"Excelência","description":"Top 2% das melhores universidades do mundo","link":""},{"icon":"globe","title":"Internacional","description":"Mais de 7.900 estudantes internacionais","link":""},{"icon":"science","title":"Investigação","description":"Líder nacional em produção científica","link":""},{"icon":"groups","title":"Comunidade","description":"Uma rede global de mais de 200.000 alumni","link":""}],"columns":4,"style":"elevated","showIcons":true} /-->

<!-- wp:acesso/course-cards {"align":"wide","sectionTitle":"Cursos em Destaque","sectionSubtitle":"Descobre os cursos mais procurados","showFilters":true,"filterType":"faculdade","layout":"grid-3","style":"default","limit":6,"showFeaturedOnly":true,"ctaText":"Ver Todos os Cursos","ctaUrl":"/cursos"} /-->

<!-- wp:acesso/testimonials {"align":"full","sectionTitle":"Os teus futuros colegas","sectionSubtitle":"Descobre o que os estudantes da U.Porto têm a dizer","testimonials":[{"name":"Maria Silva","course":"Engenharia Informática - FEUP","quote":"O ambiente universitário é pautado pela união e pelo espírito de entreajuda entre colegas. A U.Porto proporcionou-me experiências únicas que moldaram o meu percurso profissional.","image":"","imageId":0},{"name":"João Santos","course":"Medicina - FMUP","quote":"A qualidade do ensino e a dedicação dos professores fazem toda a diferença. Sinto-me preparado para os desafios do futuro na área da saúde.","image":"","imageId":0},{"name":"Ana Costa","course":"Arquitetura - FAUP","quote":"A FAUP é reconhecida mundialmente e estudar aqui foi a melhor decisão que tomei. Os projetos são desafiantes e inspiradores.","image":"","imageId":0}],"style":"carousel","autoplay":true,"autoplaySpeed":5000,"backgroundColor":"#f9f9f9"} /-->

<!-- wp:acesso/timeline {"align":"wide","sectionTitle":"Fases de Candidatura","sectionSubtitle":"Conhece as datas importantes do Concurso Nacional de Acesso","phases":[{"icon":"calendar","color":"cyan","label":"1ª Fase","title":"Candidaturas","dates":"Julho 2026","description":"Período de candidaturas ao Concurso Nacional de Acesso. Escolhe até 6 opções de curso por ordem de preferência."},{"icon":"edit","color":"lavender","label":"2ª Fase","title":"Colocações","dates":"Setembro 2026","description":"Divulgação dos resultados da 1ª fase. Realiza a tua matrícula se foste colocado."},{"icon":"check","color":"coral","label":"3ª Fase","title":"Início das Aulas","dates":"Setembro 2026","description":"Bem-vindo à U.Porto! Começa a tua jornada académica connosco."}],"layout":"horizontal","style":"default"} /-->

<!-- wp:acesso/video-section {"align":"wide","sectionTitle":"Conhece a U.Porto","sectionSubtitle":"Descobre o que torna a nossa universidade única","videoUrl":"https://www.youtube.com/watch?v=cnMV4T_E7Aw","posterImage":"","aspectRatio":"16-9","style":"rounded"} /-->

<!-- wp:acesso/faculty-cards {"align":"wide","sectionTitle":"Faculdades","sectionSubtitle":"Conhece as 14 faculdades e a Business School da U.Porto","faculties":[],"columns":5,"style":"logos","showAcronym":false} /-->

<!-- wp:acesso/faq-accordion {"align":"wide","sectionTitle":"Perguntas Frequentes","sectionSubtitle":"Respostas às dúvidas mais comuns sobre o acesso à U.Porto","items":[{"question":"Quando são as candidaturas ao Concurso Nacional de Acesso?","answer":"As candidaturas ao Concurso Nacional de Acesso decorrem normalmente em julho, após a conclusão dos exames nacionais. As datas exatas são divulgadas anualmente pela Direção-Geral do Ensino Superior (DGES)."},{"question":"Quais são os documentos necessários para a candidatura?","answer":"Para te candidatares precisas do Cartão de Cidadão ou documento de identificação válido, certificado de habilitações do ensino secundário, e comprovativo de realização dos exames nacionais necessários."},{"question":"Posso candidatar-me a mais do que um curso?","answer":"Sim, podes indicar até 6 pares instituição/curso por ordem de preferência. A colocação é feita de acordo com as vagas disponíveis e a tua média de candidatura."},{"question":"Como é calculada a média de candidatura?","answer":"A média de candidatura resulta de uma fórmula que combina a classificação do ensino secundário com as notas dos exames nacionais, de acordo com os pesos definidos por cada curso."},{"question":"Existe apoio financeiro para estudantes?","answer":"Sim, a U.Porto oferece diversos tipos de apoio através dos Serviços de Ação Social, incluindo bolsas de estudo, alojamento em residências universitárias, e apoio alimentar nas cantinas."}],"allowMultiple":false,"style":"default","showNumbers":true} /-->

<!-- wp:acesso/cta {"align":"full","title":"Pronto para começar a tua jornada?","text":"Junta-te a mais de 35.000 estudantes e descobre porque é que a U.Porto é a escolha certa para o teu futuro.","primaryButtonText":"Explorar Cursos","primaryButtonUrl":"/cursos","secondaryButtonText":"Fala Connosco","secondaryButtonUrl":"/contacto","style":"gradient"} /-->

<!-- wp:acesso/modal {"anchorId":"video","showTrigger":false} -->
<!-- wp:acesso/video-section {"videoUrl":"https://www.youtube.com/watch?v=cnMV4T_E7Aw","aspectRatio":"16-9","style":"rounded"} /-->
<!-- /wp:acesso/modal -->
    <?php
    return ob_get_clean();
}

/**
 * Add default content to new pages using Home Page template
 */
function acesso_default_page_content($content, $post) {
    if ($post->post_type === 'page') {
        $template = get_page_template_slug($post->ID);
        if ($template === 'templates/template-home.php' && empty($content)) {
            return acesso_get_default_home_content();
        }
    }
    return $content;
}
add_filter('default_content', 'acesso_default_page_content', 10, 2);
