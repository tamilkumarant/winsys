// project page - validation while add/edit a new project 

		function fnValidateprojectRegistrationForm(form) {
			
			if (form.projectid.value == "") 
			{
				alert( "Please enter project ID" );
				form.projectid.focus();
				return false ;
			}
			
			if (form.projectname.value == "") 
			{
				alert( "Please enter project name" );
				form.projectname.focus();
				return false ;
			}
			
			else if (form.projectdescription.value == "") 
			{
				alert( "Please enter project description" );
				form.projectdescription.focus();
				return false ;
			} // end else
			
		} // end function fnValidateprojectRegistrationForm()