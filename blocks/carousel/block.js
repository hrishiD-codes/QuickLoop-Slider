/**
 * QuickLoop Carousel Gutenberg Block
 * 
 * @package QuickLoop_Carousel
 */

(function (blocks, element, blockEditor, components, i18n, data) {
	const { registerBlockType } = blocks;
	const { createElement: el, Fragment } = element;
	const { InspectorControls, BlockControls, MediaUpload, MediaUploadCheck, useBlockProps } = blockEditor;
	const { PanelBody, ToggleControl, RangeControl, SelectControl, Button, Placeholder, Notice, ToolbarGroup, ToolbarButton } = components;
	const { __ } = i18n;
	const { useSelect } = data;

	registerBlockType('quickloop/carousel', {
		edit: function (props) {
			const { attributes, setAttributes } = props;
			const { images, autoplay, delay, navigation, pagination, loop, effect, speed } = attributes;

			// Get media items
			const imageData = useSelect(
				(select) => {
					if (!images || images.length === 0) return [];
					return images.map((id) => {
						const media = select('core').getMedia(id);
						return media ? {
							id: id,
							url: media.source_url,
							alt: media.alt_text || ''
						} : null;
					}).filter(Boolean);
				},
				[images]
			);

			const onSelectImages = (media) => {
				const imageIds = media.map((img) => img.id);
				setAttributes({ images: imageIds });
			};

			const removeImage = (indexToRemove) => {
				const newImages = images.filter((_, index) => index !== indexToRemove);
				setAttributes({ images: newImages });
			};

			const blockProps = useBlockProps();

			return el('div', blockProps,
				el(Fragment, {},
					// Inspector Controls
					el(InspectorControls, {},
						el(PanelBody, { title: __('Carousel Settings', 'quickloop-carousel'), initialOpen: true },
							el(Notice, {
								status: 'info',
								isDismissible: false,
								className: 'qlc-settings-notice'
							},
								el('p', {}, __('Leave settings empty to use global defaults from Settings → QuickLoop Carousel', 'quickloop-carousel'))
							),
							
							el(ToggleControl, {
								label: __('Enable Autoplay', 'quickloop-carousel'),
								checked: autoplay !== null ? autoplay : false,
								onChange: (value) => setAttributes({ autoplay: value }),
								help: autoplay === null ? __('Using global setting', 'quickloop-carousel') : ''
							}),

							autoplay && el(RangeControl, {
								label: __('Autoplay Delay (ms)', 'quickloop-carousel'),
								value: delay || 3000,
								onChange: (value) => setAttributes({ delay: value }),
								min: 1000,
								max: 10000,
								step: 100
							}),

							el(ToggleControl, {
								label: __('Show Navigation Arrows', 'quickloop-carousel'),
								checked: navigation !== null ? navigation : false,
								onChange: (value) => setAttributes({ navigation: value }),
								help: navigation === null ? __('Using global setting', 'quickloop-carousel') : ''
							}),

							el(ToggleControl, {
								label: __('Show Pagination Dots', 'quickloop-carousel'),
								checked: pagination !== null ? pagination : true,
								onChange: (value) => setAttributes({ pagination: value })
							}),

							el(ToggleControl, {
								label: __('Enable Loop', 'quickloop-carousel'),
								checked: loop !== null ? loop : false,
								onChange: (value) => setAttributes({ loop: value }),
								help: loop === null ? __('Using global setting', 'quickloop-carousel') : ''
							})
						),

						el(PanelBody, { title: __('Animation Settings', 'quickloop-carousel'), initialOpen: false },
							el(SelectControl, {
								label: __('Animation Effect', 'quickloop-carousel'),
								value: effect || 'slide',
								options: [
									{ label: __('Slide', 'quickloop-carousel'), value: 'slide' },
									{ label: __('Fade', 'quickloop-carousel'), value: 'fade' },
									{ label: __('Zoom', 'quickloop-carousel'), value: 'zoom' }
								],
								onChange: (value) => setAttributes({ effect: value }),
								help: effect === null ? __('Using global setting', 'quickloop-carousel') : ''
							}),

							el(RangeControl, {
								label: __('Transition Speed (ms)', 'quickloop-carousel'),
								value: speed || 300,
								onChange: (value) => setAttributes({ speed: value }),
								min: 100,
								max: 2000,
								step: 50,
								help: speed === null ? __('Using global setting', 'quickloop-carousel') : ''
							})
						)
					),

					// Block Content
					(!images || images.length === 0) ?
						el(Placeholder, {
							icon: 'images-alt2',
							label: __('QuickLoop Carousel', 'quickloop-carousel'),
							instructions: __('Select images to create your carousel', 'quickloop-carousel'),
							className: 'qlc-block-placeholder'
						},
							el(MediaUploadCheck, {},
								el(MediaUpload, {
									onSelect: onSelectImages,
									allowedTypes: ['image'],
									multiple: true,
									value: images,
									render: ({ open }) => (
										el(Button, {
											onClick: open,
											variant: 'primary'
										}, __('Select Images', 'quickloop-carousel'))
									)
								})
							)
						)
						:
						el('div', { className: 'qlc-block-container' },
							el('div', { className: 'qlc-block-images' },
								imageData.map((image, index) =>
									el('div', {
										key: image.id,
										className: 'qlc-block-image-item'
									},
										el('img', {
											src: image.url,
											alt: image.alt
										}),
										el('button', {
											className: 'qlc-image-remove',
											onClick: () => removeImage(index)
										}, '×')
									)
								)
							),
							el(MediaUploadCheck, {},
								el(MediaUpload, {
									onSelect: onSelectImages,
									allowedTypes: ['image'],
									multiple: true,
									value: images,
									render: ({ open }) => (
										el(Button, {
											onClick: open,
											variant: 'secondary',
											style: { marginTop: '15px' }
										}, __('Edit Images', 'quickloop-carousel'))
									)
								})
							)
						)
				)
			);
		},

		save: function () {
			// Server-side rendering
			return null;
		}
	});

})(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.i18n,
	window.wp.data
);
