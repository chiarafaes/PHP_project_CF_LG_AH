/**
 * Created by Alex on 11/05/2017.
 */
$(document).ready(function () {
    $('#url').on('blur', function (e) {
        e.preventDefault();
        var container = $('.rendered-images');
        container.append('<img src="img/spinner.gif">')
        if ($(this).val() != ""){
            if ($(this).val().match(/http:\/\/|https:\/\//) == null){
                // als de string geen echte url is
                $('#error-post').text('This is not a valid URL').fadeIn('fast')
                container.html('');
                $(this).css('border', '1.5px solid firebrick')

            } else {
                $('#error-post').text('').fadeOut('fast')
                $(this).css('border', 'inherit')
                var input = $(this).val()
                $.ajax({
                    url: 'ajax/ajax.scrape.php',
                    method: 'post',
                    data: {
                        input: input,
                        mode: 'img'
                    },
                    success: function (value) {
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
                                $('#title').val($.trim(value));
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
                        $('#error-post').text('Could not get scraping data from this URL.').fadeIn('fast')
                        container.html('');
                        $(this).css('border', '1px solid firebrick')
                    }
                })
            }

        } else {
            $('#error-post').text('').fadeOut('fast')
            $(this).css('border', '1.5px solid #b3b3b3')
            container.html('');
            return false;
        }
    })
})