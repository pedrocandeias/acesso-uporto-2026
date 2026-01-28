(function (wp) {
    const { registerBlockType } = wp.blocks;
    const { InspectorControls, useBlockProps } = wp.blockEditor;
    const { PanelBody, TextControl, SelectControl, RangeControl, ToggleControl } = wp.components;
    const { useSelect } = wp.data;
    const { __ } = wp.i18n;
    const el = wp.element.createElement;

    registerBlockType('acesso/course-accordion', {
        edit: function (props) {
            const { attributes, setAttributes } = props;
            const {
                sectionTitle,
                showFilters,
                filterFaculty,
                showDestaqueOnly,
                limit
            } = attributes;

            const faculties = useSelect(function (select) {
                return select('core').getEntityRecords('taxonomy', 'faculdades', { per_page: -1 }) || [];
            }, []);

            const facultyOptions = [{ label: __('Todas as Faculdades', 'acesso-uporto'), value: 0 }];
            faculties.forEach(function (faculty) {
                facultyOptions.push({ label: faculty.name, value: faculty.id });
            });

            const blockProps = useBlockProps({
                className: 'course-accordion-editor-preview'
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
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Filtros', 'acesso-uporto'), initialOpen: true },
                        el(ToggleControl, {
                            label: __('Mostrar Filtros de Faculdade', 'acesso-uporto'),
                            checked: showFilters,
                            onChange: function (value) { setAttributes({ showFilters: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Filtrar por Faculdade', 'acesso-uporto'),
                            value: filterFaculty,
                            options: facultyOptions,
                            onChange: function (value) { setAttributes({ filterFaculty: parseInt(value) }); }
                        }),
                        el(ToggleControl, {
                            label: __('Mostrar Apenas Destaques', 'acesso-uporto'),
                            checked: showDestaqueOnly,
                            onChange: function (value) { setAttributes({ showDestaqueOnly: value }); }
                        }),
                        el(RangeControl, {
                            label: __('Limite de Cursos', 'acesso-uporto'),
                            value: limit,
                            onChange: function (value) { setAttributes({ limit: value }); },
                            min: 1,
                            max: 100
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        { className: 'course-accordion-placeholder' },
                        el('span', { className: 'dashicons dashicons-list-view' }),
                        el('h3', null, __('Course Accordion', 'acesso-uporto')),
                        el('p', null, sectionTitle || __('Lista de cursos em accordion', 'acesso-uporto')),
                        el('small', null,
                            __('Limite:', 'acesso-uporto') + ' ' + limit + ' ' + __('cursos', 'acesso-uporto') +
                            (showDestaqueOnly ? ' | ' + __('Apenas destaques', 'acesso-uporto') : '')
                        )
                    )
                )
            );
        }
    });
})(window.wp);
