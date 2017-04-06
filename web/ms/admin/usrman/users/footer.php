		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<!-- <script src="/js/bootstrapValidator.min.js"></script> -->
		<!-- FormValidation plugin and the class supports validating Bootstrap form -->
		<script src="/js/formValidation.min.js"></script>
		<script src="/js/framework/bootstrap.min.js"></script>	

		<script src="/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
		<script src="/js/bootstrap-combobox.js"></script>
	
		<!-- So that we can get nice numbers in the "#" field -->
		<script language="javascript" type="text/javascript">
			function actionFormatter(value, row, index) {
				return [
					'<div class="btn-group" role="group" aria-label="...">',
						'<button id="edituserbtn" type="button" data-toggle="modal" data-target="#EditUserModal" class="btn btn-primary btn-sm edit">Edit</button>',
					'</div>'
				].join('');
			}
			
			/* checkboxes */
			$('#readonlylevel').click(function () {
				if ($(this).is(':checked')) {
					$('#readonlylevel_val').val(true);
				} else {
					$('#readonlylevel_val').val(false);
				}
				})
				
			$('#adminlevel').click(function () {
				if ($(this).is(':checked')) {
					$('#adminlevel_val').val(true);
				} else {
					$('#adminlevel_val').val(false);
				}
				})

			$('#betalevel').click(function () {
				if ($(this).is(':checked')) {
					$('#betalevel_val').val(true);
				} else {
					$('#betalevel_val').val(false);
				}
				})				
			
			$('#dateRangePicker')
				.datepicker({
					format: "yyyy/mm/dd",
					calendarWeeks: true,
					todayHighlight: true
				});
				
			$('#editdateRangePicker')
				.datepicker({
					format: "yyyy/mm/dd",
					calendarWeeks: true,
					todayHighlight: true
				});		
		
			/* Set teh default date*/
			/*var todaynow = new Date();
			ftodaynow = todaynow.toLocaleFormat('%Y/%m/%d'); */
	
			$('#dateRangePicker').datepicker('setValue', new Date());
			$('#dateRangePicker').datepicker('update');
			
			<!-- I think I set a value with this -->
			function GetircnickOEM() {
				return $('#edit_user_oem_irc_nick').val();
			} 

			function GetemailOEM() {
				return $('#edit_user_oem_email').val();
			} 
			
			$('#EditUserModal').on('hidden.bs.modal', function() {
				$('#EditUserForm').formValidation('resetForm', true);
			});

			window.actionEvents = {
				'click .edit': function (e, value, row, index) {
					/* Set vals */
					//console.log('You click edit icon, row: ' + JSON.stringify(row));
					$('#editfirstName').val(row.firstName);
					$('#editlastName').val(row.lastName);
					$('#editircnick').val(row.irc_nick);
					$('#edit_user_oem_irc_nick').val(row.irc_nick);
					
					$('#editphone').val(row.phone_num);
/*					$('#editgender').val(row.siteID);*/
					$('#editmaxsites').val(row.max_sites);
					$('#editemail').val(row.username);
					$('#editverifyemail').val(row.username);
					$('#edit_user_oem_email').val(row.username);
					$('#edit_user_oem_user_id').val(row.user_id);
					$('#editaccstatus').val(row.acc_status);
					$('#editaccstatus').combobox("refresh");
					$('#editdateRangePicker').datepicker('setValue', row.dob);
					$('#editdateRangePicker').datepicker('update'); 
					$('#editdob').val(row.dob);
					/* User roles */
					/* "roles":"admin,mancom,user" */
					var list = row.roles;
					
					var acl = new Array();
					acl = list.split(",");
					
					if(jQuery.inArray("user", acl)>=0) {
						$("#userlevel").prop("checked", true);
					} else {
						$("#userlevel").prop("checked", false);
					}
						
					if(jQuery.inArray("readonly", acl)>=0) {
						$("#readonlylevel").prop("checked", true);
						$('#readonlylevel_val').val(true);
					} else {
						$("#readonlylevel").prop("checked", false);
						$('#readonlylevel_val').val(false);
					}						
					
					if(jQuery.inArray("admin", acl)>=0) {
						$("#adminlevel").prop("checked", true);
						$('#adminlevel_val').val(true);
					} else {
						$("#adminlevel").prop("checked", false);
						$('#adminlevel_val').val(false);
					}					

					if(jQuery.inArray("mancom", acl)>=0) {
						$("#mancomlevel").prop("checked", true);
					} else {
						$("#mancomlevel").prop("checked", false);
					}

					if(jQuery.inArray("beta", acl)>=0) {
						$("#betalevel").prop("checked", true);
						$('#betalevel_val').val(true);
					} else {
						$("#betalevel").prop("checked", false);
						$('#betalevel_val').val(false);
					}
				}
			};
			
	
		</script>

<!-- New User validator -->	

<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#userForm').formValidation({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        excluded: ':disabled',
        fields: {
            firstName: {
                validators: {
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The full name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            lastName: {
                validators: {
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The full name can consist of alphabetical characters and spaces only'
                    }
                }
            },
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
            email: {
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
            }
        }
    })



    .on('success.form.fv', function(e) {
        // Prevent form submission
        e.preventDefault();

        var $form = $(e.target),
            fv = $form.data('formValidation');

        // Use Ajax to submit form data
        $.ajax({
            //url: $form.attr('action'),
            url: '../../../../content/wugms.admin.create.new.user.php',
            type: 'POST',
            data: $form.serialize(),
            success: function(result) {
                location.reload();
            }
        });
    }) 
/*
	.find('[name="editacc_stavtus"]')
		.combobox()
		.end() */
});
</script>  

<!-- Validator for editing -->

<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#EditUserForm').formValidation({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        excluded: ':disabled',
        fields: {
            editfirstName: {
                validators: {
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The full name can consist of alphabetical characters only'
                    },
                    notEmpty: {
                        message: 'Required field'
                    },
					stringLength: {
                        min: 1,
                        max: 20,
                        message: 'The first name must be more than 1 characters and less than 20 characters.'
                    }
                }
            },
            editlastName: {
                validators: {
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The full name can consist of alphabetical characters only'
                    },
                    notEmpty: {
                        message: 'Required field'
                    },
					stringLength: {
                        min: 1,
                        max: 20,
                        message: 'The last name must be more than 1 characters and less than 20 characters.'
                    }
                }
            },
            editircnick: {
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
                        url: '/content/wugms.admin.reg.remote.ircnick.validate.php',
                        data: {
							oem_ircnick: GetircnickOEM
                        },
                        type: 'POST'
                    }
                }
            },
            editemail: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    },
                    remote: {
                        message: 'The email address is used by another user.',
                        url: '/content/wugms.admin.reg.remote.email.validate.php',
                        data: {
							oem_email: GetemailOEM
                        },
                        type: 'POST'
                    }
                }
            },
            editverifyemail: {
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
            editphone: {
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
            editmaxsites: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: 1,
                        max: 100,
                        message: 'The value must be between 1 and 100'
                    }
                }
            },
			editcomment: {
                    validators: {
                        callback: {
                            message: 'Please indicate as to why the account is disabled/banned',
                            callback: function(value, validator, $field) {
                                var channel = $('#EditUserForm').find('[name="editaccstatus"]').val();
                                 return (channel == 'active' || channel == 'lostpassword') ? true : (value !== '');
                            }
                        }
                    }
                }
        }
    })

        .on('change', '[name="editaccstatus"]', function(e) {
            $('#EditUserForm').formValidation('revalidateField', 'editcomment');
        })
        .on('success.field.fv', function(e, data) {
            if (data.field === 'editcomment') {
                var channel = $('#EditUserForm').find('[name="editaccstatus"]').val();
                // User choose given channel
                if (channel == 'active' || channel == 'lostpassword')  {
                    // Remove the success class from the container
                    data.element.closest('.form-group').removeClass('has-success');

                    // Hide the tick icon
                    data.element.data('fv.icon').hide();
                }
            }
        })

    .on('success.form.fv', function(e) {
        // Prevent form submission
        e.preventDefault();

        var $form = $(e.target),
            fv = $form.data('formValidation');

        // Use Ajax to submit form data
        $.ajax({
            //url: $form.attr('action'),
            url: '../../../../content/wugms.admin.edit.user.php',
            type: 'POST',
            data: $form.serialize(),
            success: function(result) {
                location.reload();
            }
        });
    }) 
	
	.find('[name="editaccstatus"]')
		.combobox()
		.end()  
});
</script>

</body>
</html>
