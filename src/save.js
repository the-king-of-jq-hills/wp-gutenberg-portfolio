import { useBlockProps } from '@wordpress/block-editor';

export default function save() {
	return (
		<p { ...useBlockProps.save() }>
			{ 'Portfolio Showcase – hello from the saved content!' }
		</p>
	);
}
