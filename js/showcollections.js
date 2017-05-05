/**
 * Created by Alex on 4/05/2017.
 */
$(document).ready(function () {
    $('#btn_collections').on('click', function () {
        console.log('dikke lul')
        $.ajax({
            url: 'ajax/ajax.getboards.php',
            type: 'post',
            success: function (value) {
                // doe iets
            },
            error: function () {
                console.log('error');
            }
        })
    })
})