<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Curd_model extends CI_Model {
 
    private $_empID;
    private $_firstName;
    private $_lastName;
    private $_email;
    private $_address;
    private $_salary;
    private $_contactNo;
	private $_status;
 
    public function setEmpID($empID) {
        $this->_empID = $empID;
    }
    public function setFirstName($firstName) {
        $this->_firstName = $firstName;
    }
    public function setLastName($lastName) {
        $this->_lastName = $lastName;
    }    
    public function setEmail($email) {
        $this->_email = $email;
    }
    public function setAddress($address) {
        $this->_address = $address;
    }
    public function setSalary($salary) {
        $this->_salary = $salary;
    }
    public function setContactNo($contactNo) {
        $this->_contactNo = $contactNo;
    }
    // get Employee List
    var $table = 'employees';
    var $column_order = array(null, 'concat_ws(" ", e.name, e.last_name)','e.email','e.contact_no','e.address','e.salary'.'e.status');
    var $column_search = array('concat_ws(" ", e.name, e.last_name)','e.email','e.contact_no','e.address','e.salary');
    var $order = array('id' => 'DESC');
 
    private function getQuery()
    {
 
        //add custom filter here
        if(!empty($this->input->post('fullname')))
        {
            $this->db->like('concat_ws(" ", e.name, e.last_name)', $this->input->post('fullname'), 'both');
        }
        if(!empty($this->input->post('email')))
        {
            $this->db->like('e.email', $this->input->post('email'), 'both');
        }
        if(!empty($this->input->post('contact')))
        {
            $this->db->like('e.contact_no', $this->input->post('contact'), 'both');
        }
        if(!empty($this->input->post('address')))
        {
            $this->db->like('e.address', $this->input->post('address'), 'both');
        }
 
        $this->db->select(array('e.id', 'concat_ws(" ", e.name, e.last_name) as fullname','e.email','e.contact_no','e.address','e.salary'));
 
        $this->db->from('employees as e');
        $i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if(!empty($_POST['search']['value'])) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(!empty($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(!empty($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getEmpData()
    {
        $this->getQuery();
        if(!empty($_POST['length']) && $_POST['length'] < 1) {
            $_POST['length']= '10';
        } else {
            $_POST['length']= $_POST['length'];
        }
        
        if(!empty($_POST['start']) && $_POST['start'] > 1) {
        $_POST['start']= $_POST['start'];
        }
        $this->db->limit($_POST['length'], $_POST['start']);
        //print_r($_POST);die;
        $query = $this->db->get();
        return $query->result_array();
    }
    public function countFiltered()
    {
        $this->getQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
 
    // create new Employee
    public function createEmp() { 
        $data = array(
            'name' => $this->_firstName,
            'last_name' => $this->_lastName,
            'email' => $this->_email,
            'address' => $this->_address,
            'contact_no' => $this->_contactNo,
            'salary' => $this->_salary,
        );
        $this->db->insert('employees', $data);
        return $this->db->insert_id();
    }
    // update Employee
    public function updateEmp() { 
        $data = array(
            'name' => $this->_firstName,
            'last_name' => $this->_lastName,
            'email' => $this->_email,
            'address' => $this->_address,
            'contact_no' => $this->_contactNo,
            'salary' => $this->_salary,
        );
        $this->db->where('id', $this->_empID);
        $this->db->update('employees', $data);
    }
    // for display Employee
    public function getEmp() {        
        $this->db->select(array('e.id', 'e.name as first_name', 'e.last_name', 'e.email', 'e.address', 'e.contact_no', 'e.salary','e.status'));
        $this->db->from('employees e');  
        $this->db->where('e.id', $this->_empID);     
        $query = $this->db->get();
       return $query->row_array();
    }
 
    // delete Employee
    public function deleteEmp() {         
        $this->db->where('id', $this->_empID);
        $this->db->delete('employees');  
    }
 
    // email validation
    public function validateEmail($email)
    {
        return preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)?TRUE:FALSE;
    }
 
    // mobile validation
    public function validateMobile($mobile)
    {
        return preg_match('/^[0-9]{10}+$/', $mobile)?TRUE:FALSE;
    }
    
}
?>