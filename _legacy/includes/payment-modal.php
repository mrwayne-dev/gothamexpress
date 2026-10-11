<!-- Payment Modal -->
<div class="modal-overlay" id="paymentModal">
    <div class="modal">
        <div class="modal__header">
            <h3 class="modal__title">Package Payment</h3>
            <button class="modal__close" onclick="closeModal('paymentModal')">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>

        <div class="modal__body">
            <div class="package-detail">
                <div class="package-detail__image">
                    <img id="paymentPackageImage" src="" alt="Package">
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Package Name</span>
                    <span class="package-detail__value" id="paymentPackageName">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Tracking ID</span>
                    <span class="package-detail__value" id="paymentTrackingId">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Description</span>
                    <span class="package-detail__value" id="paymentDescription">—</span>
                </div>

                <div class="package-detail__row">
                    <span class="package-detail__label">Invoice Message</span>
                    <span class="package-detail__value" id="paymentInvoice">—</span>
                </div>

                <div class="package-detail__row" style="border-bottom: none;">
                    <span class="package-detail__label" style="font-size: var(--font-size-md); color: var(--color-text);">Amount Due</span>
                    <span class="package-detail__value" id="paymentAmount" style="font-size: var(--font-size-xl); color: var(--color-accent);">$0.00</span>
                </div>
            </div>
        </div>

        <div class="modal__footer">
            <button class="btn btn--outline btn--sm" onclick="closeModal('paymentModal')">Cancel</button>
            <button class="btn btn--primary btn--lg" id="payNowBtn" onclick="initiatePayment()">
                <i class="ph-bold ph-credit-card"></i> Pay Now
            </button>
        </div>
    </div>
</div>
