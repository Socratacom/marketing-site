# [Fresh Components](https://bitbucket.org/freshconsulting/fresh-components/)

The components work with Sage and Advanced Custom Fields, and are the building blocks used for quickly building commonly used elements and entire websites. These components are made to be as generic as possible, and should have nothing about them that is unique to a site in terms of functionality and/or styling.

## A few things...

1. To make the most of it, these components are to be used in place of page templates.
2. Customization to styling should be done in the theme's assets directory, not in fresh_components. Same goes for custom javascript.
3. Custom functionality, unique layouts etc. can be handled in a few different ways:
   * Custom Components
   * Shortcodes


## Current components available:
| Component    | Description   |               
| ------------ | ------------- | ------------- |
| Slider: | The main component, and very versatile. Show a slider comprised of multiple slides, each can have multiple rows containing multiple columns. Each slide can contain its own slider using columns as slides.
| Text-Image: | Show image on one side, text on the other. 1/3 to 2/3 side-by-side layout.
| Options Picker: | Lets you output custom components that are added and edited via ACF's options page. Some setup is required.

## Requirements
1. [Sage](https://roots.io/sage/)
2. [Advanced Custom Fields v5](http://www.advancedcustomfields.com/pro/) (Pro only)

## Installation

After installing and configuring the Sage theme, install Advanced Custom Fields v5. Add the fresh_components folder to your theme directory. We tried to automate as much as possible, but you'll still have to do a couple of things.

Add this line to assets/styles/main.less `@import "../../fresh_components/styles/_fresh-components";`

Copy or move the acf-json directory and json file to the root theme folder.