module.exports = function () {
    var config = {
        main: {
            expand: true,
            cwd: '<%= dirs.main.temp.index %>',
            src: ['**', '!**/base.js'],
            dest: '<%= dirs.main.dest.index %>/',
            filter: 'isFile'
        }
    };

    for (var item in config) {

        if (config.hasOwnProperty(item)) {

            var files = config[item];
            console.log(files);
            if (Array.isArray(files['dest'])) {

                var i = 0;

                for (var dest in files['dest']) {

                    if (files['dest'].hasOwnProperty(dest)) {

                        var path = files['dest'][dest];
                        var tempKey = item + '_' + i;

                        config[tempKey] = JSON.parse(JSON.stringify(config[item]));
                        config[tempKey]['dest'] = path;

                        i++;
                    }
                }

                delete config[item];
            }
        }
    }

    return config;
};