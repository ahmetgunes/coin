module.exports = function (grunt) {
    return {
        main: {
            files: {
                '<%= dirs.main.dest.jsDir %>main.min.js': ['<%= dirs.main.dest.jsDir %>main.js']
            }
        }
    }
};