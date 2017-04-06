		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
	<!-- <script src="/js/bootstrapValidator.min.js"></script> -->
<!-- FormValidation plugin and the class supports validating Bootstrap form -->
	<script src="/js/formValidation.min.js"></script>
	<script src="/js/framework/bootstrap.min.js"></script>	
	
	
	<script src="/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
	<script src="/js/bootstrap-combobox.js"></script>
	
	
<!-- Testing section -->
<script type="text/javascript">	
$(document).ready(function() {
	<!-- get the selected payment method type -->
	$('#puser').on('change', function(event, params) {
	//    console.log("puser: " +  $("#puser").val())
		$('#paymentForm').formValidation('revalidateField', 'user');
	}); 

/*	$('.combobox').combobox();
	$('.puser').combobox();
	$('.ptype').combobox();
	$('.pmethod').combobox(); */

	
/*
    $('#datePicker')
        .datepicker({
			format: "yyyy/mm/dd",
			calendarWeeks: true
        })
        .on('changeDate', function(e) {
            $('#paymentForm').formValidation('revalidateField', 'date');
        });
	*/
	
	
	<!-- get the selected payment method type -->
//	$('#pmethod').on('change', function(event, params) {
	//    console.log("pmethod: " +  $("#pmethod").val())
//	});  

	<!-- get the selected payment method type -->
//	$('#ptype').on('change', function(event, params) {
	//    console.log("ptype: " +  $("#ptype").val())
//	});  
  
});
</script>

<!-- New Payment validator -->	
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#paymentForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
            puser: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    }
                }
            },
            pamount: {
                validators: {
                   between: {
                        min: 0,
                        max: 10000,
                        message: 'The allowed for amount is between 0 and 10 000'
                    },				
                    notEmpty: {
                        message: 'Required field'
                    }
                }
            },			
			pdate: {
                validators: {
                    notEmpty: {
                        message: 'The date is required'
                    },
					date: {
						format: 'YYYY/MM/DD',
						message: 'The date is not a valid'
                    }
                }
            },
            pmethod: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    }
                }
            },
            ptype: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                }
            },
			pcomment: {
                    validators: {
                        callback: {
                            message: 'Please say why the amount has to be R0.00',
                            callback: function(value, validator, $field) {
                                var channel = $('#paymentForm').find('[name="pamount"]').val();
                                return (channel >= '1') ? true : (value !== '');
                            }
                        }
                    }
                }
        }
		})

//        submitHandler: function(validator, form, submitButton) {
//            form.off('submit.bootstrapValidator').submit();

//        } 

        .on('change', '[name="pamount"]', function(e) {
            $('#paymentForm').formValidation('revalidateField', 'pcomment');
        })
        .on('success.field.fv', function(e, data) {
            if (data.field === 'pcomment') {
                var channel = $('#paymentForm').find('[name="pamount"]').val();
                // User choose given channel
                if (channel >= '1') {
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
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
                //url: $form.attr('action'),
				url: '../../../content/wugms.mancom.create.new.payment.php',
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
				    /*console.log(result);*/
                    /*console.log('yes'); */
					location.reload();
                }
            });
        })

		.find('[name="puser"], [name="pmethod"], [name="ptype"]')
            .combobox()
            .end()
    });
</script>

<!-- Validator for editing -->
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#EditpaymentForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
            euser: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    }
                }
            },
            eamount: {
                validators: {
                   between: {
                        min: 0,
                        max: 10000,
                        message: 'The allowed for amount is between 0 and 10 000'
                    },				
                    notEmpty: {
                        message: 'Required field'
                    }
                }
            },			
			edate: {
                validators: {
                    notEmpty: {
                        message: 'The date is required'
                    },
					date: {
						format: 'YYYY-MM-DD',
						message: 'The date is not a valid'
                    }
                }
            },
            emethod: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    }
                }
            },
            etype: {
                validators: {
                    notEmpty: {
                        message: 'Required field'
                    },
                }
            },
			ecomment: {
                    validators: {
                        callback: {
                            message: 'Please say why the amount has to be R0.00',
                            callback: function(value, validator, $field) {
                                var channel = $('#EditpaymentForm').find('[name="eamount"]').val();
                                return (channel >= '1') ? true : (value !== '');
                            }
                        }
                    }
                }
        }
		})

        .on('change', '[name="eamount"]', function(e) {
            $('#EditpaymentForm').formValidation('revalidateField', 'ecomment');
        })
        .on('success.field.fv', function(e, data) {
            if (data.field === 'ecomment') {
                var channel = $('#EditpaymentForm').find('[name="eamount"]').val();
                // User choose given channel
                if (channel >= '1') {
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
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
                //url: $form.attr('action'),
				url: '../../../content/wugms.mancom.edit.payment.php',
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

		.find('[name="euser"], [name="emethod"], [name="etype"]')
            .combobox()
            .end()
    });
</script>

<!-- Validator for payment delete -->
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#DeletepaymentForm').formValidation({
		framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
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
				url: '../../../content/wugms.mancom.delete.payment.php',
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
				    /*console.log(result);*/
                    /*console.log('yes'); */
					location.reload(); 
                }
            });
        })
    });
</script>

<!-- Date picker check --> 
<script type="text/javascript">
$(document).ready(function() {
    $('#dateRangePicker')
        .datepicker({
			format: "yyyy/mm/dd",
			calendarWeeks: true,
			todayHighlight: true
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#paymentForm').formValidation('revalidateField', 'pdate');
        });
	/* Set teh default date*/
	var todaynow = new Date();
	ftodaynow = todaynow.toLocaleFormat('%Y/%m/%d');
	
	$('#dateRangePicker').datepicker('setValue', ftodaynow);
	$('#dateRangePicker').datepicker('update');
	$('#pdate').val(ftodaynow);

	
    $('#edateRangePicker')
        .datepicker({
			format: "yyyy-mm-dd",
			calendarWeeks: true
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#EditpaymentForm').formValidation('revalidateField', 'edate');
        });
});
</script>

<!-- Edit the payment -->



<!-- Section one -->


<script type="text/javascript">
function actionFormatter(value, row, index) {
    return [
/*		'<button id="editpaymentbtn" type="button" data-toggle="modal" data-target="#EditPaymentModal" class="btn btn-primary edit">Edit</button>',
		'<button id="deletepaymentbtn" type="button" data-toggle="modal" data-target="#DeletePaymentModal" class="btn btn-danger remove">Delete</button>' */
		
		'<div class="btn-group" role="group" aria-label="...">',
			'<button id="editpaymentbtn" type="button" data-toggle="modal" data-target="#EditPaymentModal" class="btn btn-primary edit">Edit</button>',
			'<button id="deletepaymentbtn" type="button" data-toggle="modal" data-target="#DeletePaymentModal" class="btn btn-danger remove">Delete</button>',
		'</div>'
		
    ].join('');
}

window.actionEvents = {
    'click .edit': function (e, value, row, index) {
   //    alert('You click edit icon, row: ' + JSON.stringify(row));
		/* Set vals */	
		$('#euser').val(row.iduser);
		$('#euser').combobox("refresh");
		/*$('#edate').val(row.pdate); */
		/*$('#edateRangePicker').datepicker("setValue", row.pdate ); */
		$('#edateRangePicker').datepicker('setValue', row.pdate);
		$('#edateRangePicker').datepicker('update');
		$('#edate').val(row.pdate);
		/*console.log(row.pdate);*/
		$('#emethod').val(row.payment_method);
		$('#emethod').combobox("refresh");
		$('#etype').val(row.payment_type);
		$('#etype').combobox("refresh");
		$('#eamount').val(row.amount);
		$('#ecomment').val(row.comment);
		
		/*console.log(row); */
		/* set oems*/
		$('#edit_payment_oem_id').val(row.id);
		$('#edit_payment_oem_user_id').val(row.iduser);
		$('#edit_payment_oem_firstName').val(row.firstName);
		$('#edit_payment_oem_lastName').val(row.lastName);
		$('#edit_payment_oem_irc_nick').val(row.irc_nick);
		$('#edit_payment_oem_date').val(row.pdate);
		$('#edit_payment_oem_method').val(row.payment_method);
		$('#edit_payment_oem_type').val(row.payment_type);
		$('#edit_payment_oem_amount').val(row.amount);
		$('#edit_payment_oem_comment').val(row.comment);

    },
    'click .remove': function (e, value, row, index) {
		/* Set vals */	
		$('#duser').val(row.firstName + ' (' + row.irc_nick + ') ' + row.lastName);
		$('#ddate').val(row.pdate);
		$('#dmethod').val(row.payment_method);
		$('#dtype').val(row.payment_type);
		$('#damount').val(row.amount);
		$('#delete_paymentid').val(row.id);
	//	console.log(row.firstName + ' (' + row.irc_nick + ') ' + row.lastName);


    }
};
</script>
</body>
</html>
