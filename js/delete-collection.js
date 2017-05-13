/**
 * Created by Alex on 12/05/2017.
 */
$(document).ready(function () {
    $('#main-container').on('click','.delete-collection', function (e) {
        e.preventDefault();
        var id = $(this).parent().parent().parent().attr('id').substr(11);

        $.ajax({
            url: 'ajax/ajax.delete-collection.php',
            method: 'post',
            data:{
                id : id
            },
            success: function (value) {
                console.log(value);
            },
            error: function (value) {
                console.log(value);
            }
        })
    })
})