<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codeigniter Shopping cart with Ajax JQuery</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/bootstrap.min.css") ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="table-responsive">
                    <h3 class="text-center">Codeiginter Shopping cart with Ajax JQuery</h3>
                    <br>
                    <div class="row">
                        <?php
                        foreach ($product as $row) {
                            echo '
                                <div class="col-md-4" style="padding:16px; background-color:#f1f1f1; border:1px solid #ccc; margin-bottom:16px; height:350px" align="center">
                                <img src="' . base_url() . 'uploads/images/' . $row->product_image . '" class="img-thumbnail"><br>
                                <h4>' . $row->product_name . '</h4>
                                <h3 class= "text-danger">$' . $row->product_price . '</h3>
                                <input type="text" name="quantity" class="quantity form-control" id="' . $row->product_id . '"> <br>
                                <button type="button" name="add_cart" class="btn btn-success add_cart" data-productname="' . $row->product_name . '" data-price="' . $row->product_price . '" data-productid="' . $row->product_id . '">Add to cart</button>
                                </div>
                                ';
                            }
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div id="cart_details">
                    <h3 class="text-center">Cart is Empty</h3>
                </div>
            </div>
        </div>
    </div>
</body>

</html> 
<script>
    $(document).ready(function() {
        $('.add_cart').click(function() {
            var product_id = $(this).data("productid");
            var product_name = $(this).data("productname");
            var product_price = $(this).data("price");
            var quantity = $('#' + product_id).val();
            if (quantity != '' && quantity > 0) {
                $.ajax({
                    url: "<?php echo base_url(); ?>shopping_cart/add",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        product_name: product_name,
                        product_price: product_price,
                        quantity: quantity
                    },
                    success: function(data) {
                        alert("Product Added into Cart");
                        $('#cart_details').html(data);
                        $('#' + product_id).val('');
                    }
                });
            } else {
                alert("Please Enter quantity");
            }
        });

        $('#cart_details').load("<?= base_url('shopping_cart/load') ?>");

        $(document).on('click', '.remove_inventory', function() {
            var row_id = $(this).attr("id");
            if (confirm("Are you sure you want to remove this?")) {
                $.ajax({
                    url: "<?= base_url("shopping_cart/remove") ?>",
                    method: "POST",
                    data: {
                        row_id: row_id
                    },
                    success: function(data) {
                        alert("Product removed from Cart");
                        $('#cart_details').html(data);
                    }
                });
            } else {
                return false;
            }
        });

        $(document).on('click', '#clear_cart', function() {
            if (confirm("Are you sure you want to clear cart?")) {
                $.ajax({
                    url: "<?= base_url("shopping_cart/clear") ?>",
                    method: "POST",
                    success: function(data) {
                        alert("Your cart has been Clear...");
                        $('#cart_details').html(data);
                    }
                });
            } else {
                return false;
            }
        });
    });
</script>