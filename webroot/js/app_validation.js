validationRule = {
    setValidationRule: function(){
        $.validator.addClassRules({
            email: {
                required: true,
                email: true
            },
            zip: {
                digits: true,
                minlength: 5,
                maxlength: 5
            },
            decimal: {
                number: true,
                min: 0
            },
            negative_decimal: {
                number: true
            },
            digit: {
                digits: true
            },
            require: {
                required: true
            }
        });

        $.validator.addMethod("js_check_assets_total", function(value, element) {
            var res = true;
            var total =  parseInt($('#total_assets').val());
            if(parseInt(value) > total){
                res = false;
            }
            return  res;
        }, 'Entered value should not exceed total assets.');

        $.validator.addMethod("jsCheckTotalAssetsNegativeValue", function(value, element) {
            var res = true;
            if(parseInt(value) < 0){
                res = false;
            }
            return  res;
        }, 'Looks like you need to add more assets or go back to step one and reexamine the value of your current home.');

        $.validator.addMethod("jsOtherAssets", function(value, element) {
            var res = true;
            var otherAssets =  parseInt($('#other_assets').val());
            if(otherAssets > 0 && value ==''){
                res = false;
            }
            return  res;
        }, 'This field is required.');

       /* $.validator.addMethod("js_validate_number", function(value, element) {
            var num_len = $(element).data('num_len');
            var point_len = $(element).data('point_len');
        }, 'js_validate_number.');*/

        $.validator.addMethod("validate_length", function(value, element, params) {
            var params = params.split(',');
            var val = value.split('.');

            if(val[0].length > params[0] || (typeof val[1] != 'undefined' && val[1].length > params[1])){
                return false;
            }else{
                return true;
            }
        }, function(params, element) {
            var params = params.split(',');
            return 'Please enter no more than ' + params[0] + ' numbers and ' + params[1] + ' decimal points.'
        });

    }
};
