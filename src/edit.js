import { __ } from '@wordpress/i18n';
import { useEffect, useState } from 'react';

import Masonry from 'masonry-layout';

import { 
	useBlockProps, 
	AlignmentControl, 
	BlockControls,
	InspectorControls,
	PanelColorSettings
} from '@wordpress/block-editor';

import {
	PanelBody,
	PanelRow,
	GradientPicker,
	RangeControl,
    __experimentalRadio as Radio,
    __experimentalRadioGroup as RadioGroup,
} from '@wordpress/components';

import './editor.scss';

export default function Edit({attributes, setAttributes}) {

	// Getting the Site URL from localized script
	const restURL = wpgp_data.siteUrl + '/wp-json/wpportfolio/v1/portfolio';

	const { numberOfItems, numberOfColumns } = attributes;

	const onChangenumberOfItems = ( newnumberOfItems ) => {
		setAttributes( { numberOfItems : newnumberOfItems } );
		resetmasonry();
	}

	const onChangenumberOfColumns = ( newnumberOfColumns ) => {
		setAttributes( { numberOfColumns : newnumberOfColumns } );
		resetmasonry();
	}	

	// fetching the data
    const [posts, setPosts] = useState([]);
    useEffect(() => {
        async function loadPosts() {
	
            const response = await fetch(restURL);
            if(!response.ok) {
                // oups! something went wrong 
                return;
            }

            const posts = await response.json();
            setPosts(posts);
        }
    
        loadPosts();
   }, [])
   
   
	// The output
	function portfolioShow (posts) {

		const showCase = posts.slice(0,numberOfItems).map((post) => {
			
			// Portfolio Category list to string
			const categoryList = post.categories.toString();
			
			const imageURL = post.mediaurls ? post.mediaurls[0] : null;

			/* 
			const imageList = post.mediaurls.map((imageURLs) => {
				return (<img src={imageURLs} alt='' />);
			});
			*/

			return (
				<div className='portfolio-item'>
					<div className='wpgp-item-container'>
						<div className='image-container'>
							<img src={imageURL} alt={post.title} className='portfolio-image' />
						</div>
						<div className='wpgp-contents-bg'></div>
						<div className='wpgp-link'>
							{/* Single Page Link */}
							<a href={post.pagelink} rel='nofollow' target='_selft'>
								<span class="dashicons dashicons-paperclip"></span>
							</a>
							{/* external portfolio link from metabox */}
							{ post.link && <a href={post.link} rel='nofollow' target='_blank'>
								<span class="dashicons dashicons-admin-links"></span></a> 
							}
						</div>
						<h3>{post.title}</h3>
						<h4>{post.subtitle}</h4>
						<div className='wpgp-cat-list'>{categoryList}</div>
						
					</div>
				</div>
			);

		});
		

		return showCase;
	}
	
	// initiating the masonry layout
	var isPortfolioExist = document.getElementsByClassName('wpg-portfolio-edit');
	if (isPortfolioExist.length > 0) {
		var msnry = new Masonry( '.wpg-portfolio-edit', {
			itemSelector: '.portfolio-item'
		});
	}
	// resetting the masonry layout
	function resetmasonry() {
		setTimeout(function() {
			msnry.layout();
		}, 100);
	}

	return (
		<>
			<InspectorControls>
				<PanelBody 
					title={ __("Portfolio Settings", "wp-gutenberg-portfolio") }
					initialOpen= {true}
				>
					<PanelRow className='wpgp-panel'>
						<RangeControl
							label="Number of Items"
							value={ numberOfItems }
							onChange={ onChangenumberOfItems } 								
							min={ 4 }
							max={ 20 }
						/>
						<RangeControl
							label="Number of Columns"
							value={ numberOfColumns }
							onChange={ onChangenumberOfColumns } 								
							min={ 2 }
							max={ 5 }
						/>											
					</PanelRow>
				</PanelBody>		
			</InspectorControls>

			<div { ...useBlockProps() }>
				<div className={`wpg-portfolio wpg-portfolio-edit wpgp-column-${numberOfColumns}`}>
					{ portfolioShow(posts) }
				</div>
			</div>
		</>
	);
}
