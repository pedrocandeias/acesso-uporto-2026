(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var MediaUpload = wp.blockEditor.MediaUpload;
    var MediaUploadCheck = wp.blockEditor.MediaUploadCheck;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var SelectControl = wp.components.SelectControl;
    var ToggleControl = wp.components.ToggleControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/video-section', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'video-section-editor-preview'
            });

            var onSelectImage = function (media) {
                setAttributes({
                    posterImage: media.url,
                    posterImageId: media.id
                });
            };

            var onRemoveImage = function () {
                setAttributes({
                    posterImage: '',
                    posterImageId: 0
                });
            };

            // Extract video ID for preview
            var getVideoThumbnail = function (url) {
                if (!url) return '';

                // YouTube
                var ytMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
                if (ytMatch) {
                    return 'https://img.youtube.com/vi/' + ytMatch[1] + '/maxresdefault.jpg';
                }

                // Vimeo - would need API call, return empty
                return '';
            };

            var thumbnailUrl = attributes.posterImage || getVideoThumbnail(attributes.videoUrl);

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
                            label: __('Título da Secção', 'acesso-uporto'),
                            value: attributes.sectionTitle || '',
                            onChange: function (value) { setAttributes({ sectionTitle: value }); }
                        }),
                        el(TextControl, {
                            label: __('Subtítulo', 'acesso-uporto'),
                            value: attributes.sectionSubtitle || '',
                            onChange: function (value) { setAttributes({ sectionSubtitle: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Vídeo', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('URL do Vídeo', 'acesso-uporto'),
                            value: attributes.videoUrl || '',
                            onChange: function (value) { setAttributes({ videoUrl: value }); },
                            help: __('YouTube ou Vimeo URL', 'acesso-uporto')
                        }),
                        el('div', { style: { marginTop: '15px' } },
                            el('label', { style: { display: 'block', marginBottom: '8px', fontWeight: 500 } },
                                __('Imagem de Capa', 'acesso-uporto')
                            ),
                            el(
                                MediaUploadCheck,
                                null,
                                el(MediaUpload, {
                                    onSelect: onSelectImage,
                                    allowedTypes: ['image'],
                                    value: attributes.posterImageId,
                                    render: function (obj) {
                                        return el(
                                            'div',
                                            null,
                                            attributes.posterImage
                                                ? el(
                                                    'div',
                                                    null,
                                                    el('img', {
                                                        src: attributes.posterImage,
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
                                                }, __('Selecionar Imagem de Capa', 'acesso-uporto'))
                                        );
                                    }
                                })
                            ),
                            el('p', { style: { fontSize: '12px', color: '#757575', marginTop: '8px' } },
                                __('Se não definida, será usada a miniatura do vídeo (apenas YouTube).', 'acesso-uporto')
                            )
                        )
                    ),
                    el(
                        PanelBody,
                        { title: __('Configurações', 'acesso-uporto'), initialOpen: false },
                        el(SelectControl, {
                            label: __('Proporção', 'acesso-uporto'),
                            value: attributes.aspectRatio,
                            options: [
                                { label: '16:9', value: '16-9' },
                                { label: '4:3', value: '4-3' },
                                { label: '21:9', value: '21-9' },
                                { label: '1:1', value: '1-1' }
                            ],
                            onChange: function (value) { setAttributes({ aspectRatio: value }); }
                        }),
                        el(SelectControl, {
                            label: __('Estilo', 'acesso-uporto'),
                            value: attributes.style,
                            options: [
                                { label: __('Padrão', 'acesso-uporto'), value: 'default' },
                                { label: __('Com Sombra', 'acesso-uporto'), value: 'shadow' },
                                { label: __('Arredondado', 'acesso-uporto'), value: 'rounded' },
                                { label: __('Full Width', 'acesso-uporto'), value: 'fullwidth' }
                            ],
                            onChange: function (value) { setAttributes({ style: value }); }
                        }),
                        el(ToggleControl, {
                            label: __('Autoplay (sem som)', 'acesso-uporto'),
                            checked: attributes.autoplay,
                            onChange: function (value) { setAttributes({ autoplay: value }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'video-section-preview',
                            style: {
                                padding: '30px',
                                background: '#f9f9f9',
                                borderRadius: '8px'
                            }
                        },
                        (attributes.sectionTitle || attributes.sectionSubtitle) && el('div', {
                            style: { textAlign: 'center', marginBottom: '20px' }
                        },
                            attributes.sectionTitle && el('h3', { style: { margin: '0 0 8px' } }, attributes.sectionTitle),
                            attributes.sectionSubtitle && el('p', { style: { color: '#666', margin: 0 } }, attributes.sectionSubtitle)
                        ),
                        el(
                            'div',
                            {
                                style: {
                                    position: 'relative',
                                    paddingBottom: attributes.aspectRatio === '16-9' ? '56.25%' : attributes.aspectRatio === '4-3' ? '75%' : attributes.aspectRatio === '21-9' ? '42.86%' : '100%',
                                    background: thumbnailUrl ? 'url(' + thumbnailUrl + ') center/cover' : 'linear-gradient(135deg, #572ddf 0%, #da2489 100%)',
                                    borderRadius: '12px',
                                    overflow: 'hidden'
                                }
                            },
                            el(
                                'div',
                                {
                                    style: {
                                        position: 'absolute',
                                        top: '50%',
                                        left: '50%',
                                        transform: 'translate(-50%, -50%)',
                                        width: '80px',
                                        height: '80px',
                                        background: 'rgba(255,255,255,0.9)',
                                        borderRadius: '50%',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        boxShadow: '0 4px 20px rgba(0,0,0,0.2)'
                                    }
                                },
                                el('span', {
                                    className: 'dashicons dashicons-controls-play',
                                    style: { fontSize: '32px', color: '#572ddf', marginLeft: '4px' }
                                })
                            ),
                            !attributes.videoUrl && el(
                                'div',
                                {
                                    style: {
                                        position: 'absolute',
                                        bottom: '20px',
                                        left: '50%',
                                        transform: 'translateX(-50%)',
                                        background: 'rgba(0,0,0,0.7)',
                                        color: '#fff',
                                        padding: '8px 16px',
                                        borderRadius: '4px',
                                        fontSize: '14px'
                                    }
                                },
                                __('Adiciona um URL de vídeo nas configurações', 'acesso-uporto')
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
