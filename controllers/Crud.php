<?php
/**
 * @package Curd :  Datatables Add, View, Edit, Delete, Export and Custom Filter Using Codeigniter with Ajax
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *   
 * Description of Curd Controller
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curd extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Curd_model', 'emp');
    }
    // Employee list method
    public function index() {
        $data['page'] = 'emp-list';
        $data['title'] = 'Order Status Handling';    
        $this->load->view('employees/index', $data);

    }

    public function getAllEmployees()
    {
        $json = array();    
        $list = $this->emp->getEmpData();
        $data = array();
        foreach ($list as $element) {
            $row = array();
            $row[] = $element['id'];
            $row[] = $element['fullname'];
            $row[] = $element['email'];
            $row[] = $element['contact_no'];
            $row[] = $element['address'];
            $row[] = $element['salary'];
			$row[] = $element['status'];
            $data[] = $row;
        }

        $json['data'] = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->emp->countAll(),
            "recordsFiltered" => $this->emp->countFiltered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json['data']);
    }

    
    // Employee save method
    public function save() {
        $json = array();        
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $contact_no = $this->input->post('contact_no');
        $salary = $this->input->post('salary');            
            
        if(empty(trim($first_name))){
            $json['error']['firstname'] = 'Please enter first name';
        }
        if(empty(trim($last_name))){
            $json['error']['lastname'] = 'Please enter last name';
        }

        if(empty(trim($email))){
            $json['error']['email'] = 'Please enter email address';
        }

        if ($this->emp->validateEmail($email) == FALSE) {
            $json['error']['email'] = 'Please enter valid email address';
        }
        if(empty($address)){
            $json['error']['address'] = 'Please enter address';
        }
        if($this->emp->validateMobile($contact_no) == FALSE) {
            $json['error']['contactno'] = 'Please enter valid contact no';
        }

        if(empty($salary)){
            $json['error']['salary'] = 'Please enter salary';
        }

        if(empty($json['error'])){
            $this->emp->setFirstName($first_name);
            $this->emp->setLastName($last_name);
            $this->emp->setEmail($email);
            $this->emp->setAddress($address);
            $this->emp->setSalary($salary);
            $this->emp->setContactNo($contact_no);
            try {
                $last_id = $this->emp->createEmp();
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
                
            if (!empty($last_id) && $last_id > 0) {
                $empID = $last_id;
                $this->emp->setEmpID($empID);
                $empInfo = $this->emp->getEmp();                    
                $json['emp_id'] = $empInfo['id'];
                $json['first_name'] = $empInfo['first_name'];
                $json['last_name'] = $empInfo['last_name'];
                $json['email'] = $empInfo['email'];
                $json['address'] = $empInfo['address'];
                $json['contact_no'] = $empInfo['contact_no'];
                $json['salary'] = $empInfo['salary'];
                $json['status'] = 'success';
            }
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }

    // Employee edit method
    public function edit() {
        $json = array();
        $empID = $this->input->post('emp_id');
        $this->emp->setEmpID($empID);
        $json['empInfo'] = $this->emp->getEmp();

        $this->output->set_header('Content-Type: application/json');
        $this->load->view('employees/popup/renderEdit', $json);
    }

    // Employee update method
    public function update() {
        $json = array();        
        $emp_id = $this->input->post('emp_id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $contact_no = $this->input->post('contact_no');
        $salary = $this->input->post('salary');            
            
        if(empty(trim($first_name))){
            $json['error']['firstname'] = 'Please enter first name';
        }
        if(empty(trim($last_name))){
            $json['error']['lastname'] = 'Please enter last name';
        }

        if(empty(trim($email))){
            $json['error']['email'] = 'Please enter email address';
        }

        if ($this->emp->validateEmail($email) == FALSE) {
            $json['error']['email'] = 'Please enter valid email address';
        }
        if(empty($address)){
            $json['error']['address'] = 'Please enter address';
        }
        if($this->emp->validateMobile($contact_no) == FALSE) {
            $json['error']['contactno'] = 'Please enter valid contact no';
        }

        if(empty($salary)){
            $json['error']['salary'] = 'Please enter salary';
        }

        if(empty($json['error'])){
            $this->emp->setEmpID($emp_id);
            $this->emp->setFirstName($first_name);
            $this->emp->setLastName($last_name);
            $this->emp->setEmail($email);
            $this->emp->setAddress($address);
            $this->emp->setSalary($salary);
            $this->emp->setContactNo($contact_no);
            try {
                $last_id = $this->emp->updateEmp();;
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
                
            if (!empty($emp_id) && $emp_id > 0) { 
                $this->emp->setEmpID($emp_id);
                $empInfo = $this->emp->getEmp();                    
                $json['emp_id'] = $empInfo['id'];
                $json['first_name'] = $empInfo['first_name'];
                $json['last_name'] = $empInfo['last_name'];
                $json['email'] = $empInfo['email'];
                $json['address'] = $empInfo['address'];
                $json['contact_no'] = $empInfo['contact_no'];
                $json['salary'] = $empInfo['salary'];                   
                $json['status'] = 'success';
            }
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }

    // Employee display method
    public function display() {
        $json = array();
        $empID = $this->input->post('emp_id');
        $this->emp->setEmpID($empID);
        $json['empInfo'] = $this->emp->getEmp();

        $this->output->set_header('Content-Type: application/json');
        $this->load->view('employees/popup/renderDisplay', $json);
    }

    // Employee display method
    public function delete() {
        $json = array();
        $empID = $this->input->post('emp_id');        
        $this->emp->setEmpID($empID);
        $this->emp->deleteEmp();
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
        
    }

}
?>