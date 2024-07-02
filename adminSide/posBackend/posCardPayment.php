<?php
session_start(); // Ensure session is started
?>
<?php
require_once '../config.php';
include '../inc/dashHeader.php'; 
$bill_id = $_GET['bill_id'];
$staff_id = $_GET['staff_id'];
$member_id = $_GET['member_id'];
$reservation_id = $_GET['reservation_id'];
?>

<div class="container" style="margin-top: 15rem; margin-left: 4rem;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bill (Credit Card Payment)</h3>
                </div>
                <div class="card-body">
                    <h5>Bill ID: <?php echo $bill_id; ?></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
            <?php
            // Query to fetch cart items for the given bill_id
            $cart_query = "SELECT bi.*, m.item_name, m.item_price FROM bill_items bi
                           JOIN Menu m ON bi.item_id = m.item_id
                           WHERE bi.bill_id = '$bill_id'";
            $cart_result = mysqli_query($link, $cart_query);
            $cart_total = 0;//cart total
            $tax = 0.1; // 10% tax rate

            if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                    $item_id = $cart_row['item_id'];
                    $item_name = $cart_row['item_name'];
                    $item_price = $cart_row['item_price'];
                    $quantity = $cart_row['quantity'];
                    $total = $item_price * $quantity;
                    $bill_item_id = $cart_row['bill_item_id'];
                    $cart_total += $total;
                    echo '<tr>';
                    echo '<td>' . $item_id . '</td>';
                    echo '<td>' . $item_name . '</td>';
                    echo '<td>Rs. ' . number_format($item_price,2) . '</td>';
                    echo '<td>' . $quantity . '</td>';
                    echo '<td>Rs. ' . number_format($total,2) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No Items in Cart.</td></tr>';
            }
            ?>
        </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="text-right">
                        <?php 
                        echo "<strong>Total:</strong> Rs. " . number_format($cart_total, 2) . "<br>";
                        echo "<strong>Tax (10%):</strong> Rs. " . number_format($cart_total * $tax, 2) . "<br>";
                        $GRANDTOTAL = $tax * $cart_total + $cart_total;
                        echo "<strong>Grand Total:</strong> Rs. " . number_format($GRANDTOTAL, 2);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="card-payment" class="col-md-6 order-md-2" style="margin-top: 10rem; margin-right: 5rem;max-width: 40rem;">
    <div class="container-fluid pt-5 pl-3 pr-3">
    <?php 
        $secret = "8gBm/:&EnhH.1/q";
        $randomNumber = rand();
        $grandTotal = number_format($GRANDTOTAL, 2);
        $s = hash_hmac('sha256', "total_amount={$grandTotal},transaction_uuid={$randomNumber},product_code=EPAYTEST", $secret, true);
    ?>
        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="hidden" name="amount" value="<?php echo $grandTotal; ?>">
            <input type="hidden" name="failure_url" value="http://localhost/RestaurantProject/adminSide/posBackend/failure.php">
            <input type="hidden" name="product_delivery_charge" value="0">
            <input type="hidden" name="product_service_charge" value="0">
            <input type="hidden" name="product_code" value="EPAYTEST">
            <input type="hidden" name="signature" value="<?php echo base64_encode($s);  ?>">
            <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
            <input type="hidden" name="tax_amount" value="0">
            <input type="hidden" name="total_amount" value="<?php echo $grandTotal; ?>">
            <input type="hidden" name="success_url" value="http://localhost/RestaurantProject/adminSide/posBackend/success.php">
            <input type="hidden" name="transaction_uuid" value="<?php echo $randomNumber; ?>">
            <button type="submit">Pay via Esewa</button>
        </form>        
    </div>
</div>

<?php include '../inc/dashFooter.php'; ?>

         