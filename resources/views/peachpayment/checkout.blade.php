<style>
    .card-container {
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<div id="peach-payment-container" class="card-container p-4 mt-4" style="border: 1px solid #e3e3e3; border-radius: 8px;">
    <h4 class="text-center mb-4">Enter your Card Details</h4>
</div>

<script src="{{ config('peach-payment.' . config('peach-payment.environment') . '.embedded_checkout_url') }}"></script>

<script type="text/javascript">
    console.log("Embedded Checkout URL:", "{{ config('peach-payment.' . config('peach-payment.environment') . '.embedded_checkout_url') }}");
    console.log("Entity ID:", "{{ config('peach-payment.entity_id') }}");
    console.log("Checkout ID:", "{{ $checkoutId }}");
    const checkout = Checkout.initiate({
        key: "{{ config('peach-payment.entity_id') }}",
        checkoutId: "{{ $checkoutId }}",
    });

    // Render the Peach Payment form inside the payment container
    checkout.render("#peach-payment-container");

    const paymentContainer = document.querySelector("#peach-payment-container");

    try {
        checkout.render("#peach-payment-container");
    } catch (error) {
        console.error("Error rendering Peach Payment form:", error);
    }
    
if (paymentContainer) {
    console.log("Payment container found:", paymentContainer);
} else {
    console.error("Payment container not found.");
}

</script>
