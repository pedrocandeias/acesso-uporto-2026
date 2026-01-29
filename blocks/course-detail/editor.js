(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var SelectControl = wp.components.SelectControl;
    var ToggleControl = wp.components.ToggleControl;
    var Spinner = wp.components.Spinner;
    var useSelect = wp.data.useSelect;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/course-detail', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var courses = useSelect(function (select) {
                return select('core').getEntityRecords('postType', 'cursos', { per_page: -1, orderby: 'title', order: 'asc' }) || [];
            }, []);

            var isLoading = courses.length === 0;

            var courseOptions = [{ label: __('Selecionar curso...', 'acesso-uporto'), value: 0 }];
            courses.forEach(function (course) {
                courseOptions.push({ label: course.title.rendered, value: course.id });
            });

            var selectedCourseName = '';
            for (var i = 0; i < courses.length; i++) {
                if (courses[i].id === attributes.selectedCourse) {
                    selectedCourseName = courses[i].title.rendered;
                    break;
                }
            }

            var blockProps = useBlockProps({
                className: 'course-detail-editor-preview'
            });

            // Build enabled sections list for display
            var enabledSections = [];
            if (attributes.showHeader) enabledSections.push(__('Cabeçalho', 'acesso-uporto'));
            if (attributes.showStats) enabledSections.push(__('Estatísticas', 'acesso-uporto'));
            if (attributes.showProvas) enabledSections.push(__('Provas', 'acesso-uporto'));
            if (attributes.showClassificacao) enabledSections.push(__('Classificação', 'acesso-uporto'));
            if (attributes.showFormula) enabledSections.push(__('Fórmula', 'acesso-uporto'));
            if (attributes.showPrerequisitos) enabledSections.push(__('Pré-requisitos', 'acesso-uporto'));
            if (attributes.showDescricao) enabledSections.push(__('Descrição', 'acesso-uporto'));
            if (attributes.showSaidas) enabledSections.push(__('Saídas', 'acesso-uporto'));
            if (attributes.showCta) enabledSections.push(__('CTA', 'acesso-uporto'));

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Fonte do Curso', 'acesso-uporto'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Fonte', 'acesso-uporto'),
                            value: attributes.courseSource,
                            options: [
                                { label: __('Curso Atual (páginas de curso)', 'acesso-uporto'), value: 'current' },
                                { label: __('Selecionar Curso', 'acesso-uporto'), value: 'select' }
                            ],
                            onChange: function (value) { setAttributes({ courseSource: value }); },
                            help: __('Use "Curso Atual" em templates de curso individual.', 'acesso-uporto')
                        }),
                        attributes.courseSource === 'select' && (
                            isLoading
                                ? el(Spinner)
                                : el(SelectControl, {
                                    label: __('Selecionar Curso', 'acesso-uporto'),
                                    value: attributes.selectedCourse,
                                    options: courseOptions,
                                    onChange: function (value) { setAttributes({ selectedCourse: parseInt(value) }); }
                                })
                        )
                    ),
                    el(
                        PanelBody,
                        { title: __('Estilo de Exibição', 'acesso-uporto'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Predefinição', 'acesso-uporto'),
                            value: attributes.displayStyle,
                            options: [
                                { label: __('Completo (todas as secções)', 'acesso-uporto'), value: 'full' },
                                { label: __('Apenas Cabeçalho', 'acesso-uporto'), value: 'header' },
                                { label: __('Apenas Estatísticas', 'acesso-uporto'), value: 'stats' },
                                { label: __('Apenas Informações', 'acesso-uporto'), value: 'info' },
                                { label: __('Apenas Descrição', 'acesso-uporto'), value: 'description' },
                                { label: __('Personalizado', 'acesso-uporto'), value: 'custom' }
                            ],
                            onChange: function (value) {
                                var newAttrs = { displayStyle: value };
                                // Set defaults based on style
                                if (value === 'full') {
                                    newAttrs.showHeader = true;
                                    newAttrs.showStats = true;
                                    newAttrs.showProvas = true;
                                    newAttrs.showClassificacao = true;
                                    newAttrs.showFormula = true;
                                    newAttrs.showPrerequisitos = true;
                                    newAttrs.showDescricao = true;
                                    newAttrs.showSaidas = true;
                                    newAttrs.showCta = true;
                                } else if (value === 'header') {
                                    newAttrs.showHeader = true;
                                    newAttrs.showStats = false;
                                    newAttrs.showProvas = false;
                                    newAttrs.showClassificacao = false;
                                    newAttrs.showFormula = false;
                                    newAttrs.showPrerequisitos = false;
                                    newAttrs.showDescricao = false;
                                    newAttrs.showSaidas = false;
                                    newAttrs.showCta = true;
                                } else if (value === 'stats') {
                                    newAttrs.showHeader = false;
                                    newAttrs.showStats = true;
                                    newAttrs.showProvas = false;
                                    newAttrs.showClassificacao = false;
                                    newAttrs.showFormula = false;
                                    newAttrs.showPrerequisitos = false;
                                    newAttrs.showDescricao = false;
                                    newAttrs.showSaidas = false;
                                    newAttrs.showCta = false;
                                } else if (value === 'info') {
                                    newAttrs.showHeader = false;
                                    newAttrs.showStats = false;
                                    newAttrs.showProvas = true;
                                    newAttrs.showClassificacao = true;
                                    newAttrs.showFormula = true;
                                    newAttrs.showPrerequisitos = true;
                                    newAttrs.showDescricao = false;
                                    newAttrs.showSaidas = false;
                                    newAttrs.showCta = false;
                                } else if (value === 'description') {
                                    newAttrs.showHeader = false;
                                    newAttrs.showStats = false;
                                    newAttrs.showProvas = false;
                                    newAttrs.showClassificacao = false;
                                    newAttrs.showFormula = false;
                                    newAttrs.showPrerequisitos = false;
                                    newAttrs.showDescricao = true;
                                    newAttrs.showSaidas = true;
                                    newAttrs.showCta = false;
                                }
                                setAttributes(newAttrs);
                            }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Secções Visíveis', 'acesso-uporto'), initialOpen: attributes.displayStyle === 'custom' },
                        el(ToggleControl, {
                            label: __('Cabeçalho (Título, Grau, Faculdade)', 'acesso-uporto'),
                            checked: attributes.showHeader,
                            onChange: function (value) { setAttributes({ showHeader: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Estatísticas (Duração, Vagas, Notas)', 'acesso-uporto'),
                            checked: attributes.showStats,
                            onChange: function (value) { setAttributes({ showStats: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Provas de Ingresso', 'acesso-uporto'),
                            checked: attributes.showProvas,
                            onChange: function (value) { setAttributes({ showProvas: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Classificação Mínima', 'acesso-uporto'),
                            checked: attributes.showClassificacao,
                            onChange: function (value) { setAttributes({ showClassificacao: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Fórmula de Cálculo', 'acesso-uporto'),
                            checked: attributes.showFormula,
                            onChange: function (value) { setAttributes({ showFormula: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Pré-requisitos', 'acesso-uporto'),
                            checked: attributes.showPrerequisitos,
                            onChange: function (value) { setAttributes({ showPrerequisitos: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Descrição do Curso', 'acesso-uporto'),
                            checked: attributes.showDescricao,
                            onChange: function (value) { setAttributes({ showDescricao: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Saídas Profissionais', 'acesso-uporto'),
                            checked: attributes.showSaidas,
                            onChange: function (value) { setAttributes({ showSaidas: value, displayStyle: 'custom' }); }
                        }),
                        el(ToggleControl, {
                            label: __('Botão Saber Mais', 'acesso-uporto'),
                            checked: attributes.showCta,
                            onChange: function (value) { setAttributes({ showCta: value, displayStyle: 'custom' }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        { className: 'course-detail-placeholder' },
                        el('span', { className: 'dashicons dashicons-id-alt' }),
                        el('h3', null, __('Course Detail', 'acesso-uporto')),
                        el('p', null,
                            attributes.courseSource === 'current'
                                ? __('Mostra detalhes do curso atual', 'acesso-uporto')
                                : (selectedCourseName || __('Selecione um curso', 'acesso-uporto'))
                        ),
                        el('small', null,
                            __('Secções:', 'acesso-uporto') + ' ' + (enabledSections.length > 0 ? enabledSections.join(', ') : __('Nenhuma', 'acesso-uporto'))
                        )
                    )
                )
            );
        },

        save: function () {
            return null;
        }
    });
})(window.wp);
