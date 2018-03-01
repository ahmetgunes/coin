module.exports = function(grunt) {
    return {
        options: {
            force: true
        },

        'temp': ['<%= dirs.main.temp.index %>/**'],
        'asset': ['<%= dirs.main.dest.index %>/**'],
    };
};