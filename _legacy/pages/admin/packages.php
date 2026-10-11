<?php $pageTitle = 'Packages'; ?>
<?php include_once __DIR__ . '/../../includes/sidebar.php'; ?>

<!-- Page Header -->
<div class="page-header">
    <h2 class="page-title">All Packages</h2>
    <button class="btn btn-primary" onclick="openPackageModal()">
        <i class="ph-bold ph-plus-circle"></i>
        Create Package
    </button>
</div>

<!-- Packages Table -->
<div class="card">
    <div class="card-body no-pad">
        <div class="table-wrap">
            <table class="admin-table" id="packagesTable">
                <thead>
                    <tr>
                        <th>Tracking ID</th>
                        <th>Package</th>
                        <th>Recipient</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="packagesBody">
                    <tr>
                        <td colspan="7" class="table-empty">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create / Edit Package Modal -->
<div class="modal-overlay" id="packageModalOverlay">
    <div class="modal-box">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <h3 class="modal-title" id="packageModalTitle">Create Package</h3>
            <button class="modal-close" onclick="closePackageModal()">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>

        <form id="packageForm" enctype="multipart/form-data">
            <input type="hidden" id="pkgEditId" value="">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Package Name *</label>
                        <input type="text" id="pkgName" class="form-control" placeholder="Package name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Amount (USD) *</label>
                        <input type="number" id="pkgAmount" class="form-control" placeholder="0.00" step="0.01" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea id="pkgDescription" class="form-control" rows="2" placeholder="Package description"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Invoice Message</label>
                    <textarea id="pkgInvoice" class="form-control" rows="2" placeholder="Invoice message for recipient"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Sender *</label>
                        <input type="text" id="pkgSender" class="form-control" placeholder="Sender name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone *</label>
                        <input type="text" id="pkgPhone" class="form-control" placeholder="+1 (555) 000-0000" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Firstname *</label>
                        <input type="text" id="pkgFirstname" class="form-control" placeholder="Recipient first name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lastname *</label>
                        <input type="text" id="pkgLastname" class="form-control" placeholder="Recipient last name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" id="pkgEmail" class="form-control" placeholder="recipient@email.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Address *</label>
                    <input type="text" id="pkgAddress" class="form-control" placeholder="Full address" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Location *</label>
                        <input type="text" id="pkgLocation" class="form-control" placeholder="City, Country" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address Type *</label>
                        <input type="text" id="pkgAddressType" class="form-control" placeholder="Residential / Commercial" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Package Image *</label>
                    <input type="file" id="pkgImage" class="form-control" accept="image/*">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select id="pkgStatus" class="form-control">
                            <option value="processing">Processing</option>
                            <option value="in_transit">In Transit</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Status</label>
                        <select id="pkgPaymentStatus" class="form-control">
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closePackageModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" id="pkgSubmitBtn">
                    <i class="ph-bold ph-check-circle"></i> Save Package
                </button>
            </div>
        </form>
    </div>
</div>

            </main>
        </div>
    </div>

    <script src="/assets/js/admin/main.js"></script>
    <script>
        function openPackageModal(pkg) {
            document.getElementById('packageModalTitle').textContent = pkg ? 'Edit Package' : 'Create Package';
            document.getElementById('pkgEditId').value = pkg ? pkg.id : '';
            document.getElementById('pkgName').value = pkg ? pkg.package_name : '';
            document.getElementById('pkgAmount').value = pkg ? pkg.amount : '';
            document.getElementById('pkgDescription').value = pkg ? pkg.description : '';
            document.getElementById('pkgInvoice').value = pkg ? pkg.invoice_message : '';
            document.getElementById('pkgSender').value = pkg ? pkg.sender : '';
            document.getElementById('pkgPhone').value = pkg ? pkg.phone : '';
            document.getElementById('pkgFirstname').value = pkg ? pkg.firstname : '';
            document.getElementById('pkgLastname').value = pkg ? pkg.lastname : '';
            document.getElementById('pkgEmail').value = pkg ? pkg.email : '';
            document.getElementById('pkgAddress').value = pkg ? pkg.address : '';
            document.getElementById('pkgLocation').value = pkg ? pkg.location : '';
            document.getElementById('pkgAddressType').value = pkg ? pkg.address_type : '';
            document.getElementById('pkgStatus').value = pkg ? pkg.status : 'processing';
            document.getElementById('pkgPaymentStatus').value = pkg ? pkg.payment_status : 'unpaid';
            document.getElementById('pkgImage').value = '';
            document.getElementById('packageModalOverlay').classList.add('open');
        }

        function closePackageModal() {
            document.getElementById('packageModalOverlay').classList.remove('open');
            document.getElementById('packageForm').reset();
            document.getElementById('pkgEditId').value = '';
        }

        document.getElementById('packageModalOverlay').addEventListener('click', function (e) {
            if (e.target === this) closePackageModal();
        });

        function loadPackages() {
            fetch('/api/admin-dashboard/packages.php')
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    var tbody = document.getElementById('packagesBody');
                    if (data.success && data.packages && data.packages.length > 0) {
                        tbody.innerHTML = data.packages.map(function (p) {
                            var statusBadge = { processing: 'badge-danger', in_transit: 'badge-info', delivered: 'badge-success' };
                            var payBadge = { unpaid: 'badge-danger', paid: 'badge-success' };
                            return '<tr>' +
                                '<td class="table-tracking-id">' + p.tracking_id + '</td>' +
                                '<td>' + p.package_name + '</td>' +
                                '<td>' + p.firstname + ' ' + p.lastname + '</td>' +
                                '<td>$' + parseFloat(p.amount).toFixed(2) + '</td>' +
                                '<td><span class="badge ' + (statusBadge[p.status] || 'badge-default') + '">' + p.status.replace('_', ' ') + '</span></td>' +
                                '<td><span class="badge ' + (payBadge[p.payment_status] || 'badge-default') + '">' + p.payment_status + '</span></td>' +
                                '<td><div class="action-btns">' +
                                    '<button class="btn-icon btn-ghost text-teal" onclick=\'openPackageModal(' + JSON.stringify(p).replace(/'/g, "\\'") + ')\' title="Edit"><i class="ph-bold ph-pencil-simple"></i></button>' +
                                    '<button class="btn-icon btn-ghost text-danger" onclick="deletePackage(' + p.id + ')" title="Delete"><i class="ph-bold ph-trash"></i></button>' +
                                '</div></td>' +
                                '</tr>';
                        }).join('');
                    } else {
                        tbody.innerHTML = '<tr><td colspan="7" class="table-empty">No packages found. Create one to get started.</td></tr>';
                    }
                })
                .catch(function () {
                    document.getElementById('packagesBody').innerHTML = '<tr><td colspan="7" class="table-empty">Could not load packages</td></tr>';
                });
        }

        function deletePackage(id) {
            if (!confirm('Are you sure you want to delete this package?')) return;
            fetch('/api/admin-dashboard/packages.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    adminToast('Package deleted', 'success');
                    loadPackages();
                } else {
                    adminToast(data.message || 'Delete failed', 'error');
                }
            });
        }

        document.getElementById('packageForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var btn = document.getElementById('pkgSubmitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="ph-bold ph-spinner"></i> Saving...';

            var formData = new FormData();
            var editId = document.getElementById('pkgEditId').value;
            if (editId) formData.append('id', editId);
            formData.append('package_name', document.getElementById('pkgName').value);
            formData.append('amount', document.getElementById('pkgAmount').value);
            formData.append('description', document.getElementById('pkgDescription').value);
            formData.append('invoice_message', document.getElementById('pkgInvoice').value);
            formData.append('sender', document.getElementById('pkgSender').value);
            formData.append('phone', document.getElementById('pkgPhone').value);
            formData.append('firstname', document.getElementById('pkgFirstname').value);
            formData.append('lastname', document.getElementById('pkgLastname').value);
            formData.append('email', document.getElementById('pkgEmail').value);
            formData.append('address', document.getElementById('pkgAddress').value);
            formData.append('location', document.getElementById('pkgLocation').value);
            formData.append('address_type', document.getElementById('pkgAddressType').value);
            formData.append('status', document.getElementById('pkgStatus').value);
            formData.append('payment_status', document.getElementById('pkgPaymentStatus').value);

            var imageFile = document.getElementById('pkgImage').files[0];
            if (imageFile) formData.append('image', imageFile);

            fetch('/api/admin-dashboard/packages.php', {
                method: 'POST',
                body: formData
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    adminToast(editId ? 'Package updated' : 'Package created', 'success');
                    closePackageModal();
                    loadPackages();
                } else {
                    adminToast(data.message || 'Save failed', 'error');
                }
            })
            .catch(function () {
                adminToast('Connection error', 'error');
            })
            .finally(function () {
                btn.disabled = false;
                btn.innerHTML = '<i class="ph-bold ph-check-circle"></i> Save Package';
            });
        });

        document.addEventListener('DOMContentLoaded', loadPackages);
    </script>
</body>
</html>
