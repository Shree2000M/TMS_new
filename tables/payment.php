<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        
            <!-- Payment Details -->
            <h4 class="mt-4">Payment Details</h4>
            <div class="mb-3">
                <label for="paymentMode" class="form-label">Payment Mode</label>
                <select class="form-select" id="paymentMode" name="paymentMode" required>
                    <option value="" selected disabled>Select Payment Mode</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Net Banking">Net Banking</option>
                    <option value="UPI">UPI</option>
                    <option value="Cash">Cash</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="amountPaid" class="form-label">Amount Paid</label>
                <input type="number" class="form-control" id="amountPaid" name="amountPaid" placeholder="Enter Amount Paid" required>
            </div>

            <div class="mb-3">
                <label for="transactionId" class="form-label">Transaction ID</label>
                <input type="text" class="form-control" id="transactionId" name="transactionId" placeholder="Enter Transaction ID (if applicable)">
            </div>

            <div class="mb-3">
                <label for="paymentDate" class="form-label">Payment Date</label>
                <input type="date" class="form-control" id="paymentDate" name="paymentDate" required>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary px-5">Submit Payment</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
