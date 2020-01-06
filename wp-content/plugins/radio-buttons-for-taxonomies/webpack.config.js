const path = require('path');
const defaultConfig = require("./node_modules/@wordpress/scripts/config/webpack.config");

module.exports = {
  ...defaultConfig,
	entry: {
		index: path.resolve( __dirname, 'js/src', 'index.js' ),
	},
	output: {
		filename: '[name].js',
		path: path.resolve( __dirname, 'js/dist' ),
	},
};
