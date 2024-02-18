document.addEventListener('DOMContentLoaded', function () {
    // Add event listener to the search input for dynamic filtering
    const searchInput = document.getElementById('searchQuery');
    const rows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.trim().toLowerCase();
        rows.forEach(function (row) {
            const transactionIdColumn = row.querySelector('td:nth-child(1)');
            const paymentTypeColumn = row.querySelector('td:nth-child(2)');
            const paymentDateColumn = row.querySelector('td:nth-child(3)');
            const paymentAmountColumn = row.querySelector('td:nth-child(4)');
            const customerEmailColumn = row.querySelector('td:nth-child(5)');
            const orderIdColumn = row.querySelector('td:nth-child(6)');
            if (transactionIdColumn && paymentTypeColumn && paymentDateColumn && paymentAmountColumn && customerEmailColumn && orderIdColumn) {
                const transactionId = transactionIdColumn.textContent.toLowerCase();
                const paymentType = paymentTypeColumn.textContent.toLowerCase();
                const paymentDate = paymentDateColumn.textContent.toLowerCase();
                const paymentAmount = paymentAmountColumn.textContent.toLowerCase();
                const customerEmail = customerEmailColumn.textContent.toLowerCase();
                const orderId = orderIdColumn.textContent.toLowerCase();
                if (transactionId.includes(filter) || paymentType.includes(filter) || paymentDate.includes(filter) || paymentAmount.includes(filter) || customerEmail.includes(filter) || orderId.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
});
