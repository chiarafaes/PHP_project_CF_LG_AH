
$(document).ready(function()
{
    // AJAX CHECK USERNAME AVAILIBILITY
    $("#email").on("keyup", function(e)
    {
        // GET USERNAME VALUE
        var email = $("#email").val();
        $(".usernameFeedback").show();

        $.post("ajax/ajax.checkmail.php", {email: email}).done(function( response )
        {

            $('.usernameFeedback').text(response.message);

            if( response.status === 'success' ) {
                $('#email').css('color', '#4BAE4F');
                $('.usernameFeedback').css('color', '#4BAE4F');
                $("input[type=submit]").removeAttr("disabled");
                console.log("succes");


            } else if(response.status === 'error' ) {
                $('#email').css('color', '#D22E2E');
                $('.usernameFeedback').css('color', '#D22E2E');
                console.log("error");

            } else {
                $('#email').css('color', '#000');
                $('.usernameFeedback').hide();
                $("input[type=submit]").attr("disabled", "disabled");
            }

            $("input[type=submit]").removeAttr("disabled");
        });
        e.preventDefault();
    })
})