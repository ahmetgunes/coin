module.exports = function(grunt) {
    grunt.registerTask('default', ['clean', 'compass', 'concat', 'copy', 'uglify', 'cssmin']);
};