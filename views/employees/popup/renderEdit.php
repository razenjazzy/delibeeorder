 <?php
    $id = $empInfo['id'] ? $empInfo['id'] : '';
    $first_name = $empInfo['first_name'] ? $empInfo['first_name'] : '';
    $last_name = $empInfo['last_name'] ? $empInfo['last_name'] : '';
    $email = $empInfo['email'] ? $empInfo['email'] : '';
    $address = $empInfo['address'] ? $empInfo['address'] : '';
    $contact_no = $empInfo['contact_no'] ? $empInfo['contact_no'] : '';
    $salary = $empInfo['salary'] ? $empInfo['salary'] : '';
?>

<input type="hidden" name="emp_id" value="<?php print $id; ?>">
<div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" name="first_name" class="form-control input-emp-firstname" id="first-name" placeholder="First Name" value="<?php print $first_name; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" name="last_name" class="form-control input-emp-lastname" id="last-name" placeholder="Last Name" value="<?php print $last_name; ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" name="email" class="form-control input-emp-email" id="email" placeholder="Email" value="<?php print $email; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" name="address" class="form-control input-emp-address" id="address" placeholder="Address" value="<?php print $address; ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" name="contact_no" class="form-control input-emp-contactno" id="contact-no" placeholder="Contact No" value="<?php print $contact_no; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" name="salary" class="form-control input-emp-salary" id="last-name" placeholder="Salary" value="<?php print $salary; ?>">
            </div>
        </div>
    </div>