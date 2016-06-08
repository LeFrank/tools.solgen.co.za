<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class expense_budget_item_model extends CI_Model {

    var $tn = "expense_budget_items";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users budget from a post request. 
     * @return type
     */
    public function capture_expense_budget_item() {
        $this->load->helper('date');
        $this->load->library("session");
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'user_id' => $this->session->userdata("user")->id,
            'expense_period_id' => $this->input->post('expensePeriod'),
            'create_date' => date('Y/m/d H:i')
        );
        return $this->db->insert($this->tn, $data);
    }

    /**
     * Capture a users budget from a post request. 
     * @return type
     */
    public function capture_expense_budget_items() {
        $this->load->helper('date');
        $this->load->library("session");
        $amountArr = $this->input->post("amount");
        $descriptionArr = $this->input->post("description");
        $types = $this->input->post("expenseType");
        $returnData = array();
        foreach ($amountArr as $k => $v) {
            $data = array(
                'budget_id' => $this->input->post('budget-id'),
                'expense_type_id' => $types[$k],
                'limit_amount' => $v,
                'description' => $descriptionArr[$k],
                'create_date' => date('Y/m/d H:i'),
                'user_id' => $this->session->userdata("user")->id
            );
            $returnData[] = $this->db->insert($this->tn, $data);
        }
        return $returnData;
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

    public function doesItExist($userId, $description) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'description' => $description));
        return $query->num_rows();
    }

    /**
     * When given an ID return the row as an object
     * @param type $id
     * @return type
     */
    public function getItemById($id){
        $query = $this->db->get_where($this->tn, array("id" => $id));
        return $query->row();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getExpenseBudgetItems($budget_id) {
        $query = $this->db->get_where($this->tn, array('budget_id' => $budget_id));
        return $query->result_array();
    }

    /**
     * Get budgets bases on certain criteria
     * @param type $userId if present return this users expenses.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getExpenseBudgets($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("expense_period_id", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }
    
    public function getByBudgetIdAndCategoryId($userId = null, $budgetId = null, $expenseTypeId = null ) {
        if ($userId === null) {
            return null;
        }
        $query = $this->db->get_where($this->tn, array("user_id" => $userId, "budget_id" => $budgetId, "expense_type_id" => $expenseTypeId));
        //echo $this->db->last_query();
        return $query->row();
    }

    /**
     * 
     * @return type
     */
    public function update() {
        $this->load->helper('date');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'user_id' => $this->session->userdata("user")->id,
            'expense_period_id' => $this->input->post('expensePeriod'),
            'update_date' => date('Y/m/d H:i')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }
    
        /**
     * 
     * @return type
     */
    public function updateByItem($item) {
        $this->load->helper('date');
        $data = array(
            'description' => $item->description,
            'user_id' => $this->session->userdata("user")->id,
            'limit_amount' =>  $item->limit_amount,
            'period_outcome_amount' => $item->period_outcome_amount,
            'amount_sign' => $item->amount_sign,
            'update_date' => date('Y/m/d H:i'),
            'comment' => $item->comment
        );
        $this->db->where('id', $item->id);
        return $this->db->update($this->tn, $data);
    }

    /**
     * Update the budget Items when given an array of items. 
     * @return type
     */
    public function update_expense_budget_items($originalItems, $processedItems) {
        $this->load->helper('date');
        $returnData = array();
        foreach ($originalItems as $k => $v) {
            if($v["period_outcome_amount"] == null || $v["period_outcome_amount"] != $processedItems[$k]["period_outcome_amount"] ){
                $v["update_date"] = date('Y/m/d H:i');
                $this->db->where('id', $processedItems[$k]["id"]);
                $returnData[$v["id"]][] = $this->db->update($this->tn, $processedItems[$k]);
            }
        }
        return $returnData;
    }

}
