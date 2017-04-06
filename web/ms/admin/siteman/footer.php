
<?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
<script src="/js/formValidation.min.js"></script>
<script src="/js/framework/bootstrap.min.js"></script>	
<script src="/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/js/bootstrap-combobox.js"></script> 

<!-- So that we can get nice numbers in the "#" field -->
<script language="javascript" type="text/javascript">
    /* Actions for sites */
    function actionFormatter(value, row, index) {
        return [
            '<div class="btn-group" role="group" aria-label="...">',
            '<button id="editsitebtn" type="button" data -toggle="modal" data-t ar get="#EditSiteModal"  class="btn btn-primary btn-sm edit">Edit</button>',
            '<button id="reassignsitebtn" type="button" data-toggle="modal" data-target="#ReAssignSiteModal" class="btn btn-success btn-sm reassign">Re-Assign</button>',
            '<button id="deletesitebtn" type="button" data-toggle="modal" data-target="#DeleteSiteModal" class="btn btn-danger btn-sm remove">Delete</button>',
            '</div>'
        ].join('');
    }
    /* Reset the edit form */
    $('#EditSiteModal').on('hidden.bs.modal', function () {
        $('#EditsiteForm').formValidation('resetForm', true);
    });

    /* I think I set a value with this */
    function GetSite_NameOEM() {
        return $('#edit_site_name_oem').val();
    }

    /* Set "defaults" depending on what was clicked */
    window.actionEvents = {
        'click .edit': function (e, value, row, index) {
            /* Set vals */
            /*console.log('You click edit icon, row: ' + JSON.stringify(row)); */
            $('#edit_siteid').val(row.siteID);
            $('#edit_site_name_oem').val(row.sitename);
            $('#edit_site_name').val(row.sitename);
            $('#edit_longitude').val(row.longitude);
            $('#edit_latitude').val(row.latitude);
            $('#edit_height').val(row.height);
            $('#edit_suburb').val(row.suburb);
            $('#edit_suburb').combobox("refresh");
            $('#edit_site_owner').val(row.idSite_Owner);
            $('#edit_site_owner').combobox("refresh");
        },
        'click .remove': function (e, value, row, index) {
            /* Set vals */
            /* console.log('You click edit icon, row: ' + JSON.stringify(row)); */
            $('#delete_site_name').val(row.sitename);
            $('#delete_suburb').val(row.suburb);
            $('#delete_longitude').val(row.longitude);
            $('#delete_latitude').val(row.latitude);
            $('#delete_height').val(row.height);
            $('#delete_site_owner').val(row.idSite_Owner);
            $('#delete_siteid').val(row.siteID);
        },
        'click .reassign': function (e, value, row, index) {
            /* Set vals */
            /*console.log('You click edit icon, row: ' + JSON.stringify(row)); */
            $('#reassign_site_name').val(row.sitename);
            $('#reassign_suburb').val(row.suburb);
            $('#reassign_longitude').val(row.longitude);
            $('#reassign_latitude').val(row.latitude);
            $('#reassign_height').val(row.height);
            /*$('#reassign_site_owner').val(row.idSite_Owner); */
            $('#reassign_siteid').val(row.siteID);
            $('#reassign_oem_site_owner').val(row.site_owner);
            $('#reassign_oem_site_owner_id').val(row.idSite_Owner);
            /*		 site_owner  idSite_Owner
             <input type="hidden" name="reassign_siteid" id="reassign_siteid" value="">
             <input type="hidden" name="reassign_oem_site_owner_id" id="reassign_oem_site_owner_id" value="">
             <input type="hidden" name="reassign_new_site_owner_id" id="reassign_new_site_owner_id" value="">				
             */
        }
    };
</script>

<!-- New site validation -->
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
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
                            regexp: /^(\([A-Z]{1,3}\))?[A-Za-z0-9]+$/,
                            message: 'The sitename can consist of alphabetical characters "a..z" and/or "0..9". Also "(" and ")" are allowed like this (SCU)Scully'
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
                            max: 100,
                            message: 'The latitude must be between 1 and 20'
                        }
                    }
                }
            }
        })

                .on('success.form.fv', function (e) {
                    // Prevent form submission
                    e.preventDefault();
                    var $form = $(e.target),
                            fv = $form.data('formValidation');
                    // Use Ajax to submit form data
                    $.ajax({
                        url: '../../../content/wugms.admin.create.new.site.php',
                        type: 'POST',
                        data: $form.serialize(),
                        success: function (result) {
                            location.reload();
                        }
                    });
                })

                .find('[name="suburb"],[name="site_owner"]')
                .combobox()
                .end();
    });
</script>

<!-- Edit site details -->
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
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
                            regexp: /^(\([A-Z]{1,3}\))?[A-Za-z0-9]+$/,
                            message: 'The sitename can consist of alphabetical characters "a..z" and/or "0..9". Also "(" and ")" are allowed like this (SCU)Scully'
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
                            max: 100,
                            message: 'The latitude must be between 1 and 20'
                        }
                    }
                }
            }
        })

                .on('success.form.fv', function (e) {
                    // Prevent form submission
                    e.preventDefault();
                    var $form = $(e.target),
                            fv = $form.data('formValidation');
                    // Use Ajax to submit form data
                    $.ajax({
                        //url: $form.attr('action'),
                        url: '../../../content/wugms.admin.edit.site.php',
                        type: 'POST',
                        data: $form.serialize(),
                        success: function (result) {
                            /*console.log(result); */
                            /*console.log('yes'); */
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                        }
                    });
                })

                .find('[name="edit_suburb"],[name="edit_site_owner"]')
                .combobox()
                .end();
    });
</script>

<!-- Delete site -->
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
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

                .on('success.form.fv', function (e) {
                    // Prevent form submission
                    e.preventDefault();
                    var $form = $(e.target),
                            fv = $form.data('formValidation');
                    // Use Ajax to submit form data
                    $.ajax({
                        //url: $form.attr('action'),
                        url: '../../../content/wugms.admin.delete.site.php',
                        type: 'POST',
                        data: $form.serialize(),
                        success: function (result) {
                            /*console.log(result); */
                            /*console.log('yes'); */
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                        }
                    });
                });
    });
</script>

<!-- Re-Assign site -->
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('#ReAssignsiteForm').formValidation({
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
                            message: 'In order to re-assign this site, you need to confirm'
                        }
                    }
                },
                reassign_site_owner: {
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

                .on('success.form.fv', function (e) {
                    // Prevent form submission
                    e.preventDefault();
                    var $form = $(e.target),
                            fv = $form.data('formValidation');
                    // Use Ajax to submit form data
                    $.ajax({
                        //url: $form.attr('action'),
                        url: '../../../content/wugms.admin.reassign.site.php',
                        type: 'POST',
                        data: $form.serialize(),
                        success: function (result) {
                            console.log(result);
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                        }
                    });
                })

                .find('[name="reassign_site_owner"]')
                .combobox()
                .end();
    });
</script>


</body>
</html>