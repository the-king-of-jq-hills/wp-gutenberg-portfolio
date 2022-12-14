import { __ } from '@wordpress/i18n';
import { useEffect, useState } from 'react';
import { useBlockProps } from '@wordpress/block-editor';

import './editor.scss';

export default function Edit({attributes, setAttributes, className}) {

	const restURL = wpgp_data.siteUrl + '/wp-json/wpportfolio/v1/portfolio';

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
		console.log(posts);

		const showCase = posts.map((post) => {
			
			// Portfolio Category list to string
			const categoryList = post.categories.toString();
			
			const imageURL = post.mediaurls ? post.mediaurls[0] : null;
			console.log(imageURL);

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
		<div { ...useBlockProps() }>
			{ portfolioShow(posts) }
		</div>
	);
}
