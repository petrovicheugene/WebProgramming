(function ($, undefined) {
    $(document).ready(function () {

        let emailInput = $("#email");
        let defaultEmailStr = emailInput.val();
        let defaultColor = emailInput.css('border-top-color');
        let sendButton = $("#my_button");

        // set event handler on email input
        emailInput.on('blur', function () {

            let emailStr = emailInput.val();

            if (!emailStr) {
                // empty email string
                emailInput.css('border', `solid ${defaultColor}  1px`);
                emailInput.val(defaultEmailStr);
            }
            else if (emailStr === defaultEmailStr) {
                // default email
                emailInput.css('border', `solid ${defaultColor}  1px`);
            }
            else if (emailStr.match(/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/)) {
                // valid email
                emailInput.css('border', 'solid #00ff00 1px');
            }
            else {
                // invalid email
                emailInput.css('border', 'solid #ff0000 1px');
            }
        });

        // set event handler on send button
        sendButton.on('click', function () {
            sendButton.on('click', function () { return false; });
        });



    })();

})(jQuery)
