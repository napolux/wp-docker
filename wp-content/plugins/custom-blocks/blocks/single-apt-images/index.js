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

registerBlockType('davidyeiser-detailer/single-apt-images', {
  title: __( 'Single apartment images' ),
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
    imageUrlFloorplan: {
        type: 'string',
      },
    imageIdFloorplan: {
			type: 'string',
    },
    imageUrlAspect: {
      type: 'string',
    },
    imageIdAspect: {
      type: 'string',
    },
    imageUrlViews: {
      type: 'string',
    },
    imageIdViews: {
      type: 'string',
    }
  },

  // The UI for the WordPress editor
  edit: props => {
    // Pull out the props we'll use
    const { attributes, className, setAttributes } = props

		const getImageButtonFloorplan = (openEvent) => {

			if (attributes.imageUrlFloorplan) {
			  return (

				<img
				  src={ attributes.imageUrlFloorplan }
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

      const getImageButtonAspect = (openEvent) => {

        if (attributes.imageUrlAspect) {
          return (

          <img
            src={ attributes.imageUrlAspect }
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

        const getImageButtonViews = (openEvent) => {

          if (attributes.imageUrlViews) {
            return (

            <img
              src={ attributes.imageUrlViews }
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
        <label>Floorplan:</label>
        <MediaUpload
          onSelect={media => {
            setAttributes({ imageIdFloorplan: media.id, imageUrlFloorplan: media.url });
          }}
          type="image"
          value={attributes.imageID}
          render={({ open }) => getImageButtonFloorplan(open)}
        />
        <label>Aspect:</label>
        <MediaUpload
          onSelect={media => {
            setAttributes({ imageIdAspect: media.id, imageUrlAspect: media.url });
          }}
          type="image"
          value={attributes.imageID}
          render={({ open }) => getImageButtonAspect(open)}
        />
        <label>Views:</label>
        <MediaUpload
          onSelect={media => {
            setAttributes({ imageIdViews: media.id, imageUrlViews: media.url });
          }}
          type="image"
          value={attributes.imageID}
          render={({ open }) => getImageButtonViews(open)}
        />
      </div>
    );
  },

  // No save, dynamic block
  save: props => {
    return null
  }
})
