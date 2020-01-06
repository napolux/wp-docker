/**
 *  BLOCK: Book Details
 *  ---
 *  Add details for a book to a post or page.
 */

//  Import CSS.
import './editor.css'

const { __ } = wp.i18n
const { registerBlockType } = wp.blocks
const { RichText } = wp.editor

const { URLInputButton, MediaUpload, PlainText, BlockControls, AlignmentToolbar } = wp.blockEditor;
const { Button, TextareaControl } = wp.components;

registerBlockType('davidyeiser-detailer/banner', {
  title: __( 'Custom Banner' ),
  icon: 'format-aside',
  category: 'common',
  keywords: [
    __( 'custom' ),
    __( 'banner' ),
  ],

  // Enable or disable support for low-level features
  supports: {
    // Turn off ability to edit HTML of block content
    html: false,
    // Turn off reusable block feature
    reusable: false,
    // Add alignwide and alignfull options
    align: false
  },

  // Set up data model for custom block
  attributes: {
    title: {
      type: 'string',
      selector: 'js-banner-title'
    },
    copy: {
      type: 'string',
      selector: 'js-banner-copy'
    },
    callToActionCopy: {
      type: 'string',
      selector: 'js-banner-cta-copy',
    },
    ctaUrl: {
			type: 'string',
      },
    imageUrl: {
        type: 'string',
      },
    imageAlt: {
			type: 'string',
		},

		alignment: {
			type: 'string',
		},
  },

  // The UI for the WordPress editor
  edit: props => {
    // Pull out the props we'll use
    const { attributes, className, setAttributes } = props
    const { alignment } = attributes;
		function onChangeAlignment( updatedAlignment ) {
			setAttributes( { alignment: updatedAlignment } );
		}

		const getImageButton = (openEvent) => {
			if (attributes.imageUrl) {
			  return (
				<img
				  src={ attributes.imageUrl }
				  onClick={ openEvent }
				  className="image"
				  alt=""
				/>
			  );
			}

			  return (
				<div className="button-container">
				  <Button
					onClick={ openEvent }
					className="button button-large"
				  >
					Pick an image
				  </Button>
				</div>
			  );

		  };

    return (
      <div className={className}>
        <BlockControls>
							<AlignmentToolbar
								value={ alignment }
								onChange={ onChangeAlignment }
							/>
						</BlockControls>
				<MediaUpload
					onSelect={ media => {
 setAttributes( { imageAlt: media.alt, imageUrl: media.url } );
} }
					type="image"
					value={ attributes.imageID }
					render={ ( { open } ) => getImageButton( open ) }
				/>
        <RichText
          className="js-banner-title wp-admin-banner-title"
          value={attributes.title}
          onChange={value => setAttributes({ title: value })}
          tagName="h3"
          placeholder="Main title"
        />

        <TextareaControl
	className="js-banner-copy wp-admin-banner-copy"
  value={attributes.copy}
  onChange={value => setAttributes({ copy: value })}
					placeholder="Copy"
				/>

        <RichText
          className="js-banner-cta-copy wp-admin-banner-cta-copy"
          value={attributes.callToActionCopy}
          onChange={value => setAttributes({ callToActionCopy: value })}
          placeholder="Call To Action Copy"
        />
        <URLInputButton
				url={ attributes.ctaUrl }
				onChange={ ( ctaUrl ) => setAttributes( { ctaUrl } ) }
			/>
      </div>
    )
  },

  // No save, dynamic block
  save: props => {
    return null
  }
})
