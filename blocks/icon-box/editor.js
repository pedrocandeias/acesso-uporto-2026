(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var InnerBlocks = wp.blockEditor.InnerBlocks;
    var RichText = wp.blockEditor.RichText;
    var PanelBody = wp.components.PanelBody;
    var SelectControl = wp.components.SelectControl;
    var TextControl = wp.components.TextControl;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    // Pré-visualização dos ícones no editor (espelha blocks/icon-box/icons.php).
    var iconSvgs = {
        phone: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        envelope: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
        whatsapp: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>',
        home: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
        'map-pin': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
        clock: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        calendar: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        user: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        globe: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
        info: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
        star: '<svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>'
    };

    var iconOptions = [
        { label: 'Telefone', value: 'phone' },
        { label: 'Envelope / E-mail', value: 'envelope' },
        { label: 'WhatsApp', value: 'whatsapp' },
        { label: 'Casa', value: 'home' },
        { label: 'Localização', value: 'map-pin' },
        { label: 'Relógio / Horário', value: 'clock' },
        { label: 'Calendário', value: 'calendar' },
        { label: 'Utilizador', value: 'user' },
        { label: 'Globo', value: 'globe' },
        { label: 'Informação', value: 'info' },
        { label: 'Estrela', value: 'star' }
    ];

    registerBlockType('acesso/icon-box', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className:
                    'icon-box align-' + attributes.alignment +
                    ' position-' + attributes.position +
                    ' icon-style-' + attributes.iconStyle
            });

            var iconMarkup = iconSvgs[attributes.icon] || iconSvgs.star;

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Definições da caixa', 'acesso-uporto'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Ícone', 'acesso-uporto'),
                            value: attributes.icon,
                            options: iconOptions,
                            onChange: function (v) { setAttributes({ icon: v }); }
                        }),
                        el(SelectControl, {
                            label: __('Posição do ícone', 'acesso-uporto'),
                            value: attributes.position,
                            options: [
                                { label: 'Ícone em cima', value: 'top' },
                                { label: 'Ícone ao lado do título', value: 'inline' },
                                { label: 'Ícone ao lado do conteúdo', value: 'side' }
                            ],
                            onChange: function (v) { setAttributes({ position: v }); }
                        }),
                        el(SelectControl, {
                            label: __('Alinhamento', 'acesso-uporto'),
                            value: attributes.alignment,
                            options: [
                                { label: 'Centro', value: 'center' },
                                { label: 'Esquerda', value: 'left' },
                                { label: 'Direita', value: 'right' }
                            ],
                            onChange: function (v) { setAttributes({ alignment: v }); }
                        }),
                        el(SelectControl, {
                            label: __('Estilo do ícone', 'acesso-uporto'),
                            value: attributes.iconStyle,
                            options: [
                                { label: 'Gradiente (preenchido)', value: 'gradient' },
                                { label: 'Simples (só cor)', value: 'plain' },
                                { label: 'Círculo contornado', value: 'outline' }
                            ],
                            onChange: function (v) { setAttributes({ iconStyle: v }); }
                        }),
                        el(TextControl, {
                            label: __('Link (opcional)', 'acesso-uporto'),
                            value: attributes.link,
                            onChange: function (v) { setAttributes({ link: v }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el('div', {
                        className: 'icon-box-icon',
                        dangerouslySetInnerHTML: { __html: iconMarkup }
                    }),
                    el(
                        'div',
                        { className: 'icon-box-body' },
                        el(RichText, {
                            tagName: 'h3',
                            className: 'icon-box-title',
                            value: attributes.title,
                            allowedFormats: [],
                            placeholder: __('Título…', 'acesso-uporto'),
                            onChange: function (v) { setAttributes({ title: v }); }
                        }),
                        el(
                            'div',
                            { className: 'icon-box-content' },
                            el(InnerBlocks, {
                                template: [['core/paragraph', { placeholder: 'Conteúdo…' }]],
                                templateLock: false
                            })
                        )
                    )
                )
            );
        },
        save: function () {
            return el(InnerBlocks.Content);
        }
    });
})(window.wp);
