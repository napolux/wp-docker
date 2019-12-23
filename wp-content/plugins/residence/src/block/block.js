import './editor.scss';
import './style.scss';



const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { PlainText } = wp.blockEditor;

const { SelectControl } = wp.components;
const withSelect = wp.data.withSelect;

let postId = 'imnothing'

registerBlockType( 'cgb/block-residence', {
	title: __( 'Single residence block' ),
	icon: 'shield',
	category: 'common',
	supports: {
		multiple: false,
	},
	attributes: {
		post_Id: {
			type: 'string',
		},
		residence: {
			type: 'string',
		},
		floor: {
			type: 'string',
		},
		bedrooms: {
			type: 'string',
		  },
		 bathrooms: {
			type: 'string',
		  },
		 sizeSF: {
			type: 'string',
		  },
		  sizeM: {
			type: 'string',
		  },
		  extArea: {
			type: 'string',
		  },
		  comCharges: {
			type: 'string',
		  },
		  exposure: {
			type: 'string',
		  },
		  price: {
			type: 'string',
		  },
	  },

	  edit: withSelect( ( select ) => {

		return {
			post_id: select( 'core/editor' ).getCurrentPostId(),
			post_type: select( 'core/editor' ).getCurrentPostType()

		};
	} )( props => {
		  const { attributes, setAttributes } = props
		  wp.apiFetch( { path: '/wp/v2/apartments/' + props.post_id  } )
		  .then( function( post ) {
			 postId =  post.id ;
			 console.log(postId)
			 setAttributes( { post_Id: postId } )

		} );
		return (
			<div className="container">
            <h2>Apartment details</h2>
			<PlainText
	                onChange={ content => setAttributes( { residence: content } ) }
					value={ attributes.residence }
					placeholder="Residence"
					className="heading"
				/>
			<PlainText
	                onChange={ content => setAttributes( { floor: content } ) }
					value={ attributes.floor }
					placeholder="Floor"
					className="heading"
				/>

          <PlainText
                	onChange={ content => setAttributes( { bedrooms: content } ) }
					value={ attributes.bedrooms }
					placeholder="Bedroomss"
					className="heading"
				/>

          <PlainText
	                onChange={ content => setAttributes( { bathrooms: content } ) }
					value={ attributes.bathrooms }
					placeholder="Bathrooms"
					className="heading"
				/>

           <PlainText
	                onChange={ content => setAttributes( { sizeSF: content } ) }
					value={ attributes.sizeSF }
					placeholder="Size (Square feet)"
					className="heading"
				/>
              {/* <label>Size (Meters):</label> */}
              <PlainText
	                onChange={ content => setAttributes( { sizeM: content } ) }
					value={ attributes.sizeM }
					placeholder="Size (Meters)"
					className="heading"
				/>

               <PlainText
	                onChange={ content => setAttributes( { extArea: content } ) }
					value={ attributes.extArea }
					placeholder="ext Area"
					className="heading"
				/>
				<PlainText
	                onChange={ content => setAttributes( { comCharges: content } ) }
					value={ attributes.comCharges }
					placeholder="Com charges"
					className="heading"
				/>

              <SelectControl
		value={ attributes.exposure }
        onChange={ content => setAttributes( { exposure: content } ) }
        options={ [
            { value: null, label: 'Select exposure', disabled: true },
            { value: 'NE', label: 'North East' },
            { value: 'SE', label: 'South East' },
            { value: 'SW', label: 'South West' },
        ] }
    />

                 <PlainText
	                onChange={ content => setAttributes( { price: content } ) }
					value={ attributes.price }
					placeholder="Price"
					className="heading"
				/>


				</div>
		);
	}),

	save: ( { attributes } ) => {
		return null;
	},
} );
