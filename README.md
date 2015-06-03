# Socrata marketing site
_This is the main marketing site for Socrata. Only the Theme and custom Socrata plugins are in this repository._

## Local site setup
1. Clone repo
2. Import database
3. Run npm install and install Gulp
4. run gulp watch

## Additional Plugins Used
- Migrate DB Pro
- Advanced Custom Fields Pro
- The Events Calendar (the-events-calendar)
- Disqus Comment System (disqus-comment-system)
- FacetWP
- SearchWP
- TineMCE Advanced (tinymce-advanced)
- Useful Banner Manager (useful-banner-manager)
- WordPress SEO (wordpress-seo)
- WP-PageNavi (wp-pagenavi)
- WP Google Tag Manager (wp-google-tag-manager)

### Installing all plugins with WP-CLI
wp plugin install the-events-calendar disqus-comment-system tinymce-advanced useful-banner-manager wordpress-seo wp-pagenavi wp-google-tag-manager  --activate

## Code Standards
When in doubt, use [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

## Component Setup

#### Adding a new component
- Sync ACF
- Go the the Fresh Components ACF group and add a new layout to the Components Flexible Content. Add your required fields
- Review fresh-components.php in the fresh_components folder and add your new layout
- Add your new component function in a new file COMPONENT-NAME.php, Follow this convention:
  - fresh_components/scripts/COMPONENT_NAME.js 
  - fresh_components/styles/COMPONENT-NAME.less
- Inclide .less file in assets/styles/main.less
- No site aesthetics should go in component less and no component aesthetics should go in site less.