
import { useBlockProps } from '@wordpress/block-editor';

export default function save() {
	return (
		<p { ...useBlockProps.save() }>
			{ 'Portfolio Slider – hello from the saved content!' }
		</p>
	);
}
