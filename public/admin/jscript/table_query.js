// table 

        $(function() {
            $("#example1").dataTable({
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false,
				"aaSorting": [],
				"order": [[0, "asc"]]
				
            });
		 });