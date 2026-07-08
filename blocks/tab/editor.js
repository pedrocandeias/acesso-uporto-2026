(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var InnerBlocks = wp.blockEditor.InnerBlocks;
    var RichText = wp.blockEditor.RichText;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/tab', {
        edit: function (props) {
            var blockProps = useBlockProps({ className: 'acesso-tab-panel-editor' });
            return el(
                'div',
                blockProps,
                el(RichText, {
                    tagName: 'div',
                    className: 'acesso-tab-editor-title',
                    value: props.attributes.title,
                    allowedFormats: [],
                    placeholder: __('Título do separador…', 'acesso-uporto'),
                    onChange: function (v) { props.setAttributes({ title: v }); }
                }),
                el(InnerBlocks, { templateLock: false })
            );
        },
        save: function () {
            return el(InnerBlocks.Content);
        }
    });
})(window.wp);
