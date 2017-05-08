/**
 * Created by Alex on 4/05/2017.
 */
$(document).ready(function () {
    var container = $('.main_container_profile')

    $('#btn_collections').on('click', function () {
        var postsInCollections = [];

        $.ajax({
            url: 'ajax/ajax.get-posts-in-boards.php',
            method: 'post',
            success: function (value) {
                console.log(value);
            },
            error: function () {
                console.log("shit he");
            }

        })

        $.ajax({
            url: 'ajax/ajax.getboards.php',
            type: 'post',
            data:{
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
                    data:{
                        mode: 'categories'
                    },
                    success: function (value) {
                        console.log('got cats per collection');
                        console.log(value);

                        // de container div leegmaken voordat we terug beginnen vullen
                        container.html("");

                        catsPerCollections = value;

                        function getCats (id) {
                            cats = "";
                            for (var prop in catsPerCollections){
                                if (id == catsPerCollections[prop].board){
                                    cats +='<li>' + catsPerCollections[prop].name + '</li>';
                                }
                            }
                            return cats;
                        }

                        for (var prop in collections){
                            if (collections[prop].private == 1){
                                var check = "checked"
                            } else {
                                check = ""
                            }
                            var collection =    '<div class="collection-container">'+
                                                '<h1 class="collection-title">'+collections[prop].title+'</h1>'+
                                                '<div class="toggleSwitch">'+
                                                '<label>Private</label>'+
                                                '<label class="switch">'+
                                                '<input type="checkbox" name="checkbox" '+ check +' class="private-collection" value="on" onclick="if($(this).val() == &apos;off&apos;){$(this).val(&apos;on&apos;)} else {$(this).val(&apos;off&apos;)}" >'+
                                                '<div class="slider"></div>'+
                                                '</label>'+
                                                '</div>'+
                                                '<div class="posts-container">'+
                                                '</div>'+
                                                '<div class="collection-topics">'+
                                                '<ul>'+
                                                getCats(collections[prop].id) +
                                                '</ul>'+
                                                '</div>'+
                                                '</div>'

                            container.append(collection);
                        }
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
    })
})