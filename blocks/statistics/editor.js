(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var SelectControl = wp.components.SelectControl;
    var ToggleControl = wp.components.ToggleControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;
    var useState = wp.element.useState;

    registerBlockType('acesso/statistics', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'statistics-editor-preview'
            });

            var updateStat = function (index, field, value) {
                var newStats = attributes.stats.slice();
                newStats[index] = Object.assign({}, newStats[index]);
                newStats[index][field] = value;
                setAttributes({ stats: newStats });
            };

            var addStat = function () {
                var newStats = attributes.stats.slice();
                newStats.push({ number: '0', suffix: '', label: 'Nova Estatística', icon: 'star' });
                setAttributes({ stats: newStats });
            };

            var removeStat = function (index) {
                var newStats = attributes.stats.slice();
                newStats.splice(index, 1);
                setAttributes({ stats: newStats });
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
                        el(SelectControl, {
                            label: __('Layout', 'acesso-uporto'),
                            value: attributes.layout,
                            options: [
                                { label: __('2 Colunas', 'acesso-uporto'), value: 'grid-2' },
                                { label: __('3 Colunas', 'acesso-uporto'), value: 'grid-3' },
                                { label: __('4 Colunas', 'acesso-uporto'), value: 'grid-4' },
                                { label: __('5 Colunas', 'acesso-uporto'), value: 'grid-5' }
                            ],
                            onChange: function (value) { setAttributes({ layout: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Estilo', 'acesso-uporto'),
                            value: attributes.style,
                            options: [
                                { label: __('Padrão', 'acesso-uporto'), value: 'default' },
                                { label: __('Cards', 'acesso-uporto'), value: 'cards' },
                                { label: __('Minimalista', 'acesso-uporto'), value: 'minimal' },
                                { label: __('Com Ícones', 'acesso-uporto'), value: 'icons' }
                            ],
                            onChange: function (value) { setAttributes({ style: value }); }
                        }),
                        el(ToggleControl, {
                            label: __('Animar ao Scroll', 'acesso-uporto'),
                            checked: attributes.animateOnScroll,
                            onChange: function (value) { setAttributes({ animateOnScroll: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Estatísticas', 'acesso-uporto'), initialOpen: true },
                        attributes.stats.map(function (stat, index) {
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
                                    __('Estatística', 'acesso-uporto') + ' ' + (index + 1)
                                ),
                                el(TextControl, {
                                    label: __('Número', 'acesso-uporto'),
                                    value: stat.number || '',
                                    onChange: function (value) { updateStat(index, 'number', value); }
                                }),
                                el(TextControl, {
                                    label: __('Sufixo', 'acesso-uporto'),
                                    value: stat.suffix || '',
                                    onChange: function (value) { updateStat(index, 'suffix', value); },
                                    help: __('Ex: +, %, M, K', 'acesso-uporto')
                                }),
                                el(TextControl, {
                                    label: __('Descrição', 'acesso-uporto'),
                                    value: stat.label || '',
                                    onChange: function (value) { updateStat(index, 'label', value); }
                                }),
                                el(SelectControl, {
                                    label: __('Ícone', 'acesso-uporto'),
                                    value: stat.icon || 'star',
                                    options: [
                                        { label: 'Estrela', value: 'star' },
                                        { label: 'Edifício', value: 'building' },
                                        { label: 'Pessoas', value: 'groups' },
                                        { label: 'Ciência', value: 'science' },
                                        { label: 'Biblioteca', value: 'library' },
                                        { label: 'Globo', value: 'globe' },
                                        { label: 'Prémio', value: 'award' },
                                        { label: 'Gráfico', value: 'chart' }
                                    ],
                                    onChange: function (value) { updateStat(index, 'icon', value); }
                                }),
                                attributes.stats.length > 1 && el(Button, {
                                    variant: 'link',
                                    isDestructive: true,
                                    onClick: function () { removeStat(index); }
                                }, __('Remover', 'acesso-uporto'))
                            );
                        }),
                        el(Button, {
                            variant: 'secondary',
                            onClick: addStat,
                            style: { width: '100%', justifyContent: 'center' }
                        }, __('+ Adicionar Estatística', 'acesso-uporto'))
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        { className: 'statistics-preview' },
                        el('span', { className: 'dashicons dashicons-chart-bar', style: { fontSize: '40px', marginBottom: '10px' } }),
                        el('h3', null, __('Statistics Counter', 'acesso-uporto')),
                        el('p', null, attributes.sectionTitle || __('Estatísticas em destaque', 'acesso-uporto')),
                        el('small', null,
                            attributes.stats.length + ' ' + __('estatísticas', 'acesso-uporto') + ' | ' +
                            __('Layout:', 'acesso-uporto') + ' ' + attributes.layout
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
