		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<script src="/js/bootstrap-combobox.js"></script>
		<script src="/js/formValidation.min.js"></script>
		<script src="/js/framework/bootstrap.min.js"></script>	
		
		
		<script language="javascript" type="text/javascript">
			<!-- Actions for sites -->
			function actionFormatter(value, row, index) {
				return [
					'<div class="btn-group" role="group" aria-label="...">',
						'<button id="editsitebtn" type="button" data-toggle="modal" data-target="#EditRBModal" class="btn btn-primary btn-sm edit">Edit</button>',
						'<button id="reassignsitebtn" type="button" data-toggle="modal" data-target="#ReAssignRBModal" class="btn btn-success btn-sm reassign">Reassign</button>',
					'</div>'
				].join('');
			}
			
			<!-- Reset the edit form -->
			$('#EditRBModal').on('hidden.bs.modal', function() {
				$('#EditrbForm').formValidation('resetForm', true);
			});
			
			<!-- Reset the reassign form -->
			$('#ReAssignRBModal').on('hidden.bs.modal', function() {
				$('#ReAssignrbForm').formValidation('resetForm', true);
			});

			<!-- Set "defaults" depending on what was clicked -->
			window.actionEvents = {
				'click .edit': function (e, value, row, index) {
					/* Set vals */
					<!-- console.log('You click edit icon, row: ' + JSON.stringify(row)); -->

					$('#edit_serial_number').val(row.Serial_Number);
					$('#edit_identity').val(row.RB_identity);					
					$('#edit_rb_longitude').val(row.rb_long);
					$('#edit_rb_latitude').val(row.rb_lat);
					$('#edit_rb_height').val(row.rb_height); 

					$('#edit_rb_use_site_coords').val(row.isUseSiteinfo);
					
					$('#edit_rb_sitename').val(row.siteID);
					$('#edit_rb_sitename').combobox("refresh");
					
					$('#edit_rb_owner').val(row.rb_owner);
					$('#edit_rb_owner').combobox("refresh"); 
					/* Set the options  */
					if (row.isUseSiteinfo == '1') {
						<!-- console.log('manual'); -->
						document.getElementById('rb_coords').style.display = 'block';
						$("#edit_use_site_info").text("Using manual co-ords"); 
						$("#edit_use_site_info").attr('class', 'btn btn-warning');
					} else {
						<!-- console.log('site'); -->
						document.getElementById('rb_coords').style.display = 'none';
						$("#edit_use_site_info").attr('class', 'btn btn-info');
						$("#edit_use_site_info").text("Use site's information for co-ords"); 
					}					
				},
				'click .reassign': function (e, value, row, index) {
					/* Set vals */	
					<!-- console.log('You click edit icon, row: ' + JSON.stringify(row)); -->
					
					$('#reassign_serial_number').val(row.Serial_Number);
					$('#reassign_identity').val(row.RB_identity);
					
					$('#reassign_oem_rb_owner').val(row.rb_owner_name);
					$('#reassign_rb_owner').val(row.rb_owner);
					$('#reassign_rb_owner').combobox("refresh"); 
					$('#reassign_oem_site_owner_id').val(row.rb_owner);
					
					$('#ReAssignrbForm').formValidation('revalidateField', 'reassign_rb_owner');

				}
			};
		</script>
		

<!-- Edit site details -->
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#EditrbForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
            edit_rb_longitude: {
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
            edit_rb_latitude: {
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
            edit_rb_height: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                    between: {
                        min: 1,
                        max: 100,
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
				url: '../../../../content/wugms.admin.edit.rb.header.php',
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
					location.reload(); 
                },
				error: function(xhr, status, error) {
					var err = eval("(" + xhr.responseText + ")");
					console.log(err.Message);
				}
            });
        })
		
		.on('click', 'button[data-toggle]', function() {
            var $target = $($(this).attr('data-toggle'));
			//console.log('test');
            $target.toggle();
            if (!$target.is(':visible')) {
				//console.log(':visible');
                // Enable the submit buttons in case additional fields are not valid
                $('#EditrbForm').data('formValidation').disableSubmitButtons(false);
				$("#edit_use_site_info").attr('class', 'btn btn-info');
				$("#edit_use_site_info").text("Use site's information for co-ords"); 
				$('#edit_rb_use_site_coords').val("2");
            } else {
				$("#edit_use_site_info").text("Using manual co-ords"); 
				$("#edit_use_site_info").attr('class', 'btn btn-warning');
				$('#edit_rb_use_site_coords').val("1");
			}
        })

		.find('[name="edit_rb_sitename"],[name="edit_rb_owner"]')
            .combobox()
            .end()
    });
</script>

<!-- Reassign site -->		
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#ReAssignrbForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
            confirmreassign: {
					validators: {
						choice: {
							min: 1,
							max: 1,
							message: 'In order to reassign this site, you need to confirm'
						}
					}
            },
			reassign_rb_owner: {
                    validators: {
                        notEmpty: {
                            message: 'A new site owner is required'
                        },
						different: {
							field: 'reassign_oem_site_owner_id',
							message: 'The new site owner and old site owner can not be the same.'
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
				url: '../../../../content/wugms.admin.reassign.rb.php',
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
				    console.log(result); 
					location.reload(); 
                },
				error: function(xhr, status, error) {
					var err = eval("(" + xhr.responseText + ")");
					console.log(err.Message);
				}
            });
        })

		.find('[name="reassign_site_name"],[name="reassign_rb_owner"]')
            .combobox()
            .end()
    });
</script>		
		
	</body>
</html>