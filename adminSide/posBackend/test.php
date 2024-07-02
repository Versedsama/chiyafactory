<?php 
    $secret = "8gBm/:&EnhH.1/q";
    $randomNumber = rand();
    $s = hash_hmac('sha256', "total_amount=110,transaction_uuid={$randomNumber},product_code=EPAYTEST", $secret, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Form</title>
</head>
<body>
    <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
        <input type="hidden" name="amount" value="100">
        <input type="hidden" name="failure_url" value="https://google.com">
        <input type="hidden" name="product_delivery_charge" value="0">
        <input type="hidden" name="product_service_charge" value="0">
        <input type="hidden" name="product_code" value="EPAYTEST">
        <input type="hidden" name="signature" value="<?php echo base64_encode($s);  ?>">
        <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
        <input type="hidden" name="tax_amount" value="10">
        <input type="hidden" name="total_amount" value="110">
        <input type="hidden" name="success_url" value="http://localhost/RestaurantProject/customerSide/home/home.php">
        <input type="hidden" name="transaction_uuid" value="<?php echo $randomNumber; ?>">
        <button type="submit">Submit</button>
    </form>
</body>
</html>