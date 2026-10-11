<!-- Track Order Modal (shown when payment status is Paid) -->
<div class="modal-overlay" id="trackOrderModal">
    <div class="modal">
        <div class="modal__header">
            <h3 class="modal__title">Package Details</h3>
            <button class="modal__close" onclick="closeModal('trackOrderModal')">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>

        <div class="modal__body">
            <div class="package-detail">
                <!-- Package Image -->
                <div class="package-detail__image">
                    <img id="trackPackageImage" src="" alt="Package">
                </div>

                <!-- Status Tracker -->
                <div class="status-tracker" id="statusTracker">
                    <div class="status-tracker__step" id="stepProcessing">
                        <div class="status-tracker__dot">
                            <i class="ph-bold ph-gear"></i>
                        </div>
                        <span class="status-tracker__text">Processing</span>
                    </div>
                    <div class="status-tracker__step" id="stepShipped">
                        <div class="status-tracker__dot">
                            <i class="ph-bold ph-truck"></i>
                        </div>
                        <span class="status-tracker__text">Shipped</span>
                    </div>
                    <div class="status-tracker__step" id="stepDelivered">
                        <div class="status-tracker__dot">
                            <i class="ph-bold ph-check-circle"></i>
                        </div>
                        <span class="status-tracker__text">Delivered</span>
                    </div>
                </div>

                <!-- Package Info Rows -->
                <div class="package-detail__row">
                    <span class="package-detail__label">Tracking ID</span>
                    <span class="package-detail__value" id="trackTrackingId">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Package Name</span>
                    <span class="package-detail__value" id="trackPackageName">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Sender</span>
                    <span class="package-detail__value" id="trackSender">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Recipient</span>
                    <span class="package-detail__value" id="trackRecipient">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Address</span>
                    <span class="package-detail__value" id="trackAddress">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Location</span>
                    <span class="package-detail__value" id="trackLocation">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Description</span>
                    <span class="package-detail__value" id="trackDescription">—</span>
                </div>

                <div class="package-detail__row" style="border-bottom: none;">
                    <span class="package-detail__label">Status</span>
                    <span class="package-detail__value" id="trackStatus" style="color: var(--color-accent);">—</span>
                </div>
            </div>
        </div>

        <div class="modal__footer">
            <button class="btn btn--secondary btn--sm" onclick="closeModal('trackOrderModal')">Close</button>
        </div>
    </div>
</div>
