=== QuickLoop Carousel ===
Contributors: yourusername
Tags: carousel, slider, image carousel, gallery, responsive, gutenberg, block
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight, feature-rich carousel plugin for WordPress with Gutenberg block support, animation effects, and global settings.

== Description ==

QuickLoop Carousel is a powerful yet lightweight WordPress plugin that allows you to create beautiful, responsive image carousels. Use either the modern Gutenberg block editor or classic shortcodes - your choice!

**✨ NEW in v1.1.0:**

* **Gutenberg Block** - Visual carousel builder in the block editor
* **Animation Effects** - Choose from slide, fade, or zoom transitions
* **Settings Dashboard** - Global controls at Settings → QuickLoop Carousel
* **Enhanced Performance** - Lazy loading optimization

**Key Features:**

* **Gutenberg Block** - Drag-and-drop interface in the block editor
* **Easy Shortcode** - Simple `[qlc_carousel]` for classic editor
* **Animation Effects** - Slide, fade, and zoom transition options
* **Global Settings** - Set defaults for all carousels
* **Lightweight** - Minimal code, optimized for speed
* **Responsive** - Perfect on all devices and screen sizes
* **Accessible** - WCAG compliant with keyboard navigation
* **Customizable** - Full control over autoplay, navigation, pagination
* **No jQuery** - Modern vanilla JavaScript

**How It Works:**

**Using Gutenberg Block:**
1. Add QuickLoop Carousel block in the block editor
2. Click "Select Images" to choose from Media Library
3. Customize settings in the block inspector
4. Publish and enjoy!

**Using Shortcode:**
1. Upload images to your WordPress Media Library
2. Note the image IDs (visible in the Media Library)
3. Add shortcode to any page or post: `[qlc_carousel images="123,456,789"]`
4. Customize with shortcode parameters

**Basic Usage:**

`[qlc_carousel images="123,456,789"]`

**Available Parameters:**

* `images` - Comma-separated image IDs from Media Library (required)
* `effect` - Animation effect: slide, fade, zoom (default: from settings)
* `speed` - Transition speed in milliseconds (default: from settings)
* `autoplay` - Enable/disable autoplay (default: from settings)
* `delay` - Autoplay delay in milliseconds (default: from settings)
* `navigation` - Show prev/next arrows (default: from settings)
* `pagination` - Show dots/bullets (default: true)
* `loop` - Enable infinite loop (default: from settings)

**Examples:**

Basic carousel:
`[qlc_carousel images="123,456,789"]`

Fade effect with custom speed:
`[qlc_carousel images="123,456,789" effect="fade" speed="800"]`

Zoom effect without autoplay:
`[qlc_carousel images="123,456,789" effect="zoom" autoplay="false"]`

Fast sliding carousel:
`[qlc_carousel images="123,456,789" effect="slide" speed="200"]`

== Installation ==

**Automatic Installation:**

1. Log in to your WordPress admin panel
2. Go to Plugins > Add New
3. Search for "QuickLoop Carousel"
4. Click "Install Now" and then "Activate"

**Manual Installation:**

1. Download the plugin zip file
2. Log in to your WordPress admin panel
3. Go to Plugins > Add New > Upload Plugin
4. Choose the zip file and click "Install Now"
5. Activate the plugin

**Getting Image IDs:**

1. Go to Media > Library
2. Click on an image
3. Look at the URL in your browser - the number at the end is the image ID
   Example: `post.php?post=123&action=edit` - the ID is 123

== Frequently Asked Questions ==

= How do I find image IDs? =

1. Go to Media > Library in your WordPress admin
2. Click on an image
3. Look at the URL in your browser address bar
4. The number at the end is the image ID (e.g., `post.php?post=123&action=edit` - ID is 123)

Alternatively, in the Media Library list view, hover over an image and the ID will appear in the bottom left of your browser.

= Can I use this plugin with the Block Editor (Gutenberg)? =

Yes! Simply add a Shortcode block and paste your carousel shortcode inside it.

= How do I disable autoplay? =

Add `autoplay="false"` to your shortcode:
`[qlc_carousel images="123,456,789" autoplay="false"]`

= Can I change the autoplay speed? =

Yes, use the `delay` parameter (in milliseconds):
`[qlc_carousel images="123,456,789" delay="5000"]` (5 seconds)

= Is the carousel responsive? =

Yes, the carousel is fully responsive and works on all devices including mobile phones and tablets.

= Is the carousel accessible? =

Yes, the carousel follows accessibility best practices including:
* Keyboard navigation support (arrow keys)
* ARIA labels for screen readers
* Pause on hover/focus
* Respects prefers-reduced-motion setting

= Can I add multiple carousels on the same page? =

Yes, you can add as many carousels as you want on the same page. Each carousel will work independently.

= The carousel isn't showing. What should I check? =

1. Make sure the image IDs are correct
2. Check that the images exist in your Media Library
3. Verify there are no JavaScript errors in your browser console
4. Check your theme compatibility

= Does this plugin work with my theme? =

QuickLoop Carousel should work with any properly coded WordPress theme. If you experience issues, please contact support.

== Screenshots ==

1. Carousel with navigation arrows and pagination dots
2. Shortcode example in the WordPress editor
3. Responsive carousel on mobile device
 4. Media Library showing image IDs

== Changelog ==

= 1.1.0 =
* Added Gutenberg block support for visual editing
* Added animation effects (slide, fade, zoom)
* Added settings page (Dashboard → Settings → QuickLoop Carousel)
* Added global control for loop, arrows, speed, effects, and autoplay
* Enhanced lazy loading with better performance
* New shortcode attributes: effect, speed
* Improved attribute priority system (shortcode > global > defaults)
* Updated to version 1.1.0

= 1.0.0 =
* Initial release
* Basic carousel functionality
* Shortcode support
* Responsive design
* Accessibility features
* Autoplay, navigation, and pagination controls

== Upgrade Notice ==

= 1.0.0 =
Initial release of QuickLoop Carousel.

== Support ==

For support, please visit the plugin support forum on WordPress.org.

== Privacy Policy ==

QuickLoop Carousel does not collect, store, or transmit any user data. It does not use cookies or tracking technologies.

== Credits ==

This plugin uses Swiper.js (https://swiperjs.com/) for carousel functionality, which is licensed under the MIT License.
