module.exports =  function() {
    "use strict";

    var dirs = {
        globals: {
            src: {
                index: './src'
            },
            temp: {
                index: './temp'
            },
            dest: {
                index: './../../../public/'
            },
            vendor: { //components files
                index: './vendor',
                cacheDir: '/.sass-cache/'
            }
        },
        main: {
            src: { //source files
                index: '/main',
                cssDir: '/sass/',
                imagesDir: '/images/',
                jsDir: '/javascripts/'
            },
            temp: { //temporary files
                index: '/main',
                cssDir: '/css/',
                imagesDir: '/images/',
                jsDir: '/js/'
            },
            dest: { //destination files
                index: '/main',
                cssDir: '/css/',
                imagesDir: '/images/',
                jsDir: '/js/'
            }
        }
    };

    var globals = dirs['globals'];

    delete dirs['globals'];

    for(var dirKey in dirs) {
        if(dirs.hasOwnProperty(dirKey)) {
            var dir = dirs[dirKey];

            for(var destinationKey in dir) {
                if(dir.hasOwnProperty(destinationKey)) {
                    var destinationObject = dir[destinationKey];
                    var fullPath = "";
                    var indexPath = "";

                    if(globals[destinationKey]) {
                        fullPath = globals[destinationKey]['index'];
                    }

                    for(var type in destinationObject) {
                        if(destinationObject.hasOwnProperty(type)) {
                            var location = destinationObject[type];

                            if(destinationKey === 'dest') {
                                indexPath = globals[destinationKey]['index'] + '/' + dirKey;
                            }

                            if(type === 'index') {
                                dirs[dirKey][destinationKey][type] = indexPath = fullPath + location;
                            }
                            else {
                                if(indexPath !== "") {
                                    dirs[dirKey][destinationKey][type] = indexPath + location;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    dirs['globals'] = globals;

    return dirs;
};