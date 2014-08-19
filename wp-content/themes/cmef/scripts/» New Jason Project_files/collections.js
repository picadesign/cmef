requirejs.config({
	//By default load any module IDs from js/lib
	baseUrl: cmef_settings.templateURL + '/scripts/',
	//except, if the module ID starts with "app",
	//load it from the js/app directory. paths
	//config is relative to the baseUrl, and
	//never includes a ".js" extension since
	//the paths config could be for a directory.
	paths: {
		//app: '../app'
	},
	urlArgs: "v=" +  (new Date()).getTime()
});

require(['collections/programs'], function(home) {

    //Your script goes here
    //some-dependency.js is fetched.   
    //Then your script is executed
});