<!-- Update Details modal -->
<div class="modal fade" id="UpdateDetailsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update details</h4>
            </div>
            <div class="modal-body">
                <form id="UpdateDetailsForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="">
                    <div class="form-group">
                        <label for="edit_name" class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="edit_name" name="edit_name" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_surname" class="col-md-4 control-label">Surname</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="edit_surname" name="edit_surname" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="currentacc" class="col-md-4 control-label">Current Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="currentacc" name="currentacc" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="newpw" class="col-md-4 control-label">New Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="newpw" name="newpw" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="verpw" class="col-md-4 control-label">Verify New Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="verpw" name="verpw" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="cancelsite" type="button" data-dismiss="modal" data-target="#UpdateDetailsModal" class="btn btn-default">Cancel</button>
                            <input class="btn btn-primary" type="submit" value="Update" id="postvalues">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
