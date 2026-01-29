(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var SelectControl = wp.components.SelectControl;
    var RangeControl = wp.components.RangeControl;
    var ToggleControl = wp.components.ToggleControl;
    var useSelect = wp.data.useSelect;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/course-accordion', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var faculties = useSelect(function (select) {
                return select('core').getEntityRecords('taxonomy', 'faculdades', { per_page: -1 }) || [];
            }, []);

            var facultyOptions = [{ label: __('Todas as Faculdades', 'acesso-uporto'), value: 0 }];
            faculties.forEach(function (faculty) {
                facultyOptions.push({ label: faculty.name, value: faculty.id });
            });

            var blockProps = useBlockProps({
                className: 'course-accordion-editor-preview'
            });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Conteúdo', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('Título da Secção', 'acesso-uporto'),
                            value: attributes.sectionTitle || '',
                            onChange: function (value) { setAttributes({ sectionTitle: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Filtros', 'acesso-uporto'), initialOpen: true },
                        el(ToggleControl, {
                            label: __('Mostrar Filtros de Faculdade', 'acesso-uporto'),
                            checked: attributes.showFilters,
                            onChange: function (value) { setAttributes({ showFilters: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Filtrar por Faculdade', 'acesso-uporto'),
                            value: attributes.filterFaculty,
                            options: facultyOptions,
                            onChange: function (value) { setAttributes({ filterFaculty: parseInt(value) }); }
                        }),
                        el(ToggleControl, {
                            label: __('Mostrar Apenas Destaques', 'acesso-uporto'),
                            checked: attributes.showDestaqueOnly,
                            onChange: function (value) { setAttributes({ showDestaqueOnly: value }); }
                        }),
                        el(RangeControl, {
                            label: __('Limite de Cursos', 'acesso-uporto'),
                            value: attributes.limit,
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
                        el('p', null, attributes.sectionTitle || __('Lista de cursos em accordion', 'acesso-uporto')),
                        el('small', null,
                            __('Limite:', 'acesso-uporto') + ' ' + attributes.limit + ' ' + __('cursos', 'acesso-uporto') +
                            (attributes.showDestaqueOnly ? ' | ' + __('Apenas destaques', 'acesso-uporto') : '')
                        )
                    )
                )
            );
        },

        save: function() {
            return null;
        }
    });
})(window.wp);
