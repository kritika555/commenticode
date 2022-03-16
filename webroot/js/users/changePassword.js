$(document).ready(function () {
	$(".data-form").validate({
		rules: {
			current_password: {
				required: true
			},
			password: {
                validPassword: true,
                required: true,
                minlength: 8
			},
			confirm_password: {
				required: true,
				equalTo: "#password"
			}
		},
		messages: {
			email: {
				required: "Please enter your email address.",
				email: "Please enter a valid email address.",
				remote: "Email already in use!"
			},
			confirm_password: {
				required: "Please enter confirm password.",
				equalTo: "Confirm password should be same as password."
			}
		}
	});
});