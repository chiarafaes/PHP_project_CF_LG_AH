/**
 * Created by chiarafaes on 4/05/17.
 */

$(document).ready(function () {
    // $(document).change(function () {
    $('.inappropriate').on('click',function (e) {
        e.preventDefault();
        var id = $(this).parent().parent().parent().attr('id').substr(6);
        var inapr = $(this).parent().parent().siblings('.inapr').text();
        $.ajax({
            url: 'ajax/ajax.markinginappropriote.php',
            type: 'post',
            data:
                {
                    'post': id,
                    'inapr': inapr
                },
            success: function (data) {
                $('#pinID-'+id).find('.inapr > span').text(data);
                if($('#pinID-'+id).find('.inapr > img').attr('src') != 'img/icon_inapp_act.svg'){
                    $('#pinID-'+id).find('.inapr > img').attr('src', 'img/icon_inapp_act.svg');
                } else {
                    $('#pinID-'+id).find('.inapr > img').attr('src', 'img/icon_inapp.svg.svg');
                }

            },
            error: function () {
                alert('ERROR')
            }
        })
    })
    // })
});