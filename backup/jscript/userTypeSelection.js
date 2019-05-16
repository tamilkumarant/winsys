// project page - validation while add/edit a new project 

	function usertypeselection()
	{
		if (document.getElementById("administrator").selected == true)
		{
			document.getElementById('projectadmin_form').style.display = 'none';
			document.getElementById('normaluser_form').style.display = 'none';
			
		}
		else if (document.getElementById("projectadmin").selected == true)
		{
			document.getElementById('projectadmin_form').style.display = 'block';
			document.getElementById('normaluser_form').style.display = 'none';
			
		}
		
		else if (document.getElementById("normaluser").selected == true)
		{
			document.getElementById('projectadmin_form').style.display = 'none';
			document.getElementById('normaluser_form').style.display = 'block';
			
		}
		
		else if (document.getElementById("maintenanceuser").selected == true)
		{
			document.getElementById('projectadmin_form').style.display = 'none';
			document.getElementById('normaluser_form').style.display = 'none';
			
		}
		
		else if(document.getElementById("select_user_type").selected == true)
		{
			document.getElementById('projectadmin_form').style.display = 'none';
			document.getElementById('normaluser_form').style.display = 'none';
			
		}
		else{
			document.getElementById('normaluser_form').style.display = 'none';
			document.getElementById('normaluser_form').style.display = 'none';
		}
		
	}
