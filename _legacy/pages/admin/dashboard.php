<?php $pageTitle = 'Dashboard'; ?>
<?php include_once __DIR__ . '/../../includes/sidebar.php'; ?>

<!-- Dashboard Overview Cards -->
<div class="row" id="dashboardCards">
    <div class="col-3">
        <div class="stat-card accent-orange">
            <div class="stat-icon icon-orange">
                <i class="ph-bold ph-package"></i>
            </div>
            <div>
                <div class="stat-value" id="totalPackages">0</div>
                <div class="stat-label">Total Packages</div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="stat-card accent-green">
            <div class="stat-icon icon-green">
                <i class="ph-bold ph-check-circle"></i>
            </div>
            <div>
                <div class="stat-value" id="deliveredPackages">0</div>
                <div class="stat-label">Delivered</div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="stat-card accent-teal">
            <div class="stat-icon icon-teal">
                <i class="ph-bold ph-truck"></i>
            </div>
            <div>
                <div class="stat-value" id="transitPackages">0</div>
                <div class="stat-label">In Transit</div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="stat-card accent-crimson">
            <div class="stat-icon icon-crimson">
                <i class="ph-bold ph-hourglass"></i>
            </div>
            <div>
                <div class="stat-value" id="pendingPackages">0</div>
                <div class="stat-label">Processing</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Transactions -->
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Recent Transactions</span>
                <a href="/admin.transactions" class="btn btn-link">
                    View All <i class="ph-bold ph-arrow-right"></i>
                </a>
            </div>
            <div class="card-body no-pad">
                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Email</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="recentTransactions">
                            <tr>
                                <td colspan="5" class="table-empty">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Quick Actions</span>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="/admin.packages" class="btn btn-primary btn-lg btn-full">
                        <i class="ph-bold ph-plus-circle"></i>
                        Create a Package
                    </a>
                    <a href="/admin.transactions" class="btn btn-secondary btn-lg btn-full">
                        <i class="ph-bold ph-credit-card"></i>
                        View Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

            </main>
        </div>
    </div>

    <script src="/assets/js/admin/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/api/admin-dashboard/dashboard.php')
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.success) {
                        document.getElementById('totalPackages').textContent = data.stats.total || 0;
                        document.getElementById('deliveredPackages').textContent = data.stats.delivered || 0;
                        document.getElementById('transitPackages').textContent = data.stats.in_transit || 0;
                        document.getElementById('pendingPackages').textContent = data.stats.processing || 0;

                        var tbody = document.getElementById('recentTransactions');
                        if (data.transactions && data.transactions.length > 0) {
                            tbody.innerHTML = data.transactions.map(function (t) {
                                var badgeClass = t.payment_status === 'confirmed' ? 'badge-success' : t.payment_status === 'failed' ? 'badge-danger' : 'badge-info';
                                return '<tr>' +
                                    '<td>' + (t.payment_id || '\u2014') + '</td>' +
                                    '<td>' + t.payer_email + '</td>' +
                                    '<td>$' + parseFloat(t.amount).toFixed(2) + '</td>' +
                                    '<td><span class="badge ' + badgeClass + '">' + t.payment_status + '</span></td>' +
                                    '<td>' + new Date(t.created_at).toLocaleDateString() + '</td>' +
                                    '</tr>';
                            }).join('');
                        } else {
                            tbody.innerHTML = '<tr><td colspan="5" class="table-empty">No transactions yet</td></tr>';
                        }
                    }
                })
                .catch(function () {
                    document.getElementById('recentTransactions').innerHTML = '<tr><td colspan="5" class="table-empty">Could not load data</td></tr>';
                });
        });
    </script>
</body>
</html>
