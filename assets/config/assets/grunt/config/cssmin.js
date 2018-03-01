module.exports = function (grunt) {
    return {
        options: {
            specialComments: 'all'
        },
        main: {
            files: {
                '<%= dirs.main.dest.cssDir %>main.min.css': ['<%= dirs.main.dest.cssDir %>main.css']
            }
        }
    }
};