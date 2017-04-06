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
<!-- Actions for sites -->
			function actionFormatter(value, row, index) {
				return [
					'<div class="btn-group" role="group" aria-label="...">',
					'<button id="editsitebtn" type="button" data-toggle="modal" data-target="#EditSiteModal" class="btn btn-primary edit">Edit</button>',
					'<button id="deletesitebtn" type="button" data-toggle="modal" data-target="#DeleteSiteModal" class="btn btn-danger remove">Delete</button>',
					'</div>'
				].join('');
			}
			
			<!-- I think I set a value with this -->
			function GetSite_NameOEM() {
				return $('#edit_site_name_oem').val();
			} 
			
			<!-- Reset the edit form -->
			$('#EditSiteModal').on('hidden.bs.modal', function() {
				$('#EditsiteForm').formValidation('resetForm', true);
			});
			
			<!-- Set "defaults" depending on what was clicked -->
			window.actionEvents = {
				'click .edit': function (e, value, row, index) {
					/* Set vals */
					<!-- console.log('You click edit icon, row: ' + JSON.stringify(row)); -->
					$('#edit_siteid').val(row.siteID);
					$('#edit_site_name_oem').val(row.Name);
					$('#edit_site_name').val(row.Name);
					$('#edit_longitude').val(row.longitude);
					$('#edit_latitude').val(row.latitude);
					$('#edit_height').val(row.height);
					$('#edit_suburb').val(row.suburb);
					$('#edit_suburb').combobox("refresh");
					
					
					/* Set temp var for site name */
					var VAL = row.Name;
					/* Set the regex that looks for thing */
					var sitnam = /^\([A-Z]{2,3}\)+.*?$/; 
					/* Do the test and then set the required items */
					if (sitnam.test(VAL)) {
						/* console.log('using new method'); */ 
						regexbrak   = /^(\([A-Z]{1,3}\))?[A-Za-z0-9]+$/
						message   = 'The sitename can consist of alphabetical characters "a..z" and/or "0..9". Also "(" and ")" are allowed like this (SCU)Scully';
					} else {
						/* console.log('old school'); */
						regexbrak   = /^[A-Za-z0-9]+$/
						message   = 'The sitename can consist of alphabetical characters "a..z" and/or "0..9"';
					}
					/* Update options */
					$('#EditsiteForm').formValidation('updateOption', 'edit_site_name', 'regexp', 'regexp', regexbrak)
					/* Update message */
					$('#EditsiteForm').formValidation('updateMessage', 'edit_site_name', 'regexp', message)
					/* You might need to revalidate field */
					$('#EditsiteForm').formValidation('revalidateField', 'edit_site_name');
				},
				'click .remove': function (e, value, row, index) {
					/* Set vals */	
					<!-- console.log('You click edit icon, row: ' + JSON.stringify(row)); -->
					$('#delete_site_name').val(row.Name);
					$('#delete_suburb').val(row.suburb);
					$('#delete_longitude').val(row.longitude);
					$('#delete_latitude').val(row.latitude);
					$('#delete_height').val(row.height);
					
					$('#delete_siteid').val(row.siteID);
					$('#delete_site_name').val(row.Name);

				}
			};
		</script>			

<!-- New site validation -->
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$('#siteForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
            site_name: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    stringLength: {
                        min: 3,
                        max: 20,
                        message: 'The site name must be more than 3 characters and less than 20 characters.'
                    },
                    regexp: {
                        regexp: /^[A-Za-z0-9]+$/,
                        message: 'The sitename can consist of alphabetical characters "a..z" and/or "0..9"'
                    },
                    remote: {
                        message: 'The site name has already been used by you',
                        url: '../../../content/wugms.new.site.remote.validate.php',
                        data: {
                            type: 'name_of_site'
                        },
                        type: 'POST'
                    }
                }
            },
            longitude: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: 16,
                        max: 33,
                        message: 'The longitude must be between 16.0 and 33.0'
                    }
                }
            },
            latitude: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: -35,
                        max: -22,
                        message: 'The latitude must be between -35.0 and -22.0'
                    }
                }
            },
            height: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: 1,
                        max: 20,
                        message: 'The latitude must be between 1 and 20'
                    }
                }
            },
        } 
		})
		
		.on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
				url: '../../../content/wugms.user.create.new.site.php',
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
					location.reload();
                }
            });
        })

		.find('[name="suburb"]')
            .combobox()
            .end()
    });
</script>

<!-- Edit site details -->
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#EditsiteForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
            edit_site_name: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    stringLength: {
                        min: 3,
                        max: 20,
                        message: 'The site name must be more than 3 characters and less than 20 characters.'
                    },
                    regexp: {
                        regexp: /^[A-Za-z0-9]+$/,
                        message: 'The sitename can consist of alphabetical characters "a..z" and/or "0..9"'
                    },
                    remote: {
                        message: 'The site name has already been used by you',
                        url: '../../../content/wugms.edit.site.remote.validate.php',
                        data: {
                            type: 'edit_name_of_site',
							oem_name: GetSite_NameOEM
                        },
                        type: 'POST'
                    }
                }
            },
            edit_longitude: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: 16,
                        max: 33,
                        message: 'The longitude must be between 16.0 and 33.0'
                    }
                }
            },
            edit_latitude: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: -35,
                        max: -22,
                        message: 'The latitude must be between -35.0 and -22.0'
                    }
                }
            },
            edit_height: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: 1,
                        max: 20,
                        message: 'The latitude must be between 1 and 20'
                    }
                }
            },
        } 
        })
		
		.on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
                //url: $form.attr('action'),
				url: '../../../content/wugms.user.edit.site.php',
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
				    /*console.log(result); */
                    /*console.log('yes'); */
					location.reload(); 
                },
				error: function(xhr, status, error) {
					var err = eval("(" + xhr.responseText + ")");
					console.log(err.Message);
				}
            });
        })
/*
        .on('input keyup', '[name="edit_site_name"]', function() {
			var VAL = $('#edit_site_name_oem').val();

			<!--var sitnam = /^\([A-Z]{2,3}\)+$/; -->
			var sitnam = /^\([A-Z]{2,3}\)+.*?$/; 

			if (sitnam.test(VAL)) {
				 console.log('using new method'); 
				regexbrak   = /^(\([A-Z]{1,3}\))?[A-Za-z0-9]+$/
                message   = 'The sitename can consist of alphabetical characters "a..z" and/or "0..9". Also "(" and ")" are allowed like this (SCU)Scully';
			} else {
				 console.log('old school'); 
				regexbrak   = /^[A-Za-z0-9]+$/
                message   = 'The sitename can consist of alphabetical characters "a..z" and/or "0..9"';
			}
			
		$('#EditsiteForm')
                // Update options
                .formValidation('updateOption', 'edit_site_name', 'regexp', 'regexp', regexbrak)

                // Update message
                .formValidation('updateMessage', 'edit_site_name', 'regexp', message)

                // You might need to revalidate field
                .formValidation('revalidateField', 'edit_site_name');
		}) */
		
		
		.find('[name="edit_suburb"]')
            .combobox()
            .end()
    });
</script>

<!-- Delte site -->
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#DeletesiteForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
            confirmdelete: {
					validators: {
						choice: {
							min: 1,
							max: 1,
							message: 'In order to delete, you need to tick the box'
						}
					}
            }
        }
        })
		
		.on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
                //url: $form.attr('action'),
				url: '../../../content/wugms.user.delete.site.php',
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
				    /*console.log(result); */
                    /*console.log('yes'); */
					location.reload(); 
                },
				error: function(xhr, status, error) {
					var err = eval("(" + xhr.responseText + ")");
					console.log(err.Message);
				}
            });
        })		
    });
</script>



</body>
</html>
