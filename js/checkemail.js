/**
 * Created by chiarafaes on 4/05/17.
 */
$(document).ready(function(){

    $("#email").on("keyup", function(){


        var email = $("#email").val();

        $.ajax({
            method: "POST",
            url: "ajax/ajax.checkemail.php",
            data: { email: email }
        })
            .done(function( response ){
                $("#errors").text(response.message);
                if(response.message == "Username available!"){
                    $("#createaccount").prop("disabled", false).removeClass("dis");
                }else{
                    $("#createaccount").prop("disabled", true).addClass("dis");
                }
            });

    });

});