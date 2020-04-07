statementConfig = {
    //own app name
    name: 'bloggenerator',
    configurationFolder : "./configuration",
    rewrite: true
};
statementConfig.dir = `./${statementConfig.name}`;
statementConfig.publicPath = statementConfig.dir.replace(".","");
module.exports = statementConfig;