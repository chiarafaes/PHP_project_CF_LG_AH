/**
 * Created by chiarafaes on 11/05/17.
 */

function validateForm() {
    var x = document.forms["Posten"]["title"].value;
    if (x == "") {
        alert("Title must be filled out");
        return false;
    }
}
