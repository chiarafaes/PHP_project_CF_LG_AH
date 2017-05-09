/**
 * Created by Alex on 26/04/2017.
 */

$(document).ready(function ()
{
    var container = $('.main_container_profile');

    $('#create-board').on('click', function() {

        var topics = [];
        $('.topicInput').each(function () {

            if ($(this).val() == "on") {
                topics.push($(this).attr('id'))
            }

        });

        var name = $("#board-name").val();
        var private = $('#private').val();

        console.log(typeof private);

        $.ajax({
                url: 'ajax/ajax.createboard.php',
                type: 'post',
                data: {
                    'name': name,
                    'private': private,
                    'topics': topics
                },
                complete: function (value) {
                    console.log(value);
                    $('#add_form').hide();
                    $('div.popup_additem').hide();

                    var postsInCollections = [];

                    $.ajax({
                        url: 'ajax/ajax.get-posts-in-boards.php',
                        method: 'post',
                        success: function (value) {
                            postsInCollections = value;
                        },
                        error: function () {
                            console.log("shit he");
                        }

                    })

                    $.ajax({
                        url: 'ajax/ajax.getboards.php',
                        type: 'post',
                        data: {
                            mode: 'collections'
                        },
                        success: function (value) {
                            console.log('got collections');
                            console.log(value);

                            var collections = value;
                            var catsPerCollections = [];

                            $.ajax({
                                url: 'ajax/ajax.getboards.php',
                                type: 'post',
                                data: {
                                    mode: 'categories'
                                },
                                success: function (value) {
                                    console.log('got cats per collection');
                                    console.log(value);

                                    // de container div leegmaken voordat we terug beginnen vullen
                                    container.html("");

                                    catsPerCollections = value;
                                    console.log(postsInCollections);

                                    function getCats(id) {
                                        cats = "";
                                        for (var prop in catsPerCollections) {
                                            if (id == catsPerCollections[prop].board) {
                                                cats += '<li>' + catsPerCollections[prop].name + '</li>';
                                            }
                                        }
                                        return cats;
                                    }

                                    for (var prop in collections) {
                                        if (collections[prop].private == 1) {
                                            var check = "checked"
                                        } else {
                                            check = ""
                                        }
                                        var collection = '<div class="collection-container" id="collection-' + collections[prop].id + '">' +
                                            '<div class="collection-header">' +
                                            '<div class="posts-container">' +
                                            '<h1 class="collection-title">' + collections[prop].title + '</h1>' +
                                            '</div>' +
                                            '<div>' +
                                            '<div class="toggleSwitch">' +
                                            '<label>Private</label>' +
                                            '<label class="switch">' +
                                            '<input type="checkbox" name="checkbox" ' + check + ' class="private-collection" value="on" onclick="if($(this).val() == &apos;off&apos;){$(this).val(&apos;on&apos;)} else {$(this).val(&apos;off&apos;)}" >' +
                                            '<div class="slider"></div>' +
                                            '</label>' +
                                            '</div>' +
                                            '<div class="collection-topics">' +
                                            '<ul>' +
                                            getCats(collections[prop].id) +
                                            '</ul>' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>'

                                        container.append(collection);
                                    }

                                    for (var prop in postsInCollections) {
                                        var post = '<div class="pin" id="pinID-' + postsInCollections[prop].id + '">' +
                                            '<div class="img_holder">' +
                                            '<div class="buttons" id="1">' +
                                            '<a href="#" class="btn send">Send</a>' +
                                            '<a href="#" class="btn save">Save</a>' +
                                            '</div>' +
                                            '<a class="image ajax" href="#" title="photo 1" id="1">' +
                                            '<img src="' + postsInCollections[prop].picture + '" alt="" >' +
                                            '</a>' +
                                            '</div>' +
                                            '<p class="description">' + postsInCollections[prop].description + '</p>' +
                                            '<p class="likes"><span>' + postsInCollections[prop].likes + '</span></p>' +
                                            '<p class="postdate"<span>' + getTimeAgo(value.postdate) + 'd ago</span></p>' +
                                            '<hr>' +
                                            '<div class="user_info">' +
                                            '<img src="' + postsInCollections[prop].avatar + '" alt="#">' +
                                            '<p>' + postsInCollections[prop].username + '</p>' +
                                            '<p class="categorie">Categorie</p>' +
                                            '</div>' +
                                            '</div>';

                                        $('#collection-' + postsInCollections[prop].board + ' .posts-container').append(post);
                                    }

                                    var counter = parseInt($('.collection_collections p').text())
                                    $('.collection_collections p').text(counter + 1);
                                },
                                error: function () {
                                    console.log('could not get cats per collection');
                                }
                            })
                        },
                        error: function () {
                            console.log('could not get collections');
                        }

                    })
                },
                error: function (data) {
                    $('#add_form').hide();
                    $('div.popup_additem').hide();

                }
            })
    });
})