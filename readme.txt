=== QuickLoop Carousel ===
Contributors: hrishiDcodes
Tags: carousel, slider, image carousel, gallery, responsive, gutenberg, block, animation, swiper
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.2.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight, feature-rich image carousel plugin for WordPress with Gutenberg block support, multiple animation effects, global settings, and full shortcode control.

== Description ==

**QuickLoop Carousel** is a powerful yet lightweight WordPress plugin that lets you create beautiful, fully responsive image carousels anywhere on your site — using either the modern **Gutenberg block editor** or the classic **shortcode** system.

Built on the blazing-fast [Swiper.js](https://swiperjs.com/) library (v11), QuickLoop Carousel gives you pixel-perfect control over every aspect of your carousel: animation effects, autoplay timing, navigation, layout orientation, and much more — all from a clean Settings dashboard.

---

**✨ What's New in v1.2.0**

* Gutenberg Block with live inspector controls
* Three animation effects: Slide, Fade, Zoom
* Global Settings Dashboard (Settings → QuickLoop Carousel)
* Horizontal & Vertical carousel alignment
* Left-to-Right / Right-to-Left / Top-to-Bottom / Bottom-to-Top flow direction
* Configurable image size (200–800 px)
* Autoplay with per-instance delay override
* Lazy image loading for improved performance
* Full keyboard and WCAG accessibility support

---

**🔑 Key Features**

* **Gutenberg Block** — Drag-and-drop carousel builder inside the block editor, no coding needed
* **Shortcode Support** — Use `[qlc_carousel]` in any page, post, or widget
* **3 Animation Effects** — Choose between Slide, Fade, and Zoom transitions
* **Global Settings Dashboard** — Set site-wide defaults for all carousels at once
* **Per-Instance Overrides** — Shortcode attributes override global settings for maximum flexibility
* **Carousel Alignment** — Horizontal or Vertical orientation
* **Flow Direction** — Left-to-Right, Right-to-Left (Horizontal) or Top-to-Bottom, Bottom-to-Top (Vertical)
* **Autoplay Control** — Enable/disable with configurable delay (1000–10000 ms)
* **Navigation Arrows** — Configurable prev/next buttons
* **Pagination Dots** — Clickable bullet pagination
* **Infinite Loop** — Seamless continuous looping
* **Lazy Loading** — Images load only when needed
* **Keyboard Navigation** — Arrow key support, viewport-aware
* **Accessibility (WCAG)** — ARIA labels, screen reader messages, respects `prefers-reduced-motion`
* **Multiple Carousels Per Page** — Each runs independently
* **No jQuery Dependency** — Powered by vanilla JavaScript + Swiper.js
* **Lightweight** — Minimal footprint, optimized for speed

---

**⚙️ How It Works**

QuickLoop Carousel uses a three-tier settings priority system:

`Shortcode / Block Attribute  >  Global Settings  >  Plugin Defaults`

This means:
1. You configure site-wide defaults in the **Settings Dashboard** once.
2. Any individual shortcode or block can override just the settings it needs.
3. Unspecified settings automatically fall back to your global defaults.

**Using the Gutenberg Block:**
1. Open any page or post in the Block Editor.
2. Click the **"+"** button to add a block and search for "QuickLoop Carousel".
3. Add the block to your page.
4. Use the **Inspector Panel** (right sidebar) to select images from the Media Library and configure settings (effect, speed, autoplay, etc.).
5. Save/Publish your page — the carousel renders on the frontend automatically.

**Using the Shortcode:**
1. Upload your images to the WordPress **Media Library** (Media → Library).
2. Note the **image IDs** for each image you want in the carousel (see FAQ below for how to find IDs).
3. Place the shortcode in any page, post, or text widget:
   `[qlc_carousel images="9,10,11,12"]`
4. Optionally add parameters to override global settings for that specific carousel.

---

**🛠️ Global Settings Dashboard**

Navigate to **WordPress Admin → Settings → QuickLoop Carousel** to configure site-wide defaults.

**General Settings**
| Setting | Description | Default |
|---|---|---|
| Enable Loop | Infinite carousel loop | Enabled |
| Show Navigation Arrows | Display previous/next buttons | Enabled |

**Layout Settings**
| Setting | Description | Default |
|---|---|---|
| Carousel Alignment | Horizontal or Vertical orientation | Horizontal |
| Image Size (px) | Size of carousel images (200–800 px) | 400 |
| Flow Direction | Left to Right / Right to Left (Horizontal); Top to Bottom / Bottom to Top (Vertical) | Left to Right |

**Autoplay Settings**
| Setting | Description | Default |
|---|---|---|
| Enable Autoplay by Default | Automatically advance slides | Enabled |
| Autoplay Delay (ms) | Time between slide transitions (1000–10000 ms) | 3000 |

**Animation Settings**
| Setting | Description | Default |
|---|---|---|
| Transition Speed (ms) | Animation duration (100–2000 ms) | 300 |
| Animation Effect | slide, fade, or zoom | slide |

You can click **Save Changes** to apply settings, or **Reset to Defaults** to restore all settings to plugin defaults.

---

**📋 Shortcode Reference**

**Basic Usage:**
`[qlc_carousel images="9,10,11,12"]`

**All Available Parameters:**

| Parameter | Values | Description |
|---|---|---|
| `images` | Comma-separated IDs | **(Required)** Image IDs from the Media Library |
| `effect` | `slide`, `fade`, `zoom` | Animation effect (overrides global) |
| `speed` | Number (ms) | Transition speed in milliseconds (overrides global) |
| `autoplay` | `true`, `false` | Enable or disable autoplay (overrides global) |
| `delay` | Number (ms) | Autoplay delay in milliseconds (overrides global) |
| `navigation` | `true`, `false` | Show or hide prev/next arrows (overrides global) |
| `pagination` | `true`, `false` | Show or hide pagination dots (default: true) |
| `loop` | `true`, `false` | Enable or disable infinite loop (overrides global) |

**Shortcode Examples:**

Basic carousel using global settings:
`[qlc_carousel images="9,10,11,12"]`

Fade effect with fast transition:
`[qlc_carousel images="9,10,11,12" effect="fade" speed="500"]`

Zoom effect with no autoplay:
`[qlc_carousel images="9,10,11,12" effect="zoom" autoplay="false"]`

Slide effect with slow autoplay (5 seconds):
`[qlc_carousel images="9,10,11,12" effect="slide" delay="5000"]`

No arrows, no pagination, manual navigation only:
`[qlc_carousel images="9,10,11,12" navigation="false" pagination="false"]`

No loop (stops at last slide):
`[qlc_carousel images="9,10,11,12" loop="false"]`

== Installation ==

**Method 1 — Automatic Installation (Recommended)**

1. Log in to your WordPress admin panel.
2. Go to **Plugins → Add New**.
3. Search for **"QuickLoop Carousel"**.
4. Click **Install Now**, then click **Activate**.

**Method 2 — Manual Installation via ZIP**

1. Download the plugin `.zip` file.
2. Log in to your WordPress admin panel.
3. Go to **Plugins → Add New → Upload Plugin**.
4. Click **Choose File**, select the downloaded `.zip`, and click **Install Now**.
5. After installation completes, click **Activate Plugin**.

**Method 3 — Manual FTP Upload**

1. Extract the downloaded `.zip` file.
2. Upload the extracted `quickloop-carousel` folder to `/wp-content/plugins/` on your server via FTP/SFTP.
3. Log in to WordPress admin, go to **Plugins**, and click **Activate** under QuickLoop Carousel.

**Post-Installation Setup**

1. After activating, go to **Settings → QuickLoop Carousel** to configure your global defaults.
2. Upload images to your **Media Library** if you haven't already.
3. Add the Gutenberg block or shortcode to any page or post.

**Getting Image IDs:**

1. Go to **Media → Library** in your WordPress admin.
2. Click on any image to open its detail panel.
3. Look at the URL in your browser address bar — the number at the end is the image ID.
   - Example URL: `post.php?post=9&action=edit` → ID is **9**
4. Alternatively, switch to **List View** in the Media Library and hover over an image — the ID appears in the status bar at the bottom of your browser.

== Frequently Asked Questions ==

= How do I find my image IDs? =

1. Go to **Media → Library** in the WordPress admin.
2. Click on an image to open its attachment details.
3. The URL in your browser bar will contain the ID, e.g. `post.php?post=9&action=edit` — the ID is **9**.

In List View mode, you can also hover over an image and see the ID in the link shown at the bottom of your browser window.

= Can I use multiple carousels on the same page? =

Yes! Every carousel instance is fully independent. You can add as many `[qlc_carousel]` shortcodes or Gutenberg blocks on the same page as you like.

= How do I disable autoplay for one specific carousel? =

Add `autoplay="false"` to the shortcode:
`[qlc_carousel images="9,10,11,12" autoplay="false"]`

This only affects that carousel — other carousels on the page follow the global setting.

= Can I change the autoplay speed for a single carousel? =

Yes, use the `delay` parameter (in milliseconds):
`[qlc_carousel images="9,10,11,12" delay="5000"]` — advances every 5 seconds.

= What animation effects are available? =

Three effects are available: **slide**, **fade**, and **zoom**. Set a global default in Settings, or override per-carousel using the `effect` shortcode parameter.

= Is the carousel mobile-responsive? =

Yes. QuickLoop Carousel is fully responsive and adapts seamlessly to any screen size — mobile phones, tablets, and desktops — without any extra configuration.

= Is the carousel keyboard accessible? =

Yes. The carousel supports:
* **Arrow key navigation** (only when the carousel is in the viewport)
* **ARIA labels** for screen readers
* **Clickable pagination bullets** with screen reader messages
* **Pause on mouse hover** during autoplay
* Respects the browser's **prefers-reduced-motion** setting

= Does QuickLoop Carousel work with the Gutenberg block editor? =

Yes — it includes a native Gutenberg block. Open the block editor, click **+**, search for "QuickLoop Carousel", and add the block. Configure images and settings directly from the block Inspector.

= The carousel is not showing. What should I check? =

1. Verify your image IDs are correct and the images exist in your Media Library.
2. Make sure there are no JavaScript errors in your browser's developer console.
3. Check that the plugin is activated under **Plugins**.
4. Confirm there are no plugin conflicts by temporarily deactivating other plugins.
5. Try switching to a default WordPress theme (e.g., Twenty Twenty-Four) to rule out theme conflicts.

= Does this plugin use jQuery? =

No. QuickLoop Carousel uses pure vanilla JavaScript and the Swiper.js library (loaded from jsDelivr CDN). No jQuery dependency.

= Does this plugin collect any data? =

No. QuickLoop Carousel does not collect, store, or transmit any personal or user data. It does not use cookies or any tracking technologies.

== Screenshots ==

1. QuickLoop Carousel Settings page — General, Layout, Autoplay, and Animation settings
2. Settings page continued — Autoplay Delay, Animation Settings, and built-in Shortcode Usage reference
3. Adding the shortcode in the WordPress Block Editor (`[qlc_carousel images="9,10,11,12"]`)
4. A live carousel displayed on the frontend with navigation arrows and pagination dots (desktop)
5. A live carousel displayed on a mobile device — fully responsive layout

== Changelog ==

= 1.2.0 =
* Added Gutenberg block with live Inspector controls for images and all settings
* Added Carousel Alignment option: Horizontal or Vertical
* Added Flow Direction: Left-to-Right, Right-to-Left, Top-to-Bottom, Bottom-to-Top
* Added Image Size setting (200–800 px configurable range)
* Improved attribute priority system: shortcode/block > global > defaults
* Updated plugin version to 1.2.0

= 1.1.0 =
* Added Settings Dashboard (Settings → QuickLoop Carousel)
* Added three animation effects: slide, fade, zoom
* Added global controls: loop, navigation arrows, speed, effect, autoplay
* Added shortcode attributes: `effect`, `speed`
* Enhanced lazy loading for better performance

= 1.0.0 =
* Initial release
* Basic image carousel with shortcode `[qlc_carousel images="..."]`
* Autoplay, navigation arrows, and pagination dots
* Fully responsive design
* Keyboard and ARIA accessibility support

== Upgrade Notice ==

= 1.2.0 =
This release adds Gutenberg block support and new layout controls (alignment, flow direction, image size). Existing shortcodes continue to work without any changes.

= 1.1.0 =
Adds global Settings Dashboard and animation effects. No breaking changes.

= 1.0.0 =
Initial release of QuickLoop Carousel.

== Support ==

For support and bug reports, please open an issue on the [GitHub repository](https://github.com/hrishiDcodes/QuickLoop-Carousel-WordPress-Plugin) or visit the plugin support forum on WordPress.org.

== Privacy Policy ==

QuickLoop Carousel does not collect, store, or transmit any user data. It does not use cookies or any tracking technologies of any kind.

== Credits ==

This plugin is powered by [Swiper.js](https://swiperjs.com/) (v11), an open-source touch slider library licensed under the MIT License.
