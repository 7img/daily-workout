=== Daily Workout ===
Requires at least: 5.2
Tested up to: 5.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a Daily Workout widget and shortcode to your WordPress site, helping your users stay fit!

== Description ==

The Daily Workout plugin adds a daily workout widget and shortcode to your WordPress site, encouraging fitness and health among your site visitors. The plugin fetches daily workouts, including details like workout title, content, and a link for more information (e.g., warmup, cooldown, and no-equipment options).

== Features ==

- **Daily Workout Widget**: Easily add the daily workout to your website's sidebar or any widget area.
- **Shortcode Support**: Use the `[daily_workout]` shortcode to insert the daily workout into posts or pages.
- **Admin Settings**: Customize the plugin settings, including an option to support the plugin by displaying a link to the original workout content.
- **Responsive Design**: The workout display is fully responsive, making it accessible on any device.

== Installation ==

1. Download the plugin from the WordPress plugin repository or upload the plugin files to the `/wp-content/plugins/daily-workout` directory.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the `Settings -> Daily Workout Settings` screen to configure the plugin (optional).

== Usage ==

== Widget ==

1. Go to `Appearance -> Widgets` in the WordPress admin area.
2. Drag the "Daily Workout" widget to your desired widget area.
3. If desired, add a title for the widget and save.

== Shortcode ==

Insert the `[daily_workout]` shortcode into any post or page where you want the daily workout to appear.

== Styling the Daily Workout ==

The Daily Workout plugin outputs its content in a semantic HTML structure that can be easily styled with CSS. Here's a guide to customizing the appearance of the workout display.

== Basic Structure ==

The widget and shortcode output are wrapped in an `<article>` tag with a class of `.daily-workout`. Here's a breakdown of the structure:

```html
<article class="daily-workout" published="2024-03-22T13:42:29Z">
    <header>
        <h2>Workout Title</h2>
    </header>
    <div>
        Workout Content
    </div>
    <footer>
        <a href="https://wod-generator.com/workout-link" target="_blank">Explore warmup, cooldown, and scaling options</a>
    </footer>
</article>
```

== Contributing ==

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/amazing-feature`)
3. Commit your Changes (`git commit -m 'Add some amazing feature'`)
4. Push to the Branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

== Support ==

For support please create a ticket on [Github](https://github.com/7img/daily-workout/issues).

== Acknowledgements ==

- [WOD Generator](https://wod-generator.com/) for providing the daily workouts.
- All contributors who have helped to expand and improve this plugin.

== License ==

This plugin is released under the GNU General Public License v2.0. See the [LICENSE](LICENSE) file for details.