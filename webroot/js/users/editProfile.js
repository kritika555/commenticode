$(document).ready(function () {
    $(".data-form").validate({
        rules: {
            first_name: {
                required: true,
                noSpace: true,
                lettersonly: true
            },
            last_name: {
                required: true,
                noSpace: true,
                lettersonly: true
            },
            ethereum_public_address: {
                validEth: true,
                required: true
            }
        },
        messages: { }
    });
});