import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useBlockProps } from '@wordpress/block-editor';

import './editor.scss';

export default function Edit({attributes, setAttributes, className}) {

	// Get the portfolio items
	const posts = useSelect( ( select ) => {
		return select( 'core' ).getEntityRecords( 'postType', 'portfolio' );
	});

	console.log( wpgp_data.siteUrl );

	// The output
	function portfolioShow (items) {

		if( !items ) {
			return <h1>{ __("Items Not Loaded", "wpgp_portfolio_subtitle") }</h1>
		}
		if( items && items.length === 0 ) {
			return <h1>{ __("No Items Available", "wpgp_portfolio_subtitle") }</h1>	
		}
		if( items ) {
			const showCase = items.map((pitem, index) => {

				if ( pitem.meta.wpgp_portfolio_featuredimage.length > 0 ) {

					var mediaURL = pitem.meta.wpgp_portfolio_featuredimage.map( (imageID) => {

						const imgURL = wp.data.select('core').getMedia(imageID);

						if(!imgURL) {
							return "Image Not Loaded";
						}
						if(imgURL) {
							//console.log(imgURL);
							return (<img src={ imgURL.media_details.sizes.medium_large.source_url } />);
						}						

					});				

				}	


				return (
					<div className='portfolio-item'>
						<h2>{pitem.title.rendered}</h2>
						<p>{pitem.content.rendered}</p>
						<p>{pitem.link}</p>
						<div>{mediaURL}</div>
					</div>
				);
			});
			return showCase;
		}
	}
	

	return (
		<div { ...useBlockProps() }>
			{ portfolioShow(posts) }
		</div>
	);
}
