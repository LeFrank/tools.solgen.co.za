<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class income_model extends CI_Model {

    var $tn = "income";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users income from a post request. 
     * @return type
     */
    public function capture_income() {
        $this->load->helper('date');
        $this->load->library("session");
        // echo "----";
        $date = ($this->input->post('incomeDate') != "") ? date('Y/m/d H:i', strtotime($this->input->post('incomeDate'))): date('Y/m/d H:i');
        $data = array(
            'amount' => $this->input->post('amount'),
            'income_type_id' => $this->input->post('incomeType'),
            'description' => $this->input->post('description'),
            'source' => $this->input->post('source'),
            'source_id' => ($this->input->post('sourceId') == "") ? 0 : $this->input->post('sourceId'),
            'income_date' => $date,
            'user_id' => $this->session->userdata("user")->id,
            'income_asset_id' => $this->input->post('incomeAsset')
        );
        $this->db->insert($this->tn, $data);
        return $this->db->insert_id();
    }  

    /**
     * Capture a users income from a post request. 
     * @return type
     */
    public function capture_incomes($incomes) {
        $this->load->helper('date');
        $this->load->library("session");
        foreach($incomes as $k=>$income){
            $date = date('Y/m/d H:i', strtotime($income["income_date"]));
            $data = array(
                'amount' => $income["amount"],
                'income_type_id' => $income["income_type_id"],
                'description' => $income["description"],
                'source' => $income["source"],
                'source_id' => $income["source_id"],
                'income_date' => $date,
                'user_id' => $income["user_id"],
                'income_asset_id' => $income["income_asset_id"]
            );
            // check to see if there is not already a matching entry before trying to create a new one.
//            echo "<br/>isDuplicate: ". $this->isDuplicate($income);
//            echo "<br/>isDuplicate: ". empty($this->isDuplicate($income))?"true":"false";
            if($this->isDuplicate($income) == 0){
                if($this->db->insert($this->tn, $data)){
                    $income["id"] = $this->db->insert_id();
                    $income["status"] = "Success";
                    $income["statusMessage"] = "Expense Created Successfully.";
                }else{
                    $income["status"] = "Failure";
                    $income["statusMessage"] = "Expense was not created: ". $this->db->error();
                }
            }else{
                $income["status"] = "Failure";
                $income["statusMessage"] = "Is a duplicate, no action taken";
            }
            $incomes[$k] = $income;
        }
        return $incomes;
    }

    /**
     * 
     * @param type $id
     */
    public function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tn);
    }

    /**
     * 
     * @param type $userId
     */
    public function deleteUserData($userId) {
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }

    /**
     * 
     * @param type $userId
     * @param type $id
     * @return type
     */
    public function doesItBelongToMe($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->num_rows();
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getIncome($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    /**
     * Get incomes bases on certain criteria
     * @param type $userId if present return this users incomes.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getIncomes($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("income_date", "desc");
        // $this->db->join('user_content', 'user_content.tool_entity_id = income.id', 'LEFT');
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('income.user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('income.user_id' => $userId), $limit, $offset);
        }

        return $query->result_array();
    }

    public function getIncomesByIds($userId , $incomeIds){
        if ($userId == null) {
            return null;
        }
        if($incomeIds == null){
            return null;
        }
        $this->db->order_by("income_date", "desc");
        $this->db->where_in('id', $incomeIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }
    
    /**
     * 
     * @param type $userId
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getincomesByCriteria($userId = null, $limit = null, $offset = 0) {
        if (null != $userId) {
            $this->db->order_by("income_date", "desc");
            if ($this->input->post("fromAmount") != $this->input->post("toAmount")) {
                $this->db->where("amount >=", $this->input->post("fromAmount"));
                $this->db->where("amount <=", $this->input->post("toAmount"));
            }
            if ($this->input->post("keyword") != "") {
                $this->db->like("description", $this->input->post("keyword"));
            }
            $incomeTypeArr = $this->input->post("incomeType");
            $paymentMethodArr = $this->input->post("paymentMethod");
            if (!empty($incomeTypeArr) && $incomeTypeArr[0] != "all") {
                $this->db->where_in("income_type_id", array_map('intval', $this->input->post("incomeType")));
            }
            if (!empty($paymentMethodArr) && $paymentMethodArr[0] != "all") {
                $this->db->where_in("income_asset_id", array_map('intval', $this->input->post("paymentMethod")));
            }
            if (null == $limit) {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'income_date >=' => $this->input->post("fromDate"), 'income_date <= ' => $this->input->post("toDate")));
            } else {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'income_date >=' => $this->input->post("fromDate"), 'income_date <= ' => $this->input->post("toDate")), $limit, $offset);
            }
            return $query->result_array();
        }
    }

    /**
     * Get incomes by date range. Can be filtered by user and delimited
     * 
     * @param type $startDate
     * @param type $endDate
     * @param type $userId
     * @param type $limit
     * @param type $offset
     * @param type $orderBy
     * @param type $direction
     * @return null
     */
    public function getIncomesbyDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("income_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'income_date >=' => $startDate, 'income_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'income_date >=' => $startDate, 'income_date <= ' => $endDate), $limit, $offset);
        }
//        echo $this->db->last_query();
        return $query->result_array();
    }

     /**
      * Get incomes by date range, userId and incomeTypeId
      * @param type $startDate
      * @param type $endDate
      * @param type $userId
      * @param type $incomeTypeId
      * @return type
      */
    public function getbyDateRangeExpenseType($userId, $startDate, $endDate, $incomeTypeId) {
        if ($userId === null) {
            return null;
        }
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'income_date >=' => $startDate, 'income_date <= ' => $endDate, 'income_type_id' => $incomeTypeId ));
        return $query->result_array();
    }
    
    /* check if this is potentially a duplicate record.
     * It is a duplicate if has the following attributes:
     * belongs to the user
     * has the same date
     * is of the same amount.
     */
    private function isDuplicate($income){
        $query = $this->db->get_where($this->tn, array('user_id' => $income["user_id"], 'income_date' => $income["income_date"], 'amount' => $income["amount"]));
//        echo $this->db->last_query();
        return $query->num_rows();
    }
    
    /**
     * 
     * @return type
     */
    public function update() {
        $data = array(
            'amount' => $this->input->post('amount'),
            'income_type_id' => $this->input->post('incomeType'),
            'description' => $this->input->post('description'),
            'source' => $this->input->post('source'),
            'income_date' => date('Y/m/d H:i', strtotime($this->input->post('incomeDate'))),
            'user_id' => $this->session->userdata("user")->id,
            'income_asset_id' => $this->input->post('incomeAsset')
        );
        // print(__FILE__ . "<br/>");
        // echo("<pre>");
        // print_r($data);
        // echo("</pre>");
        // exit;
        $this->db->where('id', $this->input->post('id'));
        // print(__FILE__ . "<br/>");
        return $this->db->update($this->tn, $data);
    }

}
