/**
 * Created by chiarafaes on 27/04/17.
 */
$(document).ready(function () {
    $("#btnSubmit").on("click", function (e) {
        //text vak uitlezen
        var bericht = $("#comment").val();

        // via ajax update naar de DB sturen
        $.ajax({
            method: "POST",
            url: "ajax/ajax.saveupdate.php",
            data:{update: bericht}
        })
            .done(function( response ) {
                //code+message
                if (response.code == 200){
                    //iets plaatsen
                    var li = $("<li style='display: none;'>");
                    li.html("<h2>ChiaraFaes</h2>" + response.message);

                    //waar plaatsen
                    $("#listupdates").prepend(li);
                    $("#listupdates li").first().slideDown();
                    $("#comment").val("").focus();
                }
            });

        e.preventDefault();
    })
})