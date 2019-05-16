function showFilteredstations(inmappage = true) {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue,type;
    input = document.getElementById('search-text-input');
    filter = input.value.toUpperCase();
    ul = document.getElementById("filterSearchlistleft");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      a = li[i];
      type = a.getAttribute("data-type");
      station_id = a.getAttribute("data-station_id");

      var serach_type = $("input:checkbox[value="+type+"]:checked").val();

      if(serach_type==undefined){
          li[i].style.display = "none";
          if(inmappage){
            try{
              markersArray[[station_id]].setMap(null);
            }catch(e){
            }
          }
      }else{
          txtValue = a.textContent || a.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            try{

              if(inmappage){
                if(markersArray){
                  markersArray[[station_id]].setMap(map);
                }
              }
                
            }catch(e){

            }

          } else {
            li[i].style.display = "none";            
            if(inmappage){
              try{
                markersArray[[station_id]].setMap(null);
              }catch(e){

              }
            }
          }
      }
    }
  }