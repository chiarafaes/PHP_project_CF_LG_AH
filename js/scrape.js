/**
 * Created by Alex on 11/05/2017.
 */
$(document).ready(function () {
    $('#url').on('blur', function (e) {
        e.preventDefault();
        var container = $('.rendered-images')
        if ($(this).val() != ""){
            var input = $(this).val()

            $.ajax({
                url: 'ajax/ajax.scrape.php',
                method: 'post',
                data: {
                    input: input,
                },
                success: function (value) {
                    value.each(function () {
                        console.log('haha')
                        container.append('kaka');
                    })
                },
                error: function (value) {
                    //var output = value.replace('\\', '')
                    //console.log(output);

                   //console.log(value)
                }
            })
        } else {
            return false;
        }
    })
})