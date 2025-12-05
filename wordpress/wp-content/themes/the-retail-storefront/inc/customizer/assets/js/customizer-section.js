( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['plugin-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );


function the_retail_storefront_sfrontpagesectionsscroll( section_id ){
    var scroll_section_id = "slider-section";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {
		
		case 'accordion-section-team_setting':
        scroll_section_id = "team-section";
        break;
		
		case 'accordion-section-features_setting':
        scroll_section_id = "features-section";
        break;
		
		case 'accordion-section-blog_setting':
        scroll_section_id = "blog-section";
        break;

        case 'accordion-section-slider_setting':
        scroll_section_id = "slider-section";
        break;

    }

    if( $contents.find('#'+scroll_section_id).length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + scroll_section_id ).offset().top
        }, 1000);
    }
}

