jQuery(document).ready(function() {
    jQuery('#postdetails').DataTable({
        dom: 'Bfrtip',
		iDisplayLength: -1,
		paging: false,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
	} );