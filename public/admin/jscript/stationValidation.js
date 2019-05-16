// project page - validation while add/edit a new project 

		function fnValidatestationRegistrationForm(form) {
			
			if (form.stationid.value == "") 
			{
				alert( "Please enter station ID" );
				form.stationid.focus();
				return false ;
			}
			
			if (form.stationname.value == "") 
			{
				alert( "Please enter station name" );
				form.stationname.focus();
				return false ;
			}
			
			if (form.stationLatitude.value == "") 
			{
				alert( "Please enter station latitude" );
				form.stationLatitude.focus();
				return false ;
				
			}
			
			else if (form.stationLongitude.value == "") 
			{
				alert( "Please enter station longitude" );
				form.stationLongitude.focus();
				return false ;
			} // end else
			
		} // end function fnValidateprojectRegistrationForm()