const ExtractTextPlugin = require('extract-text-webpack-plugin');

const path = require('path');

const config = {
	context: path.resolve(__dirname),
  devtool: 'source-map inline-source-map',
	entry: [
		'./src/scss/main.scss',
		'./src/js/main.js'
	],
	output: {
		filename: 'wp-content/themes/journal/assets/js/[name].js',
    publicPath: '/'
	},
	plugins: [
    new ExtractTextPlugin({
      filename: '/wp-content/themes/journal/assets/css/[name].css',
      allChunks: true
    })
	],
	module: {
    loaders: [
      {
        test: /\.(otf|eot|ttf|woff|woff2)$/,
        loader: 'file-loader?name=/wp-content/themes/journal/assets/fonts/[name].[ext]'
      },
      {
        test: /\.(png|jpg|gif|ico)$/,
        loader: 'file-loader?name=/wp-content/themes/journal/assets/images/[name].[ext]'
      },
      {
        test: /\.scss$/,
        loader: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use:'css-loader?importLoaders=1!postcss-loader!resolve-url-loader!sass-loader?sourceMap'
        })

      }
    ]
	},
  resolve: {
    modules: [
      path.resolve(__dirname, 'src'),
      path.resolve(__dirname, 'src/js'),
      path.resolve(__dirname, 'src/scss'),
      path.resolve(__dirname, 'node_modules')
    ],
    extensions: ['.js', '.json', '.jpg', '.png', '.svg', '.sass', '.scss', '.css'],
  }
};

module.exports = config;