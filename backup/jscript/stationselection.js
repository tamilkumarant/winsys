// project page - validation while add/edit a new project 



	
	function stationselection()
{
	
	alert("H");
	
	var httpxml;
	try
	{
		// Firefox, Opera 8.0+, Safari
		httpxml=new XMLHttpRequest();
	}
	catch (e)
	{
			// Internet Explorer
		 try
			{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    		}
  			catch (e)
    		{
    			try
				{
					httpxml=new ActiveXObject("Microsoft.XMLHTTP");
				}
    			catch (e)
				{
					alert("Your browser does not support AJAX!");
				return false;
				}
    		}
	}
	function stateck() 
    {
		if(httpxml.readyState==4)
		{
			//alert(httpxml.responseText);
			var myarray = JSON.parse(httpxml.responseText);
			// Remove the options from 2nd dropdown list 
			for(j=document.testform.stationname.options.length-1;j>=0;j--)
			{
				document.testform.stationname.remove(j);
			}
			
			//var selectList = document.createElement("select");
			//selectList.id = "mySelect";
			//stationname.appendChild(selectList);

			var option = document.createElement("option");
			option.value = "";
			//document.testform.stationname.options.add(option);
			
			for (i=0;i<myarray.data.length;i++)
			{
				alert("aa");
				var optn = document.createElement("OPTION");
				optn.text = myarray.data[i].station_name;
				optn.value = myarray.data[i].station_id;  // You can change this to subcategory 
				document.testform.stationname.options.add(optn);
			} 
		}
    }

	// end of function stateck
		//var url="../code_behind/station_list.php";
		var url="../code_behind/station_list.php";
		var project_name=document.getElementById('projectname').value;
		url=url+"?project_name="+project_name;
		alert(url);
		//url=url+"&stID="+Math.random();
		httpxml.onreadystatechange=stateck;
		httpxml.open("GET",url,true);
		httpxml.send(null);
  }
