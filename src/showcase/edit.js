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
			
			const imageList = post.mediaurls.map((imageURLs) => {
				return (<img src={imageURLs} alt='' />);
			});

			return (
				<div className='portfolio-item'>
					<h2>{post.title}</h2>
					<h4>{post.subtitle}</h4>
					<div>{categoryList}</div>
					<div>{imageList}</div>
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
