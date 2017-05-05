/**
 * Created by chiarafaes on 4/05/17.
 */

$(document).ready(function () {

    var bericht = $(".inappropriate");
    var report = $(".btnReport");

        report.on('click', function (e) {

            console.log(this.getAttribute("data-id"));
            var id = this.getAttribute("data-id");

            $.ajax(
                {
                    url:"ajax/ajax.markinappropriote.php",
                    method:"post",
                    data:{
                        "id": id
                    }
                }).done(function(response){
                    console.log(response);
                    bericht.innerText= "dit is gerapporteerd!";
            })
            e.preventDefault();

        });
});