( function( api ) {

	// Extends our custom "the-retail-storefront" section.
	api.sectionConstructor['the-retail-storefront'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );