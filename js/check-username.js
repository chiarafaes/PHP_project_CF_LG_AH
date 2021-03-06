/**
 * Created by chiarafaes on 8/05/17.
 */

$(document).ready(function()
{
    // AJAX CHECK USERNAME AVAILIBILITY
    $("#username").on("keyup", function(e)
    {
        // GET USERNAME VALUE
        var username = $("#username").val();
        $(".usernameFeedback").show();
        document.getElementById('update').disabled = true;
        $('#update').removeClass().addClass('disabled');

        $.ajax({
            method: "POST",
            url: "ajax/ajax.checkusername.php",
            data: {username: username}
        }).done(function( response ){

            $('.usernameFeedback').text(response.message);

            if( response.status === 'success' ) {
                $('#username').css('color', '#4BAE4F');
                $('.usernameFeedback').css('color', '#4BAE4F');
                $("input[type=submit]").removeAttr("disabled");
                document.getElementById('update').disabled = false;
                $('#update').removeClass().addClass('enabled');
                console.log("succes");


            } else if(response.status === 'error' ) {
                $('#username').css('color', '#dd6b47');
                $('.usernameFeedback').css('color', '#D22E2E');
                console.log("error");
                document.getElementById('update').disabled = true;
                $('#update').removeClass().addClass('disabled');

            } else {
                $('#username').css('color', '#000');
                $('.usernameFeedback').hide();
                $("input[type=submit]").attr("disabled", "disabled");
                document.getElementById('update').disabled = true;
                $('#update').removeClass().addClass('disabled');
            }

            $("input[type=submit]").removeAttr("disabled");
        });
        e.preventDefault();
    })
})