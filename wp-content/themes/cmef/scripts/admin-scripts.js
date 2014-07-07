jQuery(function ($) {
	$('#download-csv').click(function(){
		window.open('../temp_csv_files/exported-csv-'+ $_POST['filename'] +'.csv');

		$.post($_POST['bloginfoURL'] + '/wp-admin/admin-ajax.php', {
        	//the function in ajax.php, pass the data through.
        	action: 'delete_exported_csv',
        	file: 'temp_csv_files/exported-csv-'+ $_POST['filename'] +'.csv'
        }, function(response){
        	console.log('file_deleted');
        })
	})


});