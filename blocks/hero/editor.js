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
    var RangeControl = wp.components.RangeControl;
    var SelectControl = wp.components.SelectControl;
    var Button = wp.components.Button;
    var ColorPicker = wp.components.ColorPicker;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/hero', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'hero-editor-preview'
            });

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

            var rotatingWordsText = (attributes.rotatingWords || []).join(', ');

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Imagem de Fundo', 'acesso-uporto'), initialOpen: true },
                        el(
                            MediaUploadCheck,
                            null,
                            el(MediaUpload, {
                                onSelect: onSelectImage,
                                allowedTypes: ['image'],
                                value: attributes.backgroundImageId,
                                render: function (obj) {
                                    return el(
                                        'div',
                                        { className: 'editor-media-upload' },
                                        attributes.backgroundImage
                                            ? el(
                                                'div',
                                                null,
                                                el('img', {
                                                    src: attributes.backgroundImage,
                                                    style: { maxWidth: '100%', marginBottom: '10px' }
                                                }),
                                                el(Button, {
                                                    onClick: obj.open,
                                                    variant: 'secondary',
                                                    style: { marginRight: '8px' }
                                                }, __('Alterar Imagem', 'acesso-uporto')),
                                                el(Button, {
                                                    onClick: onRemoveImage,
                                                    variant: 'link',
                                                    isDestructive: true
                                                }, __('Remover', 'acesso-uporto'))
                                            )
                                            : el(Button, {
                                                onClick: obj.open,
                                                variant: 'secondary'
                                            }, __('Selecionar Imagem', 'acesso-uporto'))
                                    );
                                }
                            })
                        ),
                        attributes.backgroundImage && el(SelectControl, {
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
                        attributes.backgroundImage && el(SelectControl, {
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
                        attributes.backgroundImage && el(SelectControl, {
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
                        attributes.backgroundImage && el(SelectControl, {
                            label: __('Fixação', 'acesso-uporto'),
                            value: attributes.backgroundAttachment,
                            options: [
                                { label: __('Normal (desliza)', 'acesso-uporto'), value: 'scroll' },
                                { label: __('Fixa (parallax)', 'acesso-uporto'), value: 'fixed' }
                            ],
                            onChange: function (value) { setAttributes({ backgroundAttachment: value }); }
                        }),
                        el(RangeControl, {
                            label: __('Opacidade do Overlay (%)', 'acesso-uporto'),
                            value: attributes.overlayOpacity,
                            onChange: function (value) { setAttributes({ overlayOpacity: value }); },
                            min: 0,
                            max: 100
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Texto Rotativo', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('Texto Antes', 'acesso-uporto'),
                            value: attributes.staticTextBefore || '',
                            onChange: function (value) { setAttributes({ staticTextBefore: value }); },
                            help: __('Ex: "ISTO É"', 'acesso-uporto')
                        }),
                        el(TextareaControl, {
                            label: __('Palavras Rotativas', 'acesso-uporto'),
                            value: rotatingWordsText,
                            onChange: function (value) {
                                var words = value.split(',').map(function (w) { return w.trim(); }).filter(function (w) { return w; });
                                setAttributes({ rotatingWords: words });
                            },
                            help: __('Separar palavras por vírgula', 'acesso-uporto')
                        }),
                        el(TextControl, {
                            label: __('Título Principal', 'acesso-uporto'),
                            value: attributes.mainTitle || '',
                            onChange: function (value) { setAttributes({ mainTitle: value }); }
                        }),
                        el(TextControl, {
                            label: __('Tagline', 'acesso-uporto'),
                            value: attributes.tagline || '',
                            onChange: function (value) { setAttributes({ tagline: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Botões', 'acesso-uporto'), initialOpen: false },
                        el(TextControl, {
                            label: __('Texto Botão Primário', 'acesso-uporto'),
                            value: attributes.primaryButtonText || '',
                            onChange: function (value) { setAttributes({ primaryButtonText: value }); }
                        }),
                        el(TextControl, {
                            label: __('URL Botão Primário', 'acesso-uporto'),
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
                        { title: __('Cores do Gradiente', 'acesso-uporto'), initialOpen: false },
                        el('p', null, __('Cor Inicial', 'acesso-uporto')),
                        el(ColorPicker, {
                            color: attributes.gradientStart,
                            onChangeComplete: function (value) { setAttributes({ gradientStart: value.hex }); },
                            disableAlpha: true
                        }),
                        el('p', { style: { marginTop: '20px' } }, __('Cor Final', 'acesso-uporto')),
                        el(ColorPicker, {
                            color: attributes.gradientEnd,
                            onChangeComplete: function (value) { setAttributes({ gradientEnd: value.hex }); },
                            disableAlpha: true
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Layout', 'acesso-uporto'), initialOpen: false },
                        el(TextControl, {
                            label: __('Altura Mínima', 'acesso-uporto'),
                            value: attributes.minHeight || '',
                            onChange: function (value) { setAttributes({ minHeight: value }); },
                            help: __('Ex: 100vh, 600px, 80vh', 'acesso-uporto')
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'hero-preview',
                            style: {
                                backgroundImage: attributes.backgroundImage ? 'url(' + attributes.backgroundImage + ')' : 'linear-gradient(135deg, ' + attributes.gradientStart + ', ' + attributes.gradientEnd + ')',
                                backgroundSize: attributes.backgroundImage ? attributes.backgroundSize : 'cover',
                                backgroundPosition: attributes.backgroundImage ? attributes.backgroundPosition : 'center',
                                backgroundRepeat: attributes.backgroundImage ? attributes.backgroundRepeat : 'no-repeat',
                                minHeight: '300px',
                                padding: '40px',
                                position: 'relative',
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                textAlign: 'center',
                                color: '#fff',
                                borderRadius: '8px',
                                overflow: 'hidden'
                            }
                        },
                        el('div', {
                            style: {
                                position: 'absolute',
                                top: 0,
                                left: 0,
                                right: 0,
                                bottom: 0,
                                background: 'linear-gradient(135deg, ' + attributes.gradientStart + ', ' + attributes.gradientEnd + ')',
                                opacity: attributes.overlayOpacity / 100
                            }
                        }),
                        el(
                            'div',
                            { style: { position: 'relative', zIndex: 1 } },
                            el('p', { style: { fontSize: '14px', margin: '0 0 5px', textTransform: 'uppercase', letterSpacing: '2px' } },
                                attributes.staticTextBefore + ' ' + (attributes.rotatingWords[0] || '')
                            ),
                            el('h1', { style: { fontSize: '48px', fontWeight: 900, margin: '10px 0' } },
                                attributes.mainTitle
                            ),
                            el('p', { style: { fontSize: '18px', margin: '10px 0 20px' } },
                                attributes.tagline
                            ),
                            el('div', { style: { display: 'flex', gap: '10px', justifyContent: 'center' } },
                                attributes.primaryButtonText && el('span', {
                                    style: {
                                        background: '#fff',
                                        color: attributes.gradientStart,
                                        padding: '12px 24px',
                                        borderRadius: '50px',
                                        fontWeight: 600
                                    }
                                }, attributes.primaryButtonText),
                                attributes.secondaryButtonText && el('span', {
                                    style: {
                                        border: '2px solid #fff',
                                        padding: '12px 24px',
                                        borderRadius: '50px'
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
