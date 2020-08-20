// This jQuery file controls the homepage

$(document).ready(function(){
    //var signupShowing, loginShowing;

    //When this button is clicked, the log in content is hidden and the reset content is shown
    $('#login-to-reset' || '#back-to-reset').click(
        function (clickEvent) {
            clickEvent.preventDefault();    //Prevent link from going through

            //Hide the login content
            $('#login-content').css("left", "105%");
            $('#login-content').css("visibility", "hidden");

            //Show the sign up content
            $('#reset-content').css("left", "270px");
            $('#reset-content').css("visibility", "visible");
        }
    );

    //When this button is clicked, the reset content is hidden and the login content is shown
    $('#reset-to-login').click(
        function (clickEvent) {
            clickEvent.preventDefault();    //Prevent link from going through

            //Hide reset content
            $('#reset-content').css("left", "105%");
            $('#reset-content').css("visibility", "hidden");

            //Show log in content
            $('#login-content').css("left", "270px");
            $('#login-content').css("visibility", "visible");
        }
    );

    $('#showCreate').click(
        function () {
            showPassword('create-password');
        }
    );

    $('#showConfirm').click(
        function () {
            showPassword('confirm-password');
        }
    );

    $('#showPass').click(
        function () {
            showPassword('password');
        }
    );

    // This function is for making the entered password visible
// @param element is the current password section we want to make visible
    function showPassword(element) {
        var passedElement = element;
        var inputElement = document.getElementById(passedElement);
        if (inputElement.type === "password") {
            inputElement.type = "text";
        } else {
            inputElement.type = "password";
        }
    }

});