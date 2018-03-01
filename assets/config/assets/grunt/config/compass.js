module.exports = function () {
    return {
        main: {
            options: {
                cacheDir: '<%= dirs.globals.vendor.index %>/<%= dirs.globals.vendor.cacheDir %>',
                relativeAssets: true,
                sassDir: '<%= dirs.main.src.cssDir %>',
                cssDir: '<%= dirs.main.temp.cssDir %>',
                imagesDir: '<%= dirs.main.src.imagesDir %>',
                generatedImagesDir: '<%= dirs.main.temp.imagesDir %>',
                javascriptsDir: '<%= dirs.main.src.jsDir %>',
                javascriptsPath: '<%= dirs.main.temp.jsDir %>',
                fontsDir: '<%= dirs.main.src.fontsDir %>',
                fontsPath: '<%= dirs.main.src.fontsPath %>',
                httpPath: 'assets/main',
                httpImagesPath: '/' + this.httpPath + '/',
                outputStyle: 'nested'
            }
        }
    }
};