$(document).ready(function(){
    $("#email").on("keyup", function(){
        var email = $("#email").val();
        $(".usernameFeedback").show();
        // Ajax call: verzenden naar php bestand om query uit te voeren

        $.post(
            {
                url:"ajax/ajax.checkmail.php",
                method:"post",
                data:{
                    email: email
                }
            }).done(function( response ){
                $('.usernameFeedback span').text(response.message);
                console.log("test1");

                if(response.status === 'error') {
                    $('#createAccount').prop('disabled', true);
                    console.log("test2");
                } else {
                    $('#createAccount').prop('disabled', false);
                    console.log("test3");
                }
            });
    });

});