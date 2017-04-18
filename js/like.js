/**
 * Created by Alex on 17/04/2017.
 */
$(document).ready(function () {
    // $(document).change(function () {
        $('.main_container' +
            '' +
            '').on('click', '.like' ,function (e) {
            e.preventDefault();
            var id = $(this).parent().parent().parent().attr('id').substr(6)
            $.ajax({
                url: 'ajax/ajax.like.php',
                type: 'post',
                data: { 'post': id },
                success: function (data) {
                    console.log('yup')
                    if($('#pinID-'+id).find('.like > img').attr('src') != 'img/liked_icon.svg'){
                        $('#pinID-'+id).find('.like > img').attr('src', 'img/liked_icon.svg');
                    } else {
                        $('#pinID-'+id).find('.like > img').attr('src', 'img/like_icon.svg');
                    }

                },
                error: function () {
                    alert('ERROR')
                }
            })
        })
   // })
})