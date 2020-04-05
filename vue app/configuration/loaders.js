const statementConfig = require("./stmconfig.js");
module.exports = {
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'

            },
            {
                test: [/\.js$/],
                exclude: [/node_modules/],
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                        plugins: ['@babel/plugin-proposal-class-properties',
                              '@babel/plugin-proposal-throw-expressions'
                        ]
                    }
                }
            },

            {
                test: /\.pug$/,
                oneOf: [
                    // this applies to `<template lang="pug">` in Vue components
                    {
                        resourceQuery: /^\?vue/,
                        use: ['pug-plain-loader']
                    },
                    // this applies to pug imports inside JavaScript
                    {
                        use: ['pug-loader','raw-loader', 'pug-plain-loader']
                    }
                ]
            },
            {
                test: /\.(png|jpeg|ttf|jpg)$/,
                use: [{loader: 'url-loader', options: {limit: 10000}}]
            },
            {
                test: /\.s[ac]ss$/i,
                //by webpack kompilowal css i scss musza byc uzyte te 2 loadery scss i css
                use: ['style-loader','vue-style-loader', 'css-loader', 'sass-loader']
            }]
    }
}
