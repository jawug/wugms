		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<!-- Section one : -->
		<script src="/js/formValidation.min.js"></script>
		<script src="/js/framework/bootstrap.min.js"></script>	
	<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#UpdateDetailsForm').formValidation({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        excluded: ':disabled',
        fields: {
            edit_name: {
                validators: {
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The full name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            edit_surname: {
                validators: {
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The full name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            edit_ircnick: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    stringLength: {
                        min: 3,
                        max: 20,
                        message: 'The IRC Nick must be more than 3 characters and less than 20 characters.'
                    },
                    regexp: {
                        regexp: /^[A-Za-z0-9_]+$/,
                        message: 'The IRCnick can consist of alphabetical characters, 0..9 and "_"'
                    },
                    remote: {
                        message: 'The IRC Nick has already been used by someone else',
                        url: '/content/wugms.reg.remote.validate.php',
                        data: {
                            type: 'edit_ircnick',
                            edit_ircnick_oem: $('#edit_ircnick').val()
                        },
                        type: 'POST'
                    }
                }
            },
            edit_username: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    },
                    remote: {
                        message: 'The email address is used by another user.',
                        url: '/content/wugms.reg.remote.validate.php',
                        data: {
                            type: 'edit_email',
                            edit_username_oem: $('#edit_username').val()
                        },
                        type: 'POST'
                    }
                }
            },
            edit_verifyusername: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    identical: {
                        field: 'edit_username',
                        message: 'Email does not match'
                    }
                }
            },
            edit_phonenum: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    regexp: {
                        regexp: /^\+27?[\d]{2}?[\d]{3}?[\d]{4}$/,
                        message: 'The phone number format is +27000000000'
                    }
                }
            },
            edit_dob: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The value is not a valid date'
                    }
                }
            },
            currentacc: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'Old password is required'
                    }
/*                    stringLength: {
                        min: 6,
                        max: 20,
                        message: 'The password must be more than 6 characters and less than 20 characters'
                    },
                    regexp: {
                        regexp: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$/,
                        message: 'The Password must include at least one upper case letter, one lower case letter, and one numeric digit.'
                    }*/
                }
            },
            newpw: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    stringLength: {
                        min: 6,
                        max: 20,
                        message: 'The password must be more than 6 characters and less than 20 characters'
                    },
                    regexp: {
                        regexp: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$/,
                        message: 'The Password must include at least one upper case letter, one lower case letter, and one numeric digit.'
                    }
                }
            },
            verpw: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    identical: {
                        field: 'newpw',
                        message: 'Password does not match'
                    }
                }
            }
        }
    })

    // Enable the password/confirm password validators if the password is not empty
//    .on('keyup', '[name="currentacc"]', function() {
//        var isEmpty = $(this).val() == '';
//        $('#UpdateDetailsForm')
//            .formValidation('enableFieldValidators', 'currentacc', !isEmpty);
//    })
    // Enable the password/confirm password validators if the password is not empty
    .on('keyup', '[name="newpw"]', function() {
        var isEmpty = $(this).val() == '';
        $('#UpdateDetailsForm')
            .formValidation('enableFieldValidators', 'currentacc', !isEmpty)
			.formValidation('enableFieldValidators', 'newpw', !isEmpty)
            .formValidation('enableFieldValidators', 'verpw', !isEmpty);

        // Revalidate the field when user start typing in the password field
        if ($(this).val().length == 1) {
            $('#UpdateDetailsForm').formValidation('validateField', 'newpw')
                .formValidation('validateField', 'verpw');
          $('#UpdateDetailsForm').formValidation('validateField', 'newpw')
                .formValidation('validateField', 'currentacc');				
        }
    })

    .on('success.form.fv', function(e) {
        // Prevent form submission
        e.preventDefault();

        var $form = $(e.target),
            fv = $form.data('formValidation');

        // Use Ajax to submit form data
        $.ajax({
			url: '../../../../content/wugms.user.edit.profile.php',
			type: 'POST',
            data: $form.serialize(),
            success: function(result) {
                location.reload();
            }
        });
    })

});
</script>
	
	</body>
</html>