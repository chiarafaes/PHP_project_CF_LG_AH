/**
 * Created by Alex on 11/05/2017.
 */
$(document).ready(function () {
    $('#url').on('blur', function (e) {
        e.preventDefault();
        console.log('init')
        if ($(this).val() != ""){
            var input = $(this).val()

            $.ajax({
                url: 'ajax/ajax.scrape.php',
                method: 'post',
                data: {
                    input: input,
                },
                success: function (value) {
                    //var output = value.replace('\\', '')
                    //console.log(output);

                    console.log(value)
                },
                error: function (value) {
                    //var output = value.replace('\\', '')
                    //console.log(output);

                   console.log(value)
                }
            })
        } else {
            return false;
        }
    })
})