module.exports = function(grunt) {

  grunt.initConfig({
    compass: {                  
      dist: {                   
        options: {              
          sassDir: 'src/scss',
          cssDir: 'dist/css',
        }
      },
    },
    watch: {
      files: '**/*.scss',
      tasks: ['compass'],
    },
    php: {
      dist: {
        options: {
          port: 8000,
          keepalive: true,
          open: true,
          base: 'dist'
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-php');

  grunt.registerTask('default', ['compass','watch']);

};
