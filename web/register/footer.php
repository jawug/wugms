		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
	<script src="/js/bootstrapValidator.min.js"></script> 

	<script id="reg_val" language="javascript" type="text/javascript">
		$('#regcv').bootstrapValidator({
			feedbackIcons: {
		        valid: 'glyphicon glyphicon-ok',
		        invalid: 'glyphicon glyphicon-remove',
		        validating: 'glyphicon glyphicon-refresh'
		    },
		    fields: {
		        ircnick: {
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
								type: 'ircnick'
								},
							type: 'POST'
						}
					}
		        },
		        firstName: {
		            validators: {
		                notEmpty: {
		                    message: 'Required field'
		                },
		                stringLength: {
		                    min: 1,
		                    max: 20,
		                    message: 'The full name must be less than 20 characters'
		                }
		            }
		        },
		        lastName: {
		            validators: {
		                notEmpty: {
		                    message: 'Required field'
		                },
		                stringLength: {
		                    min: 1,
		                    max: 20,
		                    message: 'The last name must be less than 20 characters'
		                }
		            }
		        },
		        password: {
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
		        verifypassword: {
		            validators: {
		                notEmpty: {
		                    message: 'Required field'
		                },
		                identical: {
		                    field: 'password',
		                    message: 'Password does not match'
		                }
		            }
		        },
		        email: {
		            validators: {
		                notEmpty: {
		                    message: 'Required field'
		                },
		                emailAddress: {
		                    message: 'The input is not a valid email address'
		                },
						remote: {
							message: 'The email address is not available',
							url: '/content/wugms.reg.remote.validate.php',
							data: {
								type: 'email'
								},
							type: 'POST'
						}
		            }
		        },
		        verifyemail: {
		            validators: {
		                notEmpty: {
		                    message: 'Required field'
		                },
		                identical: {
		                    field: 'email',
		                    message: 'Email does not match'
		                }
		            }
		        },
				dob: {
					validators: {
						date: {
							format: 'YYYY/MM/DD',
							message: 'The value is not a valid date'
						},
						notEmpty: {
		                    message: 'Required field'
		                }
					}
				},
		        phone: {
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
				tandc: {
					validators: {
						choice: {
							min: 1,
							max: 1,
							message: 'Please agree to the terms and conditions'
						}
					}
				},
		    },


//		.on('success.form.bv', function(e) {
//			e.preventDefault();
//			var $form = $(e.target),
//			validator = $form.data('bootstrapValidator');
//			$form.find('.alert').html('Thanks for signing up. Now you can sign in as ' + validator.getFieldElements('username').val()).show();
//		});

submitHandler: function(validator, form, submitButton) {
   // ... do your task ...
   form.off('submit.bootstrapValidator').submit();

}

		});
//		    submitHandler: function(validator, form, submitButton) {
		        //var form = new FormData($('#regcv')[0]);
//		        $.ajax({
//		            url: '../register/newuser.php',
//		            type: 'POST',
//		            xhr: function() {
//		                var myXhr = $.ajaxSettings.xhr();
//		                if (myXhr.upload) {
//		                    myXhr.upload.addEventListener('progress', progress, false);
//		                }
//		                return myXhr;
//		            },
//		            success: function(res) {
//		                $('#content_here_please').html(res);
//		            },
//		            error: function(request, error) {
//		                alert(" Can't do because: " + error);
//		            },
//		            data: form,
//		            cache: false,
//		            contentType: false,
//		            processData: false
//		        });
//		    } 
//		});
	</script>	
	
	
	</body>
</html>
