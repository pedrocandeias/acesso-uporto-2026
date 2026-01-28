(function (wp) {
    const { registerBlockType } = wp.blocks;
    const { InspectorControls, useBlockProps } = wp.blockEditor;
    const { PanelBody, SelectControl, Spinner } = wp.components;
    const { useSelect } = wp.data;
    const { __ } = wp.i18n;
    const el = wp.element.createElement;

    registerBlockType('acesso/course-detail', {
        edit: function (props) {
            const { attributes, setAttributes } = props;
            const {
                courseSource,
                selectedCourse,
                displayStyle
            } = attributes;

            const { courses, isLoading } = useSelect(function (select) {
                return {
                    courses: select('core').getEntityRecords('postType', 'cursos', { per_page: -1, orderby: 'title', order: 'asc' }) || [],
                    isLoading: select('core/data').isResolving('core', 'getEntityRecords', ['postType', 'cursos', { per_page: -1 }])
                };
            }, []);

            const courseOptions = [{ label: __('Selecionar curso...', 'acesso-uporto'), value: 0 }];
            courses.forEach(function (course) {
                courseOptions.push({ label: course.title.rendered, value: course.id });
            });

            const selectedCourseName = courses.find(c => c.id === selectedCourse)?.title?.rendered || '';

            const blockProps = useBlockProps({
                className: 'course-detail-editor-preview'
            });

            return el(
                'div',
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Fonte do Curso', 'acesso-uporto'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Fonte', 'acesso-uporto'),
                            value: courseSource,
                            options: [
                                { label: __('Curso Atual (páginas de curso)', 'acesso-uporto'), value: 'current' },
                                { label: __('Selecionar Curso', 'acesso-uporto'), value: 'select' }
                            ],
                            onChange: function (value) { setAttributes({ courseSource: value }); },
                            help: __('Use "Curso Atual" em templates de curso individual.', 'acesso-uporto')
                        }),
                        courseSource === 'select' && (
                            isLoading
                                ? el(Spinner)
                                : el(SelectControl, {
                                    label: __('Selecionar Curso', 'acesso-uporto'),
                                    value: selectedCourse,
                                    options: courseOptions,
                                    onChange: function (value) { setAttributes({ selectedCourse: parseInt(value) }); }
                                })
                        )
                    ),
                    el(
                        PanelBody,
                        { title: __('Exibição', 'acesso-uporto'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Estilo de Exibição', 'acesso-uporto'),
                            value: displayStyle,
                            options: [
                                { label: __('Completo (todas as secções)', 'acesso-uporto'), value: 'full' },
                                { label: __('Apenas Cabeçalho', 'acesso-uporto'), value: 'header' },
                                { label: __('Apenas Estatísticas', 'acesso-uporto'), value: 'stats' },
                                { label: __('Apenas Informações', 'acesso-uporto'), value: 'info' },
                                { label: __('Apenas Descrição', 'acesso-uporto'), value: 'description' }
                            ],
                            onChange: function (value) { setAttributes({ displayStyle: value }); }
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
                            courseSource === 'current'
                                ? __('Mostra detalhes do curso atual', 'acesso-uporto')
                                : (selectedCourseName || __('Selecione um curso', 'acesso-uporto'))
                        ),
                        el('small', null, __('Estilo:', 'acesso-uporto') + ' ' + displayStyle)
                    )
                )
            );
        }
    });
})(window.wp);
