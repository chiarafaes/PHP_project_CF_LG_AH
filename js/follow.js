$(document).ready(function () {
    $("#btnFollow").on("click", function (e) {

        var userMail = $(this).attr("data-id");
        var action = $(this).attr("data-action");// follow of niet?

        var $this  = $(this);

        $.ajax({
            method: "POST",
            url: "ajax/ajax.follow.php",
            data: {userMail:userMail, action:action}
        })
            .done(function(response){

                if(response.status == 'success') {
                    console.log('Success');

                    if (response.action == 'follow') {
                        $("#btnFollow").attr('data-action', 'unfollow');
                        $this.text('Unfollow');

                    } else if (response.action == 'unfollow'){
                        $("#btnFollow").attr('data-action', 'follow');
                        $this.text('Follow');

                    } else{
                        console.log('Error');
                    }
                }
            });
        e.preventDefault();
    });
})


