<?php $pageTitle = 'Transactions'; ?>
<?php include_once __DIR__ . '/../../includes/sidebar.php'; ?>

<!-- Summary Cards -->
<div class="row" id="txSummary">
    <div class="col-6">
        <div class="stat-card accent-green">
            <div class="stat-icon icon-green">
                <i class="ph-bold ph-currency-dollar"></i>
            </div>
            <div>
                <div class="stat-value" id="totalPayments">$0.00</div>
                <div class="stat-label">Total Payments</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="stat-card accent-orange">
            <div class="stat-icon icon-orange">
                <i class="ph-bold ph-receipt"></i>
            </div>
            <div>
                <div class="stat-value" id="totalTransactions">0</div>
                <div class="stat-label">Total Transactions</div>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header">
        <span class="card-title">All Transactions</span>
    </div>
    <div class="card-body no-pad">
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Package</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="transactionsBody">
                    <tr>
                        <td colspan="7" class="table-empty">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

            </main>
        </div>
    </div>

    <script src="/assets/js/admin/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/api/admin-dashboard/transactions.php')
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.success) {
                        document.getElementById('totalPayments').textContent = '$' + parseFloat(data.summary.total_amount || 0).toFixed(2);
                        document.getElementById('totalTransactions').textContent = data.summary.total_count || 0;

                        var tbody = document.getElementById('transactionsBody');
                        if (data.transactions && data.transactions.length > 0) {
                            tbody.innerHTML = data.transactions.map(function (t) {
                                var badgeMap = { pending: 'badge-info', confirmed: 'badge-success', failed: 'badge-danger', expired: 'badge-default' };
                                return '<tr>' +
                                    '<td>' + (t.payment_id || '\u2014') + '</td>' +
                                    '<td class="table-tracking-id">' + (t.tracking_id || '\u2014') + '</td>' +
                                    '<td>' + t.payer_email + '</td>' +
                                    '<td>$' + parseFloat(t.amount).toFixed(2) + '</td>' +
                                    '<td>' + (t.payment_method || '\u2014') + '</td>' +
                                    '<td><span class="badge ' + (badgeMap[t.payment_status] || 'badge-default') + '">' + t.payment_status + '</span></td>' +
                                    '<td>' + new Date(t.created_at).toLocaleDateString() + '</td>' +
                                    '</tr>';
                            }).join('');
                        } else {
                            tbody.innerHTML = '<tr><td colspan="7" class="table-empty">No transactions yet</td></tr>';
                        }
                    }
                })
                .catch(function () {
                    document.getElementById('transactionsBody').innerHTML = '<tr><td colspan="7" class="table-empty">Could not load transactions</td></tr>';
                });
        });
    </script>
</body>
</html>
