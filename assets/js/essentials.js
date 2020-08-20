// This jQuery file contains essential functions

$(document).ready(function(){

    // Search the income table on keyup
    $("#search-income").on("keyup", function() {
        var value = $(this).val().toLowerCase();        //Get the entered value to lower

        //check the table body for the entered text
        $("#income-table-body tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)  //Hide all unmatches
        });
    });

    // Search the expenses table on keyup
    $("#search-expenses").on("keyup", function() {
        var value = $(this).val().toLowerCase();        //Get the entered value to lower

        //check the table body for the entered text
        $("#expenses-table-body tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)  //Hide all unmatches
        });
    });

    $(".page-item").children("a").addClass("page-link");

    $('#account-color').on("click", function() {
        alert("Hi");
        //$('#label-color').css("background", color);
    });

    $("#account-color").mousedown(function(){
      alert("Mouse down over p1!");
    });

    //When the delete link is clicked, confirm delete
    $('#delete').click(
      function(clickEvent){
          clickEvent.preventDefault();    //Prevent link from going through

          var answer = confirm("Are you really sure you want to delete this entry?");

          if(answer == true) {
            //var del = "<? php echo $del; ?>";
            window.location.replace(del);
          }
      }
    );
});