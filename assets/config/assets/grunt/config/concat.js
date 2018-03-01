module.exports = function () {
    return {
        options: {
            separator: '\n'
        },
        mainJS: {
            src: [
                __dirname + '/../../vendor/jquery/dist/jquery.min.js',
                __dirname + '/../../vendor/bootstrap/dist/js/bootstrap.min.js'
            ],
            dest: 'temp/main/js/main.js',
            nonull: true
        },
        mpCSS: {
            src: [
                __dirname + '/../../vendor/bootstrap/dist/css/bootstrap.min.css',
                __dirname + '/../../src/main/css/base.css'
            ],
            dest: 'temp/main/css/main.css',
            nonull: true
        }
    }
};