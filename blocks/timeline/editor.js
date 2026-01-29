(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var TextareaControl = wp.components.TextareaControl;
    var SelectControl = wp.components.SelectControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    var iconOptions = [
        { label: 'Calendário', value: 'calendar' },
        { label: 'Editar', value: 'edit' },
        { label: 'Check', value: 'check' },
        { label: 'Relógio', value: 'clock' },
        { label: 'Estrela', value: 'star' },
        { label: 'Documento', value: 'document' },
        { label: 'Utilizador', value: 'user' },
        { label: 'Email', value: 'email' }
    ];

    var colorOptions = [
        { label: 'Ciano', value: 'cyan' },
        { label: 'Lavanda', value: 'lavender' },
        { label: 'Coral', value: 'coral' },
        { label: 'Roxo', value: 'purple' },
        { label: 'Rosa', value: 'pink' },
        { label: 'Verde', value: 'green' }
    ];

    var colorMap = {
        cyan: '#00d084',
        lavender: '#8887e2',
        coral: '#ff6b6b',
        purple: '#572ddf',
        pink: '#da2489',
        green: '#34d399'
    };

    registerBlockType('acesso/timeline', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'timeline-editor-preview'
            });

            var updatePhase = function (index, field, value) {
                var newPhases = attributes.phases.slice();
                newPhases[index] = Object.assign({}, newPhases[index]);
                newPhases[index][field] = value;
                setAttributes({ phases: newPhases });
            };

            var addPhase = function () {
                var newPhases = attributes.phases.slice();
                newPhases.push({
                    icon: 'calendar',
                    color: 'cyan',
                    label: 'Nova Fase',
                    title: '',
                    dates: '',
                    description: ''
                });
                setAttributes({ phases: newPhases });
            };

            var removePhase = function (index) {
                var newPhases = attributes.phases.slice();
                newPhases.splice(index, 1);
                setAttributes({ phases: newPhases });
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
                        el(SelectControl, {
                            label: __('Layout', 'acesso-uporto'),
                            value: attributes.layout,
                            options: [
                                { label: __('Horizontal', 'acesso-uporto'), value: 'horizontal' },
                                { label: __('Vertical', 'acesso-uporto'), value: 'vertical' }
                            ],
                            onChange: function (value) { setAttributes({ layout: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Estilo', 'acesso-uporto'),
                            value: attributes.style,
                            options: [
                                { label: __('Padrão', 'acesso-uporto'), value: 'default' },
                                { label: __('Cards', 'acesso-uporto'), value: 'cards' },
                                { label: __('Minimalista', 'acesso-uporto'), value: 'minimal' }
                            ],
                            onChange: function (value) { setAttributes({ style: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Fases', 'acesso-uporto'), initialOpen: true },
                        attributes.phases.map(function (phase, index) {
                            return el(
                                'div',
                                {
                                    key: index,
                                    style: {
                                        padding: '15px',
                                        marginBottom: '15px',
                                        background: '#f0f0f0',
                                        borderRadius: '4px',
                                        borderLeft: '3px solid ' + (colorMap[phase.color] || '#572ddf')
                                    }
                                },
                                el('strong', { style: { display: 'block', marginBottom: '10px' } },
                                    __('Fase', 'acesso-uporto') + ' ' + (index + 1)
                                ),
                                el(SelectControl, {
                                    label: __('Ícone', 'acesso-uporto'),
                                    value: phase.icon || 'calendar',
                                    options: iconOptions,
                                    onChange: function (value) { updatePhase(index, 'icon', value); }
                                }),
                                el(SelectControl, {
                                    label: __('Cor', 'acesso-uporto'),
                                    value: phase.color || 'cyan',
                                    options: colorOptions,
                                    onChange: function (value) { updatePhase(index, 'color', value); }
                                }),
                                el(TextControl, {
                                    label: __('Etiqueta', 'acesso-uporto'),
                                    value: phase.label || '',
                                    onChange: function (value) { updatePhase(index, 'label', value); },
                                    help: __('Ex: 1ª Fase', 'acesso-uporto')
                                }),
                                el(TextControl, {
                                    label: __('Título', 'acesso-uporto'),
                                    value: phase.title || '',
                                    onChange: function (value) { updatePhase(index, 'title', value); }
                                }),
                                el(TextControl, {
                                    label: __('Datas', 'acesso-uporto'),
                                    value: phase.dates || '',
                                    onChange: function (value) { updatePhase(index, 'dates', value); }
                                }),
                                el(TextareaControl, {
                                    label: __('Descrição', 'acesso-uporto'),
                                    value: phase.description || '',
                                    onChange: function (value) { updatePhase(index, 'description', value); }
                                }),
                                attributes.phases.length > 1 && el(Button, {
                                    variant: 'link',
                                    isDestructive: true,
                                    onClick: function () { removePhase(index); }
                                }, __('Remover', 'acesso-uporto'))
                            );
                        }),
                        attributes.phases.length < 5 && el(Button, {
                            variant: 'secondary',
                            onClick: addPhase,
                            style: { width: '100%', justifyContent: 'center' }
                        }, __('+ Adicionar Fase', 'acesso-uporto'))
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'timeline-preview',
                            style: {
                                padding: '30px',
                                background: '#f9f9f9',
                                borderRadius: '8px'
                            }
                        },
                        el('h3', { style: { textAlign: 'center', margin: '0 0 20px' } },
                            attributes.sectionTitle || __('Timeline', 'acesso-uporto')
                        ),
                        el('div', {
                            style: {
                                display: 'flex',
                                justifyContent: 'center',
                                gap: '20px',
                                flexWrap: 'wrap'
                            }
                        },
                            attributes.phases.map(function (phase, index) {
                                return el('div', {
                                    key: index,
                                    style: {
                                        textAlign: 'center',
                                        maxWidth: '150px'
                                    }
                                },
                                    el('div', {
                                        style: {
                                            width: '50px',
                                            height: '50px',
                                            borderRadius: '50%',
                                            background: colorMap[phase.color] || '#572ddf',
                                            margin: '0 auto 10px',
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            color: '#fff'
                                        }
                                    },
                                        el('span', { className: 'dashicons dashicons-calendar-alt' })
                                    ),
                                    el('div', { style: { fontSize: '0.75rem', color: colorMap[phase.color] || '#572ddf', fontWeight: 600 } }, phase.label),
                                    el('div', { style: { fontWeight: 600 } }, phase.title),
                                    el('div', { style: { fontSize: '0.875rem', color: '#666' } }, phase.dates)
                                );
                            })
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
