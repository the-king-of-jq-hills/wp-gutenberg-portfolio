import { __ } from '@wordpress/i18n';
import { useEffect, useState } from 'react';

import { 
	useBlockProps, 
	AlignmentControl, 
	BlockControls,
	InspectorControls,
	PanelColorSettings
} from '@wordpress/block-editor';

import {
	TextControl,
	PanelBody,
	PanelRow,
	GradientPicker,
	RangeControl,
    __experimentalRadio as Radio,
    __experimentalRadioGroup as RadioGroup,
} from '@wordpress/components';

import './editor.scss';

export default function Edit({attributes, setAttributes}) {

	console.log(className);

	// Getting the Site URL from localized script
	const restURL = wpgp_data.siteUrl + '/wp-json/wpportfolio/v1/portfolio';

	const { numberOfItems, numberOfColumns } = attributes;

	const onChangenumberOfItems = ( newnumberOfItems ) => {
		setAttributes( { numberOfItems : newnumberOfItems } )
	}

	const onChangenumberOfColumns = ( newnumberOfColumns ) => {
		setAttributes( { numberOfColumns : newnumberOfColumns } )
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

		const showCase = posts.map((post) => {
			
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
					<div>
						<div className='image-container'>
							<a href={post.pagelink} rel='nofollow' target='_blank'>
								<img src={imageURL} alt={post.title} className='portfolio-image' />
							</a>
						</div>
						<h3>{post.title}</h3>
						<h4>{post.subtitle}</h4>
						<div>{categoryList}</div>
					</div>
				</div>
			);

		});
		

		return showCase;
	}
	

	return (
		<>
			<InspectorControls>
				<PanelBody 
					title={ __("Portfolio Settings", "wp-gutenberg-portfolio") }
					initialOpen= {true}
				>
					<PanelRow>
						<RangeControl
							label="Number of Items"
							value={ numberOfItems }
							onChange={ onChangenumberOfItems } 								
							min={ 4 }
							max={ 16 }
						/>
						<RangeControl
							label="Number of Columns"
							value={ numberOfColumns }
							onChange={ onChangenumberOfColumns } 								
							min={ 1 }
							max={ 4 }
						/>											
					</PanelRow>
				</PanelBody>		
			</InspectorControls>

			<div { ...useBlockProps() }>
				{ portfolioShow(posts) }
			</div>
		</>
	);
}
