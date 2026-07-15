(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var MediaUpload = wp.blockEditor.MediaUpload;
    var MediaUploadCheck = wp.blockEditor.MediaUploadCheck;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var TextareaControl = wp.components.TextareaControl;
    var SelectControl = wp.components.SelectControl;
    var RangeControl = wp.components.RangeControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    var styleOptions = [
        { label: __('Gradiente', 'acesso-uporto'), value: 'gradient' },
        { label: __('Escuro', 'acesso-uporto'), value: 'dark' },
        { label: __('Claro', 'acesso-uporto'), value: 'light' },
        { label: __('Com Imagem', 'acesso-uporto'), value: 'image' }
    ];

    var styleColors = {
        gradient: { bg: 'linear-gradient(135deg, #572ddf 0%, #da2489 100%)', text: '#fff' },
        dark: { bg: '#060221', text: '#fff' },
        light: { bg: '#f9f9f9', text: '#060221' },
        image: { bg: 'linear-gradient(135deg, rgba(87,45,223,0.9), rgba(218,36,137,0.9))', text: '#fff' }
    };

    registerBlockType('acesso/cta', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'cta-editor-preview'
            });

            var currentStyle = styleColors[attributes.style] || styleColors.gradient;

            var onSelectImage = function (media) {
                setAttributes({
                    backgroundImage: media.url,
                    backgroundImageId: media.id
                });
            };

            var onRemoveImage = function () {
                setAttributes({
                    backgroundImage: '',
                    backgroundImageId: 0
                });
            };

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
                            label: __('Título', 'acesso-uporto'),
                            value: attributes.title || '',
                            onChange: function (value) { setAttributes({ title: value }); }
                        }),
                        el(TextareaControl, {
                            label: __('Texto', 'acesso-uporto'),
                            value: attributes.text || '',
                            onChange: function (value) { setAttributes({ text: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Botões', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('Texto Botão Principal', 'acesso-uporto'),
                            value: attributes.primaryButtonText || '',
                            onChange: function (value) { setAttributes({ primaryButtonText: value }); }
                        }),
                        el(TextControl, {
                            label: __('URL Botão Principal', 'acesso-uporto'),
                            value: attributes.primaryButtonUrl || '',
                            onChange: function (value) { setAttributes({ primaryButtonUrl: value }); }
                        }),
                        el(TextControl, {
                            label: __('Texto Botão Secundário', 'acesso-uporto'),
                            value: attributes.secondaryButtonText || '',
                            onChange: function (value) { setAttributes({ secondaryButtonText: value }); }
                        }),
                        el(TextControl, {
                            label: __('URL Botão Secundário', 'acesso-uporto'),
                            value: attributes.secondaryButtonUrl || '',
                            onChange: function (value) { setAttributes({ secondaryButtonUrl: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Estilo', 'acesso-uporto'), initialOpen: false },
                        el(SelectControl, {
                            label: __('Estilo', 'acesso-uporto'),
                            value: attributes.style,
                            options: styleOptions,
                            onChange: function (value) { setAttributes({ style: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Fundo de pixels', 'acesso-uporto'),
                            help: __('Aplica uma textura de pixels (usa o estilo imagem).', 'acesso-uporto'),
                            value: attributes.pixelBackground,
                            options: [
                                { label: __('Nenhum', 'acesso-uporto'), value: '' },
                                { label: 'Gold', value: 'gold' },
                                { label: 'Navy', value: 'navy' },
                                { label: 'Coral', value: 'coral' },
                                { label: 'Purple', value: 'purple' },
                                { label: 'Pink', value: 'pink' },
                                { label: 'Cyan', value: 'cyan' },
                                { label: 'Red', value: 'red' },
                                { label: 'Yellow', value: 'yellow' }
                            ],
                            onChange: function (value) { setAttributes({ pixelBackground: value }); }
                        }),
                        attributes.style === 'image' && el(
                            MediaUploadCheck,
                            null,
                            el(MediaUpload, {
                                onSelect: onSelectImage,
                                allowedTypes: ['image'],
                                value: attributes.backgroundImageId,
                                render: function (obj) {
                                    return el(
                                        'div',
                                        { style: { marginTop: '10px' } },
                                        attributes.backgroundImage
                                            ? el(
                                                'div',
                                                null,
                                                el('img', {
                                                    src: attributes.backgroundImage,
                                                    style: { maxWidth: '100%', marginBottom: '8px', borderRadius: '4px' }
                                                }),
                                                el(Button, {
                                                    onClick: obj.open,
                                                    variant: 'secondary',
                                                    style: { marginRight: '8px' }
                                                }, __('Alterar', 'acesso-uporto')),
                                                el(Button, {
                                                    onClick: onRemoveImage,
                                                    variant: 'link',
                                                    isDestructive: true
                                                }, __('Remover', 'acesso-uporto'))
                                            )
                                            : el(Button, {
                                                onClick: obj.open,
                                                variant: 'secondary'
                                            }, __('Selecionar Imagem de Fundo', 'acesso-uporto'))
                                    );
                                }
                            })
                        ),
                        attributes.style === 'image' && attributes.backgroundImage && el(SelectControl, {
                            label: __('Tamanho da imagem', 'acesso-uporto'),
                            value: attributes.backgroundSize,
                            options: [
                                { label: __('Cobrir (cover)', 'acesso-uporto'), value: 'cover' },
                                { label: __('Conter (contain)', 'acesso-uporto'), value: 'contain' },
                                { label: __('Automático', 'acesso-uporto'), value: 'auto' },
                                { label: '100%', value: '100%' }
                            ],
                            onChange: function (value) { setAttributes({ backgroundSize: value }); }
                        }),
                        attributes.style === 'image' && attributes.backgroundImage && el(SelectControl, {
                            label: __('Posição', 'acesso-uporto'),
                            value: attributes.backgroundPosition,
                            options: [
                                { label: __('Centro', 'acesso-uporto'), value: 'center center' },
                                { label: __('Topo', 'acesso-uporto'), value: 'center top' },
                                { label: __('Fundo', 'acesso-uporto'), value: 'center bottom' },
                                { label: __('Esquerda', 'acesso-uporto'), value: 'left center' },
                                { label: __('Direita', 'acesso-uporto'), value: 'right center' },
                                { label: __('Topo esquerda', 'acesso-uporto'), value: 'left top' },
                                { label: __('Topo direita', 'acesso-uporto'), value: 'right top' },
                                { label: __('Fundo esquerda', 'acesso-uporto'), value: 'left bottom' },
                                { label: __('Fundo direita', 'acesso-uporto'), value: 'right bottom' }
                            ],
                            onChange: function (value) { setAttributes({ backgroundPosition: value }); }
                        }),
                        attributes.style === 'image' && attributes.backgroundImage && el(SelectControl, {
                            label: __('Repetição', 'acesso-uporto'),
                            value: attributes.backgroundRepeat,
                            options: [
                                { label: __('Não repetir', 'acesso-uporto'), value: 'no-repeat' },
                                { label: __('Repetir (ambas)', 'acesso-uporto'), value: 'repeat' },
                                { label: __('Repetir horizontal', 'acesso-uporto'), value: 'repeat-x' },
                                { label: __('Repetir vertical', 'acesso-uporto'), value: 'repeat-y' }
                            ],
                            onChange: function (value) { setAttributes({ backgroundRepeat: value }); }
                        }),
                        attributes.style === 'image' && attributes.backgroundImage && el(SelectControl, {
                            label: __('Fixação', 'acesso-uporto'),
                            value: attributes.backgroundAttachment,
                            options: [
                                { label: __('Normal (desliza)', 'acesso-uporto'), value: 'scroll' },
                                { label: __('Fixa (parallax)', 'acesso-uporto'), value: 'fixed' }
                            ],
                            onChange: function (value) { setAttributes({ backgroundAttachment: value }); }
                        }),
                        attributes.style === 'image' && el(RangeControl, {
                            label: __('Opacidade do Overlay (%)', 'acesso-uporto'),
                            value: attributes.overlayOpacity,
                            onChange: function (value) { setAttributes({ overlayOpacity: value }); },
                            min: 0,
                            max: 100
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'cta-preview',
                            style: {
                                background: attributes.pixelBackground
                                    ? 'url(/wp-content/themes/acesso-uporto-2026/assets/images/pixel-bg/pixel-' + attributes.pixelBackground + '.svg?v=2) center/cover'
                                    : (attributes.style === 'image' && attributes.backgroundImage
                                        ? 'url(' + attributes.backgroundImage + ') ' + attributes.backgroundPosition + '/' + attributes.backgroundSize + ' ' + attributes.backgroundRepeat
                                        : currentStyle.bg),
                                color: currentStyle.text,
                                padding: '60px 40px',
                                borderRadius: '12px',
                                textAlign: 'center',
                                position: 'relative',
                                overflow: 'hidden'
                            }
                        },
                        attributes.style === 'image' && attributes.backgroundImage && el('div', {
                            style: {
                                position: 'absolute',
                                top: 0,
                                left: 0,
                                right: 0,
                                bottom: 0,
                                background: 'linear-gradient(135deg, rgba(87,45,223,' + (attributes.overlayOpacity / 100) + '), rgba(218,36,137,' + (attributes.overlayOpacity / 100) + '))'
                            }
                        }),
                        el('div', { style: { position: 'relative', zIndex: 1 } },
                            el('h2', {
                                style: { fontSize: '2rem', marginBottom: '15px', fontWeight: 700 }
                            }, attributes.title || __('Título', 'acesso-uporto')),
                            el('p', {
                                style: { fontSize: '1.125rem', opacity: 0.9, maxWidth: '600px', margin: '0 auto 25px' }
                            }, attributes.text || __('Texto da chamada para ação.', 'acesso-uporto')),
                            el('div', {
                                style: { display: 'flex', gap: '12px', justifyContent: 'center', flexWrap: 'wrap' }
                            },
                                attributes.primaryButtonText && el('span', {
                                    style: {
                                        background: attributes.style === 'light' ? 'linear-gradient(135deg, #572ddf, #da2489)' : '#fff',
                                        color: attributes.style === 'light' ? '#fff' : '#572ddf',
                                        padding: '14px 28px',
                                        borderRadius: '50px',
                                        fontWeight: 600,
                                        fontSize: '0.9375rem'
                                    }
                                }, attributes.primaryButtonText),
                                attributes.secondaryButtonText && el('span', {
                                    style: {
                                        border: '2px solid ' + (attributes.style === 'light' ? '#060221' : '#fff'),
                                        color: attributes.style === 'light' ? '#060221' : '#fff',
                                        padding: '12px 26px',
                                        borderRadius: '50px',
                                        fontWeight: 600,
                                        fontSize: '0.9375rem'
                                    }
                                }, attributes.secondaryButtonText)
                            )
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
