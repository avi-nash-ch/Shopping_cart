<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shopping_cart extends CI_Controller
{
    public function index()
    {
        $this->load->model("Shopping_cart_model");
        $data["product"] = $this->Shopping_cart_model->fetch_all();
        $this->load->view('shopping_cart', $data);
    }
    public function add()
    {
        $this->load->library("cart");
        $data = array(
            "id"        => $_POST["product_id"],
            "name"      => $_POST["product_name"],
            "price"     => $_POST["product_price"],
            "qty"       => $_POST["quantity"]
        );
        $this->cart->insert($data); // return rowid
        echo $this->view();
    }

    public function load()
    {
        echo $this->view();
    }   
    public function remove()
    {
        $this->load->library("cart");
        $row_id = $_POST["row_id"];
        $data = array(
            'rowid'  => $row_id,
            'qty'  => 0
        );
        $this->cart->update($data);
        echo $this->view();
    }

    public function clear()
    {
        $this->load->library("cart");
        $this->cart->destroy();
        echo $this->view();
    }
    public function view()
    {
        $this->load->library("cart");
        $output = '';
        $output .= '<h3>Shopping Cart</h3><br>
        <div class="table-responsive">
            <div align="right">
                <button type="button" class="btn btn-warning" id="clear_cart" data-toggle="tooltip" data-placement="top">Clear Cart</button>
            </div>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="40%">Name</th>
                        <th width="15%">Quantity</th>
                        <th width="15%">Price</th>
                        <th width="15%">Total</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
        ';
        $count = 0;
        foreach ($this->cart->contents() as $items) {
            $count++;
            $output .= '
            <tr>
                <td>' . $items["name"] . '</td>
                <td>' . $items["qty"] . '</td>
                <td>$' . $items["price"] . '</td>
                <td>$' . $items["subtotal"] . '</td>
                <td>
                    <button type="button" class="btn btn-danger remove_inventory" id="' . $items["rowid"] . '" name="remove">Remove</button>
                </td>
            </tr>
            ';
        }
        $output .= '
            <tr>
                <td colspan="4" align="right">Total</td>
                <td>$' . $this->cart->total() . '</td>
            </tr>
            </table>
            </div>

        ';
        if ($count == 0) {
            $output .= '<h3 align="center"> Cart is Empty</h3>';
        }
        return $output;
    }
}
