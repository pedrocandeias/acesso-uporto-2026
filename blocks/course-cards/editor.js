(function (wp) {
    const { registerBlockType } = wp.blocks;
    const { InspectorControls, useBlockProps } = wp.blockEditor;
    const { PanelBody, TextControl, SelectControl, RangeControl, ToggleControl } = wp.components;
    const { useSelect } = wp.data;
    const { __ } = wp.i18n;
    const el = wp.element.createElement;

    registerBlockType('acesso/course-cards', {
        edit: function (props) {
            const { attributes, setAttributes } = props;
            const {
                sectionTitle,
                sectionSubtitle,
                layout,
                cardStyle,
                filterType,
                filterFaculty,
                limit,
                showFilters,
                showCta,
                ctaText
            } = attributes;

            const faculties = useSelect(function (select) {
                return select('core').getEntityRecords('taxonomy', 'faculdades', { per_page: -1 }) || [];
            }, []);

            const facultyOptions = [{ label: __('Todas as Faculdades', 'acesso-uporto'), value: 0 }];
            faculties.forEach(function (faculty) {
                facultyOptions.push({ label: faculty.name, value: faculty.id });
            });

            const blockProps = useBlockProps({
                className: 'course-cards-editor-preview'
            });

            return el(
                'div',
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Conteúdo', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('Título da Secção', 'acesso-uporto'),
                            value: sectionTitle,
                            onChange: function (value) { setAttributes({ sectionTitle: value }); }
                        }),
                        el(TextControl, {
                            label: __('Subtítulo', 'acesso-uporto'),
                            value: sectionSubtitle,
                            onChange: function (value) { setAttributes({ sectionSubtitle: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Layout', 'acesso-uporto'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Disposição', 'acesso-uporto'),
                            value: layout,
                            options: [
                                { label: __('2 Colunas', 'acesso-uporto'), value: 'grid-2' },
                                { label: __('3 Colunas', 'acesso-uporto'), value: 'grid-3' },
                                { label: __('4 Colunas', 'acesso-uporto'), value: 'grid-4' },
                                { label: __('Carrossel', 'acesso-uporto'), value: 'carousel' }
                            ],
                            onChange: function (value) { setAttributes({ layout: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Estilo dos Cards', 'acesso-uporto'),
                            value: cardStyle,
                            options: [
                                { label: __('Padrão (Sombra)', 'acesso-uporto'), value: 'default' },
                                { label: __('Gradiente Suave', 'acesso-uporto'), value: 'gradient' },
                                { label: __('Com Borda', 'acesso-uporto'), value: 'bordered' },
                                { label: __('Minimalista', 'acesso-uporto'), value: 'minimal' },
                                { label: __('Fundo Escuro', 'acesso-uporto'), value: 'dark' }
                            ],
                            onChange: function (value) { setAttributes({ cardStyle: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Filtros', 'acesso-uporto'), initialOpen: false },
                        el(SelectControl, {
                            label: __('Tipo de Cursos', 'acesso-uporto'),
                            value: filterType,
                            options: [
                                { label: __('Todos os Cursos', 'acesso-uporto'), value: 'all' },
                                { label: __('Apenas Destaques', 'acesso-uporto'), value: 'destaque' },
                                { label: __('Apenas Novos', 'acesso-uporto'), value: 'novo' }
                            ],
                            onChange: function (value) { setAttributes({ filterType: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Faculdade', 'acesso-uporto'),
                            value: filterFaculty,
                            options: facultyOptions,
                            onChange: function (value) { setAttributes({ filterFaculty: parseInt(value) }); }
                        }),
                        el(RangeControl, {
                            label: __('Número de Cursos', 'acesso-uporto'),
                            value: limit,
                            onChange: function (value) { setAttributes({ limit: value }); },
                            min: 1,
                            max: 50
                        }),
                        el(ToggleControl, {
                            label: __('Mostrar Filtros de Faculdade', 'acesso-uporto'),
                            checked: showFilters,
                            onChange: function (value) { setAttributes({ showFilters: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Botão CTA', 'acesso-uporto'), initialOpen: false },
                        el(ToggleControl, {
                            label: __('Mostrar Botão Ver Todos', 'acesso-uporto'),
                            checked: showCta,
                            onChange: function (value) { setAttributes({ showCta: value }); }
                        }),
                        showCta && el(TextControl, {
                            label: __('Texto do Botão', 'acesso-uporto'),
                            value: ctaText,
                            onChange: function (value) { setAttributes({ ctaText: value }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        { className: 'course-cards-placeholder' },
                        el('span', { className: 'dashicons dashicons-grid-view' }),
                        el('h3', null, __('Course Cards', 'acesso-uporto')),
                        el('p', null, sectionTitle || __('Cursos em formato de cards', 'acesso-uporto')),
                        el('small', null,
                            __('Layout:', 'acesso-uporto') + ' ' + layout + ' | ' +
                            __('Limite:', 'acesso-uporto') + ' ' + limit + ' ' + __('cursos', 'acesso-uporto')
                        )
                    )
                )
            );
        }
    });
})(window.wp);
