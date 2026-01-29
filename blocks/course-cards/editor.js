( function( wp ) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var Fragment = wp.element.Fragment;
    var __ = wp.i18n.__;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var SelectControl = wp.components.SelectControl;
    var RangeControl = wp.components.RangeControl;
    var ToggleControl = wp.components.ToggleControl;
    var Placeholder = wp.components.Placeholder;
    var useSelect = wp.data.useSelect;

    registerBlockType( 'acesso/course-cards', {
        edit: function( props ) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var faculties = useSelect( function( select ) {
                return select( 'core' ).getEntityRecords( 'taxonomy', 'faculdades', { per_page: -1 } ) || [];
            }, [] );

            var facultyOptions = [ { label: __( 'Todas as Faculdades', 'acesso-uporto' ), value: 0 } ];
            faculties.forEach( function( faculty ) {
                facultyOptions.push( { label: faculty.name, value: faculty.id } );
            } );

            var blockProps = useBlockProps();

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __( 'Conteúdo', 'acesso-uporto' ), initialOpen: true },
                        el( TextControl, {
                            label: __( 'Título da Secção', 'acesso-uporto' ),
                            value: attributes.sectionTitle || '',
                            onChange: function( value ) { setAttributes( { sectionTitle: value } ); }
                        } ),
                        el( TextControl, {
                            label: __( 'Subtítulo', 'acesso-uporto' ),
                            value: attributes.sectionSubtitle || '',
                            onChange: function( value ) { setAttributes( { sectionSubtitle: value } ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: __( 'Layout', 'acesso-uporto' ), initialOpen: true },
                        el( SelectControl, {
                            label: __( 'Disposição', 'acesso-uporto' ),
                            value: attributes.layout,
                            options: [
                                { label: __( '2 Colunas', 'acesso-uporto' ), value: 'grid-2' },
                                { label: __( '3 Colunas', 'acesso-uporto' ), value: 'grid-3' },
                                { label: __( '4 Colunas', 'acesso-uporto' ), value: 'grid-4' },
                                { label: __( 'Carrossel', 'acesso-uporto' ), value: 'carousel' }
                            ],
                            onChange: function( value ) { setAttributes( { layout: value } ); }
                        } ),
                        el( SelectControl, {
                            label: __( 'Estilo dos Cards', 'acesso-uporto' ),
                            value: attributes.cardStyle,
                            options: [
                                { label: __( 'Padrão (Sombra)', 'acesso-uporto' ), value: 'default' },
                                { label: __( 'Gradiente Suave', 'acesso-uporto' ), value: 'gradient' },
                                { label: __( 'Com Borda', 'acesso-uporto' ), value: 'bordered' },
                                { label: __( 'Minimalista', 'acesso-uporto' ), value: 'minimal' },
                                { label: __( 'Fundo Escuro', 'acesso-uporto' ), value: 'dark' }
                            ],
                            onChange: function( value ) { setAttributes( { cardStyle: value } ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: __( 'Filtros', 'acesso-uporto' ), initialOpen: false },
                        el( SelectControl, {
                            label: __( 'Tipo de Cursos', 'acesso-uporto' ),
                            value: attributes.filterType,
                            options: [
                                { label: __( 'Todos os Cursos', 'acesso-uporto' ), value: 'all' },
                                { label: __( 'Apenas Destaques', 'acesso-uporto' ), value: 'destaque' },
                                { label: __( 'Apenas Novos', 'acesso-uporto' ), value: 'novo' }
                            ],
                            onChange: function( value ) { setAttributes( { filterType: value } ); }
                        } ),
                        el( SelectControl, {
                            label: __( 'Faculdade', 'acesso-uporto' ),
                            value: attributes.filterFaculty,
                            options: facultyOptions,
                            onChange: function( value ) { setAttributes( { filterFaculty: parseInt( value ) } ); }
                        } ),
                        el( RangeControl, {
                            label: __( 'Número de Cursos', 'acesso-uporto' ),
                            value: attributes.limit,
                            onChange: function( value ) { setAttributes( { limit: value } ); },
                            min: 1,
                            max: 50
                        } ),
                        el( ToggleControl, {
                            label: __( 'Mostrar Filtros de Faculdade', 'acesso-uporto' ),
                            checked: attributes.showFilters,
                            onChange: function( value ) { setAttributes( { showFilters: value } ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: __( 'Botão CTA', 'acesso-uporto' ), initialOpen: false },
                        el( ToggleControl, {
                            label: __( 'Mostrar Botão Ver Todos', 'acesso-uporto' ),
                            checked: attributes.showCta,
                            onChange: function( value ) { setAttributes( { showCta: value } ); }
                        } ),
                        attributes.showCta && el( TextControl, {
                            label: __( 'Texto do Botão', 'acesso-uporto' ),
                            value: attributes.ctaText || '',
                            onChange: function( value ) { setAttributes( { ctaText: value } ); }
                        } )
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        Placeholder,
                        {
                            icon: 'grid-view',
                            label: __( 'Course Cards', 'acesso-uporto' )
                        },
                        el( 'p', null,
                            ( attributes.sectionTitle || __( 'Cursos em formato de cards', 'acesso-uporto' ) )
                        ),
                        el( 'small', null,
                            __( 'Layout:', 'acesso-uporto' ) + ' ' + attributes.layout + ' | ' +
                            __( 'Limite:', 'acesso-uporto' ) + ' ' + attributes.limit + ' ' + __( 'cursos', 'acesso-uporto' )
                        )
                    )
                )
            );
        },

        save: function() {
            return null;
        }
    } );
} )( window.wp );
