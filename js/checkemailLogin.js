$(document).ready(function()
{
    // AJAX CHECK USERNAME AVAILIBILITY
    $("#email").on("keyup", function(e)
    {
        // GET USERNAME VALUE
        var email = $("#email").val();
        $(".mailFeedback").show();

        $.ajax({
            method: "POST",
            url: "ajax/ajax.checkmailLogin.php",
            data: {email: email}
        }).done(function( response ){

            $('.mailFeedback').text(response.message);

            if( response.status === 'success' ) {
                $('#email').css('color', '#D22E2E');
                $('.mailFeedback').css('color', '#D22E2E');
                console.log("succes");


            } else if(response.status === 'error' ) {
                $('#email').css('color', '#4BAE4F');
                $('.mailFeedback').css('color', '#4BAE4F');
                $("input[type=submit]").removeAttr("disabled");

                console.log("error");

            } else {
                $('#email').css('color', '#000');
                $('.mailFeedback').hide();
                $("input[type=submit]").attr("disabled", "disabled");
            }

            $("input[type=submit]").removeAttr("disabled");
        });
        e.preventDefault();
    })
})