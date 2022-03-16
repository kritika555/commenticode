$(document).ready(function () {
    $("#register").validate({
        rules: {
            username: {
                required: true,
                remote: siteUrl+'Users/checkUsername',
                noSpace: true
            },
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
            email: {
                required: true,
                email: true,
                remote: siteUrl+'Users/checkEmail'
            },
            ethereum_public_address: {
                validEth: true,
                required: true
            },
            confirm_email: {
                required: true,
                email: true,
                equalTo: "#email"
            },
            password: {
                validPassword: true,
                required: true,
                minlength: 8
            },
            confirm_password: {
                equalTo: "#password"
            }
        },
        messages: {
            ethereum_public_address: {
                required: "Please enter the ethereum address."
            },
            username: {
                required: "Please enter the username.",
                remote: "Username already in use!",
                nowhitespace: "Please enter"
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: "Email already in use!"
            },
            confirm_email: {
                required: "Please enter confirm email address.",
                email: "Please enter a valid email address.",
                equalTo: "Confirm email should match with email."
            },
            password: {
                required: "Please enter your password."
            },
            confirm_password: {
                required: "Please enter confirm password.",
                equalTo: "Confirm password should match with password."
            }
        }
    });
});