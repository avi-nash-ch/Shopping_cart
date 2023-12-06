<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping_cart_model extends CI_Model {

	public function fetch_all()
	{
		$query = $this->db->get("product");
        return $query->result();
	}
}
?>