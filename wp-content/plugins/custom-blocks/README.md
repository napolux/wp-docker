# Detailer

A plugin for WordPress that creates a custom Gutenberg block called Book Details. It’s a companion setup for a two-part tutorial on creating custom dynamic Gutenberg blocks for Wordpress.

- [Creating a custom, dynamic Gutenberg block for WordPress, Part 1](https://davidyeiser.com/tutorial/creating-custom-dynamic-gutenberg-block-wordpress-part1)
- _Part 2 in progress_

## Credit

The structure and setup of this repository is taken from [@zgordon/how-to-gutenberg-plugin](https://github.com/zgordon/how-to-gutenberg-plugin). All credit for its cleverness goes to Zac Gordon. Blame for any errors goes to me.

## Setup

Place this project directory in `wp-content/plugins` and then run:

```
yarn
```

To build the files **for development** run:

```
yarn run dev
```

To build the files **for production** run:

```
yarn run build
```

The tutorial linked above goes into much more detail on how to set up the plugin and walks through writing the code for the custom Gutenberg block. If you experience any problems or have any questions please file an issue.
