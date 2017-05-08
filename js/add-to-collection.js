/**
 * Created by Alex on 7/05/2017.
 */
$(document).ready(function () {

    $('.likeable' +
        '' +
        '').on('click', '.save' ,function (e) {
            e.preventDefault();

            $('#save_to_collection').fadeIn();
            $('#save_to_collection_content').css('visibility', 'visible');
    });

    $('#save').on('click',function (e) {
        e.preventDefault();
        var id = $(this).siblings('input').attr('checked').val()

        console.log(id)

        $.ajax({
            url: 'ajax/ajax.save-to-board.php',
            method: 'post',
            data:{'id': id},
            success: function (value) {

            },
            error: function (value) {

            }
        })

    });

    $('.overlay').on('click',function (e) {
        e.preventDefault();
        $('#save_to_collection').fadeOut();
        $('#save_to_collection_content').css('visibility', 'hidden');
    })

})