<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>paystack</title>
</head>
<body>
<form id="paymentForm">
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email-address" required />
  </div>
  <div class="form-group">
    <label for="amount">Amount</label>
    <input type="tel" id="amount" required />
  </div>

  <div class="form-submit">
    <button type="button" onclick="payWithPaystack()"> Pay </button>
  </div>
</form>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
  var paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener('submit', payWithPaystack, false);
function payWithPaystack() {
  var handler = PaystackPop.setup({
    key: 'pk_test_404b79008cbe91fe0ed06d9bb280d9315180db83', // Replace with your public key
    email: document.getElementById('email-address').value,
    amount: document.getElementById('amount').value * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
    currency: 'GHS', // Use GHS for Ghana Cedis or USD for US Dollars
    ref: ''+(Math.floor(Math.random()*100000)+1), // Replace with a reference you generated
    callback: function(response) {
      // //this happens after the payment is completed successfully
      // var reference = response.reference;
      // alert('Payment complete! Reference: ' + reference);
      // // Make an AJAX call to your server with the reference to verify the transaction
      window.location.href = "process_paystack.php?reference=" + response.reference;
    },
    onClose: function() {
      alert('Transaction was not completed, window closed.');
    },
  });
  handler.openIframe();
}
</script>    
</body>
</html>
