(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var TextareaControl = wp.components.TextareaControl;
    var SelectControl = wp.components.SelectControl;
    var ToggleControl = wp.components.ToggleControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/faq-accordion', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'faq-accordion-editor-preview'
            });

            var updateItem = function (index, field, value) {
                var newItems = attributes.items.slice();
                newItems[index] = Object.assign({}, newItems[index]);
                newItems[index][field] = value;
                setAttributes({ items: newItems });
            };

            var addItem = function () {
                var newItems = attributes.items.slice();
                newItems.push({
                    question: '',
                    answer: ''
                });
                setAttributes({ items: newItems });
            };

            var removeItem = function (index) {
                var newItems = attributes.items.slice();
                newItems.splice(index, 1);
                setAttributes({ items: newItems });
            };

            var moveItem = function (index, direction) {
                var newItems = attributes.items.slice();
                var newIndex = index + direction;

                if (newIndex < 0 || newIndex >= newItems.length) return;

                var item = newItems[index];
                newItems.splice(index, 1);
                newItems.splice(newIndex, 0, item);

                setAttributes({ items: newItems });
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
                            label: __('Estilo', 'acesso-uporto'),
                            value: attributes.variant,
                            options: [
                                { label: __('Padrão', 'acesso-uporto'), value: 'default' },
                                { label: __('Cards', 'acesso-uporto'), value: 'cards' },
                                { label: __('Minimalista', 'acesso-uporto'), value: 'minimal' },
                                { label: __('Com Bordas', 'acesso-uporto'), value: 'bordered' }
                            ],
                            onChange: function (value) { setAttributes({ variant: value }); }
                        }),
                        el(ToggleControl, {
                            label: __('Permitir Múltiplos Abertos', 'acesso-uporto'),
                            checked: attributes.allowMultiple,
                            onChange: function (value) { setAttributes({ allowMultiple: value }); }
                        }),
                        el(ToggleControl, {
                            label: __('Mostrar Números', 'acesso-uporto'),
                            checked: attributes.showNumbers,
                            onChange: function (value) { setAttributes({ showNumbers: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Perguntas & Respostas', 'acesso-uporto'), initialOpen: true },
                        attributes.items.map(function (item, index) {
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
                                el('div', {
                                    style: {
                                        display: 'flex',
                                        justifyContent: 'space-between',
                                        alignItems: 'center',
                                        marginBottom: '10px'
                                    }
                                },
                                    el('strong', null, __('Pergunta', 'acesso-uporto') + ' ' + (index + 1)),
                                    el('div', { style: { display: 'flex', gap: '4px' } },
                                        index > 0 && el(Button, {
                                            icon: 'arrow-up-alt2',
                                            label: __('Mover para cima', 'acesso-uporto'),
                                            onClick: function () { moveItem(index, -1); },
                                            size: 'small'
                                        }),
                                        index < attributes.items.length - 1 && el(Button, {
                                            icon: 'arrow-down-alt2',
                                            label: __('Mover para baixo', 'acesso-uporto'),
                                            onClick: function () { moveItem(index, 1); },
                                            size: 'small'
                                        })
                                    )
                                ),
                                el(TextControl, {
                                    label: __('Pergunta', 'acesso-uporto'),
                                    value: item.question || '',
                                    onChange: function (value) { updateItem(index, 'question', value); }
                                }),
                                el(TextareaControl, {
                                    label: __('Resposta', 'acesso-uporto'),
                                    value: item.answer || '',
                                    onChange: function (value) { updateItem(index, 'answer', value); },
                                    rows: 3
                                }),
                                attributes.items.length > 1 && el(Button, {
                                    variant: 'link',
                                    isDestructive: true,
                                    onClick: function () { removeItem(index); }
                                }, __('Remover', 'acesso-uporto'))
                            );
                        }),
                        el(Button, {
                            variant: 'secondary',
                            onClick: addItem,
                            style: { width: '100%', justifyContent: 'center' }
                        }, __('+ Adicionar Pergunta', 'acesso-uporto'))
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'faq-preview',
                            style: {
                                padding: '30px',
                                background: '#f9f9f9',
                                borderRadius: '8px'
                            }
                        },
                        el('div', { style: { textAlign: 'center', marginBottom: '20px' } },
                            el('span', { className: 'dashicons dashicons-editor-help', style: { fontSize: '32px', color: '#572ddf' } }),
                            el('h3', { style: { margin: '10px 0 5px' } }, attributes.sectionTitle || __('FAQ', 'acesso-uporto')),
                            attributes.sectionSubtitle && el('p', { style: { color: '#666', margin: 0 } }, attributes.sectionSubtitle)
                        ),
                        el('div', { className: 'faq-items-preview' },
                            attributes.items.slice(0, 3).map(function (item, index) {
                                return el('div', {
                                    key: index,
                                    style: {
                                        background: '#fff',
                                        padding: '15px',
                                        marginBottom: '10px',
                                        borderRadius: '8px',
                                        borderLeft: '3px solid #572ddf'
                                    }
                                },
                                    el('div', {
                                        style: {
                                            display: 'flex',
                                            alignItems: 'center',
                                            gap: '10px'
                                        }
                                    },
                                        attributes.showNumbers && el('span', {
                                            style: {
                                                width: '24px',
                                                height: '24px',
                                                background: 'linear-gradient(135deg, #572ddf, #da2489)',
                                                color: '#fff',
                                                borderRadius: '50%',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                fontSize: '12px',
                                                fontWeight: 600,
                                                flexShrink: 0
                                            }
                                        }, index + 1),
                                        el('span', { style: { fontWeight: 600 } }, item.question || __('Pergunta', 'acesso-uporto'))
                                    )
                                );
                            }),
                            attributes.items.length > 3 && el('p', {
                                style: { textAlign: 'center', color: '#888', fontSize: '14px', margin: '10px 0 0' }
                            }, '+ ' + (attributes.items.length - 3) + ' ' + __('mais perguntas', 'acesso-uporto'))
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
