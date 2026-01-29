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
    var ToggleControl = wp.components.ToggleControl;
    var RangeControl = wp.components.RangeControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/testimonials', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'testimonials-editor-preview'
            });

            var updateTestimonial = function (index, field, value) {
                var newTestimonials = attributes.testimonials.slice();
                newTestimonials[index] = Object.assign({}, newTestimonials[index]);
                newTestimonials[index][field] = value;
                setAttributes({ testimonials: newTestimonials });
            };

            var addTestimonial = function () {
                var newTestimonials = attributes.testimonials.slice();
                newTestimonials.push({
                    name: '',
                    course: '',
                    quote: '',
                    image: '',
                    imageId: 0
                });
                setAttributes({ testimonials: newTestimonials });
            };

            var removeTestimonial = function (index) {
                var newTestimonials = attributes.testimonials.slice();
                newTestimonials.splice(index, 1);
                setAttributes({ testimonials: newTestimonials });
            };

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Configurações da Secção', 'acesso-uporto'), initialOpen: true },
                        el(TextControl, {
                            label: __('Título', 'acesso-uporto'),
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
                            value: attributes.style,
                            options: [
                                { label: __('Cards', 'acesso-uporto'), value: 'cards' },
                                { label: __('Carousel', 'acesso-uporto'), value: 'carousel' },
                                { label: __('Destaque', 'acesso-uporto'), value: 'featured' }
                            ],
                            onChange: function (value) { setAttributes({ style: value }); }
                        }),
                        el(ToggleControl, {
                            label: __('Autoplay', 'acesso-uporto'),
                            checked: attributes.autoplay,
                            onChange: function (value) { setAttributes({ autoplay: value }); }
                        }),
                        attributes.autoplay && el(RangeControl, {
                            label: __('Velocidade (ms)', 'acesso-uporto'),
                            value: attributes.autoplaySpeed,
                            onChange: function (value) { setAttributes({ autoplaySpeed: value }); },
                            min: 2000,
                            max: 10000,
                            step: 500
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Testemunhos', 'acesso-uporto'), initialOpen: true },
                        attributes.testimonials.map(function (testimonial, index) {
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
                                    __('Testemunho', 'acesso-uporto') + ' ' + (index + 1)
                                ),
                                el(
                                    MediaUploadCheck,
                                    null,
                                    el(MediaUpload, {
                                        onSelect: function (media) {
                                            updateTestimonial(index, 'image', media.url);
                                            updateTestimonial(index, 'imageId', media.id);
                                        },
                                        allowedTypes: ['image'],
                                        value: testimonial.imageId,
                                        render: function (obj) {
                                            return el(
                                                'div',
                                                { style: { marginBottom: '10px' } },
                                                testimonial.image
                                                    ? el(
                                                        'div',
                                                        null,
                                                        el('img', {
                                                            src: testimonial.image,
                                                            style: { width: '60px', height: '60px', borderRadius: '50%', objectFit: 'cover', marginBottom: '8px' }
                                                        }),
                                                        el(Button, {
                                                            onClick: obj.open,
                                                            variant: 'link',
                                                            style: { display: 'block' }
                                                        }, __('Alterar Foto', 'acesso-uporto'))
                                                    )
                                                    : el(Button, {
                                                        onClick: obj.open,
                                                        variant: 'secondary'
                                                    }, __('Adicionar Foto', 'acesso-uporto'))
                                            );
                                        }
                                    })
                                ),
                                el(TextControl, {
                                    label: __('Nome', 'acesso-uporto'),
                                    value: testimonial.name || '',
                                    onChange: function (value) { updateTestimonial(index, 'name', value); }
                                }),
                                el(TextControl, {
                                    label: __('Curso', 'acesso-uporto'),
                                    value: testimonial.course || '',
                                    onChange: function (value) { updateTestimonial(index, 'course', value); }
                                }),
                                el(TextareaControl, {
                                    label: __('Citação', 'acesso-uporto'),
                                    value: testimonial.quote || '',
                                    onChange: function (value) { updateTestimonial(index, 'quote', value); }
                                }),
                                attributes.testimonials.length > 1 && el(Button, {
                                    variant: 'link',
                                    isDestructive: true,
                                    onClick: function () { removeTestimonial(index); }
                                }, __('Remover', 'acesso-uporto'))
                            );
                        }),
                        el(Button, {
                            variant: 'secondary',
                            onClick: addTestimonial,
                            style: { width: '100%', justifyContent: 'center' }
                        }, __('+ Adicionar Testemunho', 'acesso-uporto'))
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'testimonials-preview',
                            style: {
                                padding: '40px',
                                background: 'linear-gradient(135deg, rgba(87,45,223,0.05) 0%, rgba(218,36,137,0.05) 100%)',
                                borderRadius: '8px',
                                textAlign: 'center'
                            }
                        },
                        el('span', { className: 'dashicons dashicons-format-quote', style: { fontSize: '48px', color: '#572ddf', marginBottom: '10px' } }),
                        el('h3', { style: { margin: '0 0 8px' } }, attributes.sectionTitle || __('Testemunhos', 'acesso-uporto')),
                        el('p', { style: { color: '#666', margin: '0 0 15px' } }, attributes.sectionSubtitle),
                        el('div', {
                            style: {
                                display: 'flex',
                                justifyContent: 'center',
                                gap: '10px',
                                flexWrap: 'wrap'
                            }
                        },
                            attributes.testimonials.map(function (t, i) {
                                return el('div', {
                                    key: i,
                                    style: {
                                        width: '40px',
                                        height: '40px',
                                        borderRadius: '50%',
                                        background: t.image ? 'url(' + t.image + ') center/cover' : '#ddd',
                                        border: '2px solid #572ddf'
                                    }
                                });
                            })
                        ),
                        el('small', { style: { color: '#888', display: 'block', marginTop: '10px' } },
                            attributes.testimonials.length + ' ' + __('testemunhos', 'acesso-uporto') + ' | ' +
                            __('Estilo:', 'acesso-uporto') + ' ' + attributes.style
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
