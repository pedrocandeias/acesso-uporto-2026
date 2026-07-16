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
    var RangeControl = wp.components.RangeControl;
    var ToggleControl = wp.components.ToggleControl;
    var Button = wp.components.Button;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;

    registerBlockType('acesso/faculty-cards', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'faculty-cards-editor-preview'
            });

            var updateFaculty = function (index, field, value) {
                var newFaculties = attributes.faculties.slice();
                newFaculties[index] = Object.assign({}, newFaculties[index]);
                newFaculties[index][field] = value;
                setAttributes({ faculties: newFaculties });
            };

            var addFaculty = function () {
                var newFaculties = attributes.faculties.slice();
                newFaculties.push({
                    name: '',
                    acronym: '',
                    image: '',
                    imageId: 0,
                    link: ''
                });
                setAttributes({ faculties: newFaculties });
            };

            var removeFaculty = function (index) {
                var newFaculties = attributes.faculties.slice();
                newFaculties.splice(index, 1);
                setAttributes({ faculties: newFaculties });
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
                        el(TextControl, {
                            label: __('Subtítulo', 'acesso-uporto'),
                            value: attributes.sectionSubtitle || '',
                            onChange: function (value) { setAttributes({ sectionSubtitle: value }); }
                        }),
                        el(RangeControl, {
                            label: __('Colunas', 'acesso-uporto'),
                            value: attributes.columns,
                            onChange: function (value) { setAttributes({ columns: value }); },
                            min: 2,
                            max: 6
                        }),
                        el(SelectControl, {
                            label: __('Estilo', 'acesso-uporto'),
                            value: attributes.variant,
                            options: [
                                { label: __('Padrão', 'acesso-uporto'), value: 'default' },
                                { label: __('Overlay', 'acesso-uporto'), value: 'overlay' },
                                { label: __('Cards', 'acesso-uporto'), value: 'cards' },
                                { label: __('Minimalista', 'acesso-uporto'), value: 'minimal' }
                            ],
                            onChange: function (value) { setAttributes({ variant: value }); }
                        }),
                        el(ToggleControl, {
                            label: __('Mostrar Sigla', 'acesso-uporto'),
                            checked: attributes.showAcronym,
                            onChange: function (value) { setAttributes({ showAcronym: value }); }
                        })
                    ),
                    el(
                        PanelBody,
                        { title: __('Faculdades', 'acesso-uporto'), initialOpen: true },
                        attributes.faculties.map(function (faculty, index) {
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
                                    __('Faculdade', 'acesso-uporto') + ' ' + (index + 1)
                                ),
                                el(
                                    MediaUploadCheck,
                                    null,
                                    el(MediaUpload, {
                                        onSelect: function (media) {
                                            updateFaculty(index, 'image', media.url);
                                            updateFaculty(index, 'imageId', media.id);
                                        },
                                        allowedTypes: ['image'],
                                        value: faculty.imageId,
                                        render: function (obj) {
                                            return el(
                                                'div',
                                                { style: { marginBottom: '10px' } },
                                                faculty.image
                                                    ? el(
                                                        'div',
                                                        null,
                                                        el('img', {
                                                            src: faculty.image,
                                                            style: { maxWidth: '100%', height: '80px', objectFit: 'cover', borderRadius: '4px', marginBottom: '8px' }
                                                        }),
                                                        el(Button, {
                                                            onClick: obj.open,
                                                            variant: 'link',
                                                            style: { display: 'block' }
                                                        }, __('Alterar Imagem', 'acesso-uporto'))
                                                    )
                                                    : el(Button, {
                                                        onClick: obj.open,
                                                        variant: 'secondary'
                                                    }, __('Adicionar Imagem', 'acesso-uporto'))
                                            );
                                        }
                                    })
                                ),
                                el(TextControl, {
                                    label: __('Nome', 'acesso-uporto'),
                                    value: faculty.name || '',
                                    onChange: function (value) { updateFaculty(index, 'name', value); }
                                }),
                                el(TextControl, {
                                    label: __('Sigla', 'acesso-uporto'),
                                    value: faculty.acronym || '',
                                    onChange: function (value) { updateFaculty(index, 'acronym', value); },
                                    help: __('Ex: FEUP, FMUP, FLUP', 'acesso-uporto')
                                }),
                                el(TextControl, {
                                    label: __('Link', 'acesso-uporto'),
                                    value: faculty.link || '',
                                    onChange: function (value) { updateFaculty(index, 'link', value); }
                                }),
                                attributes.faculties.length > 1 && el(Button, {
                                    variant: 'link',
                                    isDestructive: true,
                                    onClick: function () { removeFaculty(index); }
                                }, __('Remover', 'acesso-uporto'))
                            );
                        }),
                        el(Button, {
                            variant: 'secondary',
                            onClick: addFaculty,
                            style: { width: '100%', justifyContent: 'center' }
                        }, __('+ Adicionar Faculdade', 'acesso-uporto'))
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            className: 'faculty-cards-preview',
                            style: {
                                padding: '30px',
                                background: '#f9f9f9',
                                borderRadius: '8px'
                            }
                        },
                        el('div', { style: { textAlign: 'center', marginBottom: '20px' } },
                            el('span', { className: 'dashicons dashicons-building', style: { fontSize: '32px', color: '#572ddf' } }),
                            el('h3', { style: { margin: '10px 0 5px' } }, attributes.sectionTitle || __('Faculdades', 'acesso-uporto')),
                            attributes.sectionSubtitle && el('p', { style: { color: '#666', margin: 0 } }, attributes.sectionSubtitle)
                        ),
                        attributes.faculties.length > 0
                            ? el('div', {
                                style: {
                                    display: 'grid',
                                    gridTemplateColumns: 'repeat(' + Math.min(attributes.columns, 4) + ', 1fr)',
                                    gap: '15px'
                                }
                            },
                                attributes.faculties.slice(0, 8).map(function (faculty, index) {
                                    return el('div', {
                                        key: index,
                                        style: {
                                            background: faculty.image ? 'url(' + faculty.image + ') center/cover' : 'linear-gradient(135deg, #572ddf, #da2489)',
                                            height: '100px',
                                            borderRadius: '8px',
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            color: '#fff',
                                            fontWeight: 700,
                                            position: 'relative',
                                            overflow: 'hidden'
                                        }
                                    },
                                        el('div', {
                                            style: {
                                                position: 'absolute',
                                                inset: 0,
                                                background: 'rgba(0,0,0,0.4)'
                                            }
                                        }),
                                        el('span', { style: { position: 'relative', zIndex: 1 } },
                                            faculty.acronym || faculty.name || __('Faculdade', 'acesso-uporto')
                                        )
                                    );
                                })
                            )
                            : el('p', { style: { textAlign: 'center', color: '#888' } },
                                __('Adiciona faculdades nas configurações do bloco.', 'acesso-uporto')
                            ),
                        attributes.faculties.length > 8 && el('p', {
                            style: { textAlign: 'center', color: '#888', fontSize: '14px', marginTop: '10px' }
                        }, '+ ' + (attributes.faculties.length - 8) + ' ' + __('mais', 'acesso-uporto'))
                    )
                )
            );
        },

        save: function () {
            return null;
        }
    });
})(window.wp);
