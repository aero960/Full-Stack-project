const HtmlWebpackPlugin = require('html-webpack-plugin');
const OpenBrowserPlugin = require('open-browser-webpack-plugin')
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MinifyPlugin = require("babel-minify-webpack-plugin");
const DashboardPlugin = require("webpack-dashboard/plugin");
const statementConfig = require("./stmconfig.js");
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {plugins:[
        new CleanWebpackPlugin(),
        new MinifyPlugin({}, {
            test: /\.js($|\?)/i
        }),
        new VueLoaderPlugin(),
        new HtmlWebpackPlugin({
            title: `${statementConfig.dir.replace("./","")} app`,
            filename: `../index.html`
        }),
        new DashboardPlugin({ port: 4000 }),


    ]};