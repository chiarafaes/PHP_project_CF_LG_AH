/**
 * Created by Alex on 11/05/2017.
 */
$(document).ready(function () {
    $('#url').on('blur', function (e) {
        e.preventDefault();
        var container = $('.rendered-images');
        container.append('<img src="img/spinner.gif">')
        if ($(this).val() != ""){
            var input = $(this).val()
            $.ajax({
                url: 'ajax/ajax.scrape.php',
                method: 'post',
                data: {
                    input: input,
                    mode: 'img'
                },
                success: function (value) {

                    console.log(value);
                    container.html('');

                    for (var prop in value){
                        container.append(value[prop]);
                    }

                    $.ajax({
                        url: 'ajax/ajax.scrape.php',
                        method: 'post',
                        data: {
                            input: input,
                            mode: 'text'
                        },
                        success: function (value) {
                            $('#title').val(value)
                        }
                    })

                    container.children().on('click', function () {
                        container.children().each(function () {
                            this.className = '';
                        });
                        if (this.className != 'selected'){
                            this.className = 'selected'
                        } else {
                            this.className = ''
                        }

                        $('#rendered-url').val(this.src);

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