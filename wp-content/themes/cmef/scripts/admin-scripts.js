jQuery(function ($) {

        /**
        * This little script will shoot an ajax request back to the server to delete the file.
        */
        
	$('#download-csv').click(function(){
		window.open('../temp_csv_files/exported-csv-'+ $_POST['filename'] +'.csv');

		$.post($_POST['bloginfoURL'] + '/wp-admin/admin-ajax.php', {
                	//the function in ajax.php, pass the data through.
                	action: 'delete_exported_csv',
                	file: 'temp_csv_files/exported-csv-'+ $_POST['filename'] +'.csv'
                }, function(){
                	console.log('file_deleted');
                })
	});

        /** 
        * In the admin we have a contribution amount checkbox/radio. 
        * We need to remove the radio checked property of the radio buttons when we focus on the input field below. 
        * Because one wil override the other.
        */

        $('input[name="other-payment-amount"]').focus(function(){
                console.log('focused');
                $('input[name="payment-amount"]').prop('checked', false);
        })
});