(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var InnerBlocks = wp.blockEditor.InnerBlocks;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    var ALLOWED = ['acesso/tab'];
    var TEMPLATE = [
        ['acesso/tab', { title: 'Separador 1' }],
        ['acesso/tab', { title: 'Separador 2' }]
    ];

    registerBlockType('acesso/tabs', {
        edit: function () {
            var blockProps = useBlockProps({ className: 'acesso-tabs-editor' });
            return el(
                'div',
                blockProps,
                el(InnerBlocks, {
                    allowedBlocks: ALLOWED,
                    template: TEMPLATE,
                    templateLock: false,
                    renderAppender: InnerBlocks.ButtonBlockAppender
                })
            );
        },
        save: function () {
            return el(InnerBlocks.Content);
        }
    });
})(window.wp);
