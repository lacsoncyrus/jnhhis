<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Model_admin extends CI_Model{

    /*Patients*/
    function get_patient_list(){
      $this->db->select('*');
      $this->db->from('patient');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_total_patient_count(){
      $this->db->select('*');
      $this->db->from('patient');
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_single_patient($id){
      $this->db->select('*');
      $this->db->from('patient');
      $this->db->where('patient_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function insertpatient($data){
      $this->db->insert('patient', $data);
    }

    function edit_patient_information($data, $id){
      $this->db->where('patient_id', $id);
      $this->db->update('patient', $data);
      return $id;
    }
    /*Patients*/

    /*Doctors*/
    function get_doctor_list(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->join('doctor_specializations c', 'c.spec_id=a.spec_id', 'left');
      $this->db->where('b.status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_single_doctor($id){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->join('doctor_specializations c', 'c.spec_id=a.spec_id', 'left');
      $this->db->where('a.user_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_inactive_doctor_list(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->join('doctor_specializations c', 'c.spec_id=a.spec_id', 'left');
      $this->db->where('b.status', 0);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_total_doctor_count(){
      $this->db->select('*');
      $this->db->from('doctor_information');
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_doctor_count(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->where('b.status', 1);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_doctor_count(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->where('b.status', 0);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_specialty(){
      $this->db->select('*');
      $this->db->from('doctor_specializations');
      $query = $this->db->get();
      return $query->result_array();
    }

    function insert_user($data){
      $this->db->insert('users', $data);
      $doctor_id = $this->db->insert_id();
      return $doctor_id;
    }

    function update_user($id, $data){
      $this->db->where('user_id', $id);
      $this->db->update('users', $data);
    }

    function insert_doctor_information($doctor_id, $specialty){
      $data = array('user_id'=>$doctor_id, 'spec_id'=>$specialty);
      $this->db->insert('doctor_information', $data);
    }

    function update_doctor_information($id, $specialty){
      $data = array('spec_id'=>$specialty);
      $this->db->where('user_id', $id);
      $this->db->update('doctor_information', $data);
    }
    /*Doctors*/

    /*Nurses*/
    function get_active_nurses_list(){
      $this->db->select('*');
      $this->db->from('users a');
      $this->db->join('user_type b', 'b.type_id=a.type_id', 'left');
      $this->db->group_start();
      $this->db->where('a.type_id', 3);
      $this->db->or_where('a.type_id', 4);
      $this->db->group_end();
      $this->db->where('status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_single_nurse($id){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('user_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_inactive_nurses_list(){
      $this->db->select('*');
      $this->db->from('users a');
      $this->db->join('user_type b', 'b.type_id=a.type_id', 'left');
      $this->db->group_start();
      $this->db->where('a.type_id', 3);
      $this->db->or_where('a.type_id', 4);
      $this->db->group_end();
      $this->db->where('status', 0);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_total_nurse(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('type_id', 3);
      $this->db->or_where('type_id', 4);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_nurse_manager(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>3, 'status'=>1));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_nurse_manager(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>3, 'status'=>0));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_bedside_nurse(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>4, 'status'=>1));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_bedside_nurse(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>4, 'status'=>0));
      $query = $this->db->get();
      return $query->num_rows();
    }
    /*Nurses*/

    /*Radiologist*/
    function get_active_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>1));
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_inactive_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>0));
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_single_radiologist($id){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('user_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_total_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('type_id', 5);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>1));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>0));
      $query = $this->db->get();
      return $query->num_rows();
    }
    /*Radiologist*/

    function activate($id){
      $data = array('status'=>1);
      $this->db->where('user_id', $id);
      $this->db->update('users', $data);
    }

    function deactivate($id){
      $data = array('status'=>0);
      $this->db->where('user_id', $id);
      $this->db->update('users', $data);
    }
  }
?>
