<div class="modal fade rotate" id="add-employee" style="display:none;">
    <div class="modal-dialog modal-lg"> 
        <form id="add-employee-form" method="post">   
            <div class="modal-content panel panel-primary">
                <div class="modal-header panel-heading">
                    <h4 class="modal-title -remove-title">Add Employee</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="first_name" class="form-control input-emp-firstname" id="first-name" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="last_name" class="form-control input-emp-lastname" id="last-name" placeholder="Last Name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control input-emp-email" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="address" class="form-control input-emp-address" id="address" placeholder="Address">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="contact_no" class="form-control input-emp-contactno" id="contact-no" placeholder="Contact No">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="number" name="salary" class="form-control input-emp-salary" id="emp-salary" placeholder="Salary">
                            </div>
                        </div>
                    </div>        
                </div>
                <div class="modal-footer panel-footer">
                    <div class="row">
                        <div class="col-sm-12">                            
                            <button type="button" class="btn rkmd-btn btn-success" data-addempid="" id="add-emp">Add</button> 
                            <button type="button" class="btn rkmd-btn btn-danger" data-dismiss="modal">Close</button>
                        </div>                    
                    </div>
                </div>
            </div>
        </form>      
    </div>
</div>