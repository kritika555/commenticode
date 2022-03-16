CommonFunctions = {

    nl2br : function(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
    },
    scrollToTopOfForm: function(selector){
        $('html,body').animate({
                scrollTop: $(selector).offset().top},
            'slow');
    },
    _parseFloat: function(number){
        if(number == ''){
            return 0;
        }else if(isNaN(number)){
            return number;
        }else{
            return parseFloat(number);
        }
    },
    _parseInt: function(number){
        if(isNaN(number)){
            return number;
        }else{
            return parseInt(number);
        }
    },

    sortSelect: function (select, attr, order) {
        if(attr === 'text'){
			$(select).each(function(){
				if(order === 'asc'){
					$(this).html($(this).children('option').sort(function (x, y) {
						return $(x).text().toUpperCase() < $(y).text().toUpperCase() ? -1 : 1;
					}));
					$(this).get(0).selectedIndex = 0;
				}// end asc
				if(order === 'desc'){
					$(this).html($(this).children('option').sort(function (y, x) {
						return $(x).text().toUpperCase() < $(y).text().toUpperCase() ? -1 : 1;
					}));
					$(this).get(0).selectedIndex = 0;
				}// end desc
			});
        }
	},

    /**
     * Checks if the given string is an address
     *
     * @method isAddress
     * @param {String} address the given HEX adress
     * @return {Boolean}
     */
    isAddress: function (address) {
        address = address.toLowerCase();
        if (!/^(0x)?[0-9a-f]{40}$/i.test(address)) {
            // check if it has the basic requirements of an address
            return false;
        } else if (/^(0x)?[0-9a-f]{40}$/.test(address) || /^(0x)?[0-9A-F]{40}$/.test(address)) {
            // If it's all small caps or all all caps, return true
            return true;
        } else {
            // Otherwise check each case
            return this.isChecksumAddress(address);
        }
    },

    /**
     * Checks if the given string is a checksummed address
     *
     * @method isChecksumAddress
     * @param {String} address the given HEX adress
     * @return {Boolean}
     */
    isChecksumAddress: function (address) {
        // Check each case
        address = address.replace('0x','');
        var addressHash = sha3(address.toLowerCase());
        for (var i = 0; i < 40; i++ ) {
            // the nth letter should be uppercase if the nth digit of casemap is 1
            if ((parseInt(addressHash[i], 16) > 7 && address[i].toUpperCase() !== address[i]) || (parseInt(addressHash[i], 16) <= 7 && address[i].toLowerCase() !== address[i])) {
                return false;
            }
        }
        return true;
    }

}

Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

$.validator.addMethod("greaterThan",
    function(value, element, params) {
    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val())
        || (Number(value) > Number($(params).val()));
    },
'Must be greater than {0}.');

$.validator.addMethod("validEth",
    function(value, element, params) {
        return CommonFunctions.isAddress(value)
    },
    'Enter a valid ethereum address.');

$.validator.addMethod("ethDecimal",
    function(value, element, params) {
        return /^\d{0,50}(\.\d{0,18})?$/.test(value)
    },
    'Max 18 decimal values are allowed.');

$.validator.addMethod("noSpace", function(value, element) {
    return !value.indexOf(" ") == 0;
}, "Space not allowed.");

$.validator.addMethod("validPassword", function(value, element) {
   return /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/i.test(value)
}, "Minimum 8 characters with least 1 alphabet, 1 number and 1 special character.");


$.validator.addMethod('positiveNumber',
    function (value) {
        return Number(value) > 0;
}, 'Enter a positive number.');

$.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please");


function showLoader(){
    HoldOn.open({
        theme:'sk-circle',
        message:"<h4>Processing, please wait...</h4>"
    });
}
function hideLoader(themeName){
    HoldOn.close();
}

function showVoteAlert(msg){
    $('#jsVoteContent').html(msg);
    $('#voteModal').modal("show");
}

function clearPic(){	
	
	$('input[name=profile_photo').val('');
		$('#thumbnil').prop('src', null);	
}	

function changePic(){
	alert("Please preview and Save Change to change the picture.");
	var fileInput = $('#changed_pic').val();
    $('#test').modal("hide");	
}	


function showMyImage(fileInput) {
		var files = fileInput.files;

        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img=document.getElementById("thumbnil");    
				
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
        }
		    //$('#final_preview').show();
			includeImage(fileInput);
    }
	
function includeImage(fileInput) {
        var files = fileInput.files;
		
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img=document.getElementById("pp_image");    
				
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
        }    
    }

	
function myFunction() {
 // var x = document.getElementById("overlay");
  //if (x.style.display === "none") {
   // $('#overlay').fadeIn(300); 
  //} else {
        //x.style.display = "none";
		$('#cross').click(function() {
			$('input[name=profile_photo').val('');
			$('#thumbnil').prop('src', null);
			
		});
		
         $('#clear').click(function() {
     		$('input[name=profile_photo').val('');
			$('#thumbnil').prop('src', null);
		 });
		
		$('#confirm').click(function() {
			//$('#overlay').fadeOut(300);			
		 });  
}

function clearf(){
	
	alert("here");
	/*$('input[name=profile_photo').val('');
		$('#thumbnil').prop('src', null);*/
		$('#final_preview').show();
			includeImage(fileInput);
	 
	
}	

const initializeTooltips = function() {
  $('[data-toggle="tooltip"]').each(function() {
    $(this).tooltip({
      container: $(this).parent()
    });
  });
};
$(document).ready(function() {
  initializeTooltips();
});



