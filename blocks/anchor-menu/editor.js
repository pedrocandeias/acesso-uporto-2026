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

    registerBlockType('acesso/anchor-menu', {
        edit: function (props) {
            var a = props.attributes;
            var setAttributes = props.setAttributes;
            var items = a.items || [];

            function updateItem(i, key, value) {
                var next = items.map(function (it, idx) {
                    return idx === i ? Object.assign({}, it, (function () { var o = {}; o[key] = value; return o; })()) : it;
                });
                setAttributes({ items: next });
            }
            function addItem() {
                setAttributes({ items: items.concat([{ label: '', url: '#', target: '_self' }]) });
            }
            function removeItem(i) {
                setAttributes({ items: items.filter(function (_, idx) { return idx !== i; }) });
            }

            var blockProps = useBlockProps({ className: 'acesso-anchor-menu align-' + a.alignment + (a.sticky ? ' is-sticky' : '') });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Definições do menu', 'acesso-uporto'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Alinhamento', 'acesso-uporto'),
                            value: a.alignment,
                            options: [
                                { label: 'Centro', value: 'center' },
                                { label: 'Esquerda', value: 'left' },
                                { label: 'Direita', value: 'right' }
                            ],
                            onChange: function (v) { setAttributes({ alignment: v }); }
                        }),
                        el(ToggleControl, {
                            label: __('Fixar no topo (sticky)', 'acesso-uporto'),
                            checked: a.sticky,
                            onChange: function (v) { setAttributes({ sticky: v }); }
                        }),
                        el(TextControl, {
                            label: __('ID (âncora)', 'acesso-uporto'),
                            value: a.anchorId,
                            onChange: function (v) { setAttributes({ anchorId: v }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Itens', 'acesso-uporto'), initialOpen: true },
                        items.map(function (it, i) {
                            return el(
                                'div',
                                { key: i, style: { borderBottom: '1px solid #ddd', paddingBottom: '8px', marginBottom: '8px' } },
                                el(TextControl, {
                                    label: __('Texto', 'acesso-uporto') + ' ' + (i + 1),
                                    value: it.label,
                                    onChange: function (v) { updateItem(i, 'label', v); }
                                }),
                                el(TextControl, {
                                    label: __('URL', 'acesso-uporto'),
                                    value: it.url,
                                    onChange: function (v) { updateItem(i, 'url', v); }
                                }),
                                el(Button, { isDestructive: true, variant: 'secondary', onClick: function () { removeItem(i); } },
                                    __('Remover', 'acesso-uporto'))
                            );
                        }),
                        el(Button, { variant: 'primary', onClick: addItem }, __('Adicionar item', 'acesso-uporto'))
                    )
                ),
                el(
                    'nav',
                    blockProps,
                    el('ul', { className: 'acesso-anchor-menu-list' },
                        items.length
                            ? items.map(function (it, i) {
                                return el('li', { key: i, className: 'acesso-anchor-menu-item' },
                                    el('a', { href: it.url }, it.label || '(sem texto)'));
                            })
                            : el('li', { className: 'acesso-anchor-menu-item' }, __('Adiciona itens na barra lateral…', 'acesso-uporto'))
                    )
                )
            );
        },
        save: function () {
            return null;
        }
    });
})(window.wp);
