module.exports = function(grunt) {

	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		jshint: {
			options: {
				curly: true,
				smarttabs: true
			},
			all: {
				src: 'app/js/*.js'
			}
		},

		watch: {
			gruntfile: {
				files: 'Gruntfile.js',
				tasks: ['default']
			},

			less: {
				files: ['app/less/**'],
				tasks: ['styles']
			},

			javascript: {
				files: ['app/js/**'],
				tasks: ['javascript']
			}
		},

		less: {
			bootstrap: {
				options: {
					paths: ['bower_components/bootstrap/less']
				},
				files: {
					'compiled/css/bootstrap.css': 'bower_components/bootstrap/less/bootstrap.less'
				}
			},
			site: {
				files: {
					'compiled/css/site.css': 'app/less/site.less'
				}
			}
		},

		copy: {
			bootstrap: {
				files: [
					{
						expand: true,
						cwd: 'bower_components/bootstrap',
						src: [
							'img/**',
							'fonts/**'
						],
						dest: 'compiled'
					}
				]
			},
			line: {
				files: [
					{
						expand: true,
						cwd: 'app/less/line',
						src: [
							'line.png',
							'line@2x.png'
						],
						dest: 'compiled/css'
					}
				]
			},
			jquery_img: {
				files: [
					{
						expand: true,
						cwd: 'bower_components/jquery-ui/themes/vader/images',
						src: [
							'*',
						],
						dest: 'compiled/css/images'
					}
				]
			},
			trumbowyg: {
				files: [
					{
						expand: true,
						cwd: 'app/less/images',
						src: [
							'*',
						],
						dest: 'compiled/css/images'
					}
				]
			},
			fontawesome: {
				files: [
					{
						expand: true,
						cwd: 'bower_components/font-awesome',
						src: [
							'fonts/**'
						],
						dest: 'compiled'
					}
				]
			}
		},

		concat: {
			siteCss: {
				src: [
					'compiled/css/bootstrap.css',
					'compiled/css/site.css'
				],
				dest: 'compiled/css/site.css'
			},

			essentialJs: {
				src: [
					'bower_components/jquery/dist/jquery.js',
					'bower_components/jquery-ui/jquery-ui.js',
					'bower_components/bootstrap/js/transition.js',
					'bower_components/moment/min/moment.min.js',
					'bower_components/bootstrap/js/dropdown.js',
					'bower_components/bootstrap/js/collapse.js',
					'bower_components/bootstrap/js/alert.js',
					'bower_components/bootstrap/js/tab.js',
					'bower_components/bootstrap/js/modal.js',
					'bower_components/bootstrap/js/tooltip.js',
					'bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
					'bower_components/seiyria-bootstrap-slider/js/bootstrap-slider.js',
					'bower_components/frosty/src/js/frosty.js',
					'app/js/Chart.min.js',
					'app/js/trumbowyg.min.js',
					'app/js/snowstorm.js'
				],
				dest: 'compiled/js/essential.js'
			},

			siteJs: {
				src: [
					'app/js/icheck.min.js',
					//'bower_components/waypoints/lib/jquery.waypoints.min.js',
					'app/js/colpick.js',
					'app/js/sweet-alert.min.js',
					'app/js/bootbox.min.js',
					'app/js/bootstrap-select.js',
                    'app/js/halloween-bats.js',
					'app/js/site.js'
				],
				dest: 'compiled/js/site.js'
			}
		},

		cssmin: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n',
				keepSpecialComments: 0
			},

			siteCss: {
				src: ['<%= concat.siteCss.dest %>'],
				dest: '<%= concat.siteCss.dest %>'
			}
		},

		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n',
				compress: {}
			},

			siteJs: {
				src: ['<%= concat.siteJs.dest %>'],
				dest: '<%= concat.siteJs.dest %>'
			},

			essentialJs: {
				src: ['<%= concat.essentialJs.dest %>'],
				dest: '<%= concat.essentialJs.dest %>'
			},
		}

	});


  	grunt.loadNpmTasks('grunt-contrib-clean');
  	grunt.loadNpmTasks('grunt-contrib-concat');
  	grunt.loadNpmTasks('grunt-contrib-copy');
  	grunt.loadNpmTasks('grunt-contrib-cssmin');
  	grunt.loadNpmTasks('grunt-contrib-jshint');
  	grunt.loadNpmTasks('grunt-contrib-less');
  	grunt.loadNpmTasks('grunt-contrib-uglify');
  	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('styles', ['less', 'copy', 'concat:siteCss']);
	grunt.registerTask('javascript', ['concat:siteJs', 'concat:essentialJs']);

	grunt.registerTask('default', ['styles', 'javascript']);
	grunt.registerTask('dist', ['styles', 'javascript', 'cssmin', 'uglify']);

};
