module.exports = function(grunt) {
  grunt.initConfig({

    watch: {
      options: {
        livereload: true
      },

      scss: {
        files: '**/*.scss',
        tasks: ['compass']
      },

      js: {
        files: '**/*.js',
        tasks: [],
      },

      html: {
        files: '**/*.html',
        tasks: [],
      }
    },

    smushit: {
      dist: {
        src: '**/'
      }
    },

    compass: {
      dist: {
        options: {
          config: 'config.rb',
          noLineComments: true,
          force: true
        }
      }
    },

    csscss: {
      options: {
        verbose: true,
        minMatch: 5
      },

      dist: {
        src: ['assets/css/*.css']
      }
    }
  });

  grunt.loadNpmTasks('grunt-smushit');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-csscss');
  grunt.loadNpmTasks('grunt-uncss');

  grunt.registerTask('default', ['compass']);
  grunt.registerTask('testcss', ['csscss']);
};
