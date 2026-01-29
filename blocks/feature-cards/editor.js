(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var TextareaControl = wp.components.TextareaControl;
    var SelectControl = wp.components.SelectControl;
    var RangeControl = wp.components.RangeControl;
    var ToggleControl = wp.components.ToggleControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    var iconOptions = [
        { label: 'Edifício', value: 'building' },
        { label: 'Pessoas', value: 'groups' },
        { label: 'Ciência', value: 'science' },
        { label: 'Biblioteca', value: 'library' },
        { label: 'Globo', value: 'globe' },
        { label: 'Graduação', value: 'graduation' },
        { label: 'Prémio', value: 'award' },
        { label: 'Estrela', value: 'star' },
        { label: 'Coração', value: 'heart' },
        { label: 'Foguete', value: 'rocket' },
        { label: 'Lâmpada', value: 'lightbulb' },
        { label: 'Alvo', value: 'target' },
        { label: 'Calendário', value: 'calendar' },
        { label: 'Casa', value: 'home' },
        { label: 'Restaurante', value: 'restaurant' },
        { label: 'Museu', value: 'museum' }
    ];

    registerBlockType('acesso/feature-cards', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'feature-cards-editor-preview'
            });

            var updateFeature = function (index, field, value) {
                var newFeatures = attributes.features.slice();
                newFeatures[index] = Object.assign({}, newFeatures[index]);
                newFeatures[index][field] = value;
                setAttributes({ features: newFeatures });
            };

            var addFeature = function () {
                var newFeatures = attributes.features.slice();
                newFeatures.push({ icon: 'star', title: '', description: '', link: '' });
                setAttributes({ features: newFeatures });
            };

            var removeFeature = function (index) {
                var newFeatures = attributes.features.slice();
                newFeatures.splice(index, 1);
                setAttributes({ features: newFeatures });
            };

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Configurações', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('Título da Secção', 'acesso-uporto'),
                            value: attributes.sectionTitle || '',
                            onChange: function (value) { setAttributes({ sectionTitle: value }); }
                        }),
                        el(TextControl, {
                            label: __('Subtítulo', 'acesso-uporto'),
                            value: attributes.sectionSubtitle || '',
                            onChange: function (value) { setAttributes({ sectionSubtitle: value }); }
                        }),
                        el(RangeControl, {
                            label: __('Colunas', 'acesso-uporto'),
                            value: attributes.columns,
                            onChange: function (value) { setAttributes({ columns: value }); },
                            min: 2,
                            max: 6
                        }),
                        el(SelectControl, {
                            label: __('Estilo', 'acesso-uporto'),
                            value: attributes.style,
                            options: [
                                { label: __('Padrão', 'acesso-uporto'), value: 'default' },
                                { label: __('Cards Elevados', 'acesso-uporto'), value: 'elevated' },
                                { label: __('Com Bordas', 'acesso-uporto'), value: 'bordered' },
                                { label: __('Gradiente', 'acesso-uporto'), value: 'gradient' },
                                { label: __('Minimalista', 'acesso-uporto'), value: 'minimal' }
                            ],
                            onChange: function (value) { setAttributes({ style: value }); }
                        }),
                        el(ToggleControl, {
                            label: __('Mostrar Ícones', 'acesso-uporto'),
                            checked: attributes.showIcons,
                            onChange: function (value) { setAttributes({ showIcons: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Features', 'acesso-uporto'), initialOpen: true },
                        attributes.features.map(function (feature, index) {
                            return el(
                                'div',
                                {
                                    key: index,
                                    style: {
                                        padding: '15px',
                                        marginBottom: '15px',
                                        background: '#f0f0f0',
                                        borderRadius: '4px'
                                    }
                                },
                                el('strong', { style: { display: 'block', marginBottom: '10px' } },
                                    __('Feature', 'acesso-uporto') + ' ' + (index + 1)
                                ),
                                el(SelectControl, {
                                    label: __('Ícone', 'acesso-uporto'),
                                    value: feature.icon || 'star',
                                    options: iconOptions,
                                    onChange: function (value) { updateFeature(index, 'icon', value); }
                                }),
                                el(TextControl, {
                                    label: __('Título', 'acesso-uporto'),
                                    value: feature.title || '',
                                    onChange: function (value) { updateFeature(index, 'title', value); }
                                }),
                                el(TextareaControl, {
                                    label: __('Descrição', 'acesso-uporto'),
                                    value: feature.description || '',
                                    onChange: function (value) { updateFeature(index, 'description', value); }
                                }),
                                el(TextControl, {
                                    label: __('Link (opcional)', 'acesso-uporto'),
                                    value: feature.link || '',
                                    onChange: function (value) { updateFeature(index, 'link', value); }
                                }),
                                attributes.features.length > 1 && el(Button, {
                                    variant: 'link',
                                    isDestructive: true,
                                    onClick: function () { removeFeature(index); }
                                }, __('Remover', 'acesso-uporto'))
                            );
                        }),
                        el(Button, {
                            variant: 'secondary',
                            onClick: addFeature,
                            style: { width: '100%', justifyContent: 'center' }
                        }, __('+ Adicionar Feature', 'acesso-uporto'))
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'feature-cards-preview',
                            style: {
                                display: 'grid',
                                gridTemplateColumns: 'repeat(' + Math.min(attributes.columns, attributes.features.length) + ', 1fr)',
                                gap: '20px',
                                padding: '30px',
                                background: '#f9f9f9',
                                borderRadius: '8px'
                            }
                        },
                        attributes.features.slice(0, 6).map(function (feature, index) {
                            return el(
                                'div',
                                {
                                    key: index,
                                    style: {
                                        background: '#fff',
                                        padding: '20px',
                                        borderRadius: '8px',
                                        textAlign: 'center',
                                        boxShadow: '0 2px 10px rgba(0,0,0,0.05)'
                                    }
                                },
                                attributes.showIcons && el('span', {
                                    className: 'dashicons dashicons-star-filled',
                                    style: { fontSize: '32px', color: '#572ddf', marginBottom: '10px', display: 'block' }
                                }),
                                el('h4', { style: { margin: '0 0 5px', fontSize: '1.25rem' } }, feature.title || __('Título', 'acesso-uporto')),
                                el('p', { style: { margin: 0, color: '#666', fontSize: '0.875rem' } }, feature.description || __('Descrição', 'acesso-uporto'))
                            );
                        })
                    )
                )
            );
        },

        save: function () {
            return null;
        }
    });
})(window.wp);
