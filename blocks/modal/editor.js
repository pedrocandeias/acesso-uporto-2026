(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InnerBlocks = wp.blockEditor.InnerBlocks;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var ToggleControl = wp.components.ToggleControl;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/modal', {
        edit: function (props) {
            var a = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps({ className: 'acesso-modal-editor' });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Modal', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('ID (âncora)', 'acesso-uporto'),
                            help: __('Links <a href="#este-id"> também abrem o modal.', 'acesso-uporto'),
                            value: a.anchorId,
                            onChange: function (v) { setAttributes({ anchorId: v }); }
                        }),
                        el(ToggleControl, {
                            label: __('Mostrar botão-gatilho', 'acesso-uporto'),
                            checked: a.showTrigger,
                            onChange: function (v) { setAttributes({ showTrigger: v }); }
                        }),
                        a.showTrigger && el(TextControl, {
                            label: __('Texto do botão', 'acesso-uporto'),
                            value: a.triggerLabel,
                            onChange: function (v) { setAttributes({ triggerLabel: v }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el('div', { className: 'acesso-modal-editor-label' },
                        __('Conteúdo do modal', 'acesso-uporto') + (a.anchorId ? ' (#' + a.anchorId + ')' : '')),
                    el(InnerBlocks, { templateLock: false })
                )
            );
        },
        save: function () {
            return el(InnerBlocks.Content);
        }
    });
})(window.wp);
