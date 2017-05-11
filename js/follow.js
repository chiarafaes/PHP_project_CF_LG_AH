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

                    if (response.action == 'Follow') {
                        $("#btnFollow").val('Follow');
                        $("#btnFollow").attr('class', 'follow');
                        $("#btnFollow").attr('data-action', 'follow');

                        $this.toggleClass('follow');
                        if($this.hasClass('follow')){
                            $this.text('Follow');
                        } else {
                            $this.text('Following');
                        }

                    } else {
                        console.log('Error');

                    }
                }
            });
        e.preventDefault();
    });
})


