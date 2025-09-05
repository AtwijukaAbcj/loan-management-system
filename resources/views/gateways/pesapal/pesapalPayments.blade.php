<script src="https://www.pesapal.com/assets/js/iframeResizer.min.js"></script>
<script>
    function makePaymentsWithPesapal() {
        // Example Pesapal iframe integration
        var iframe = document.createElement('iframe');
        iframe.src = "https://www.pesapal.com/payments?amount={{ $amount }}&email={{ auth()->user()->email }}";
        iframe.width = "100%";
        iframe.height = "600";
        iframe.frameBorder = "0";
        document.body.appendChild(iframe);

        // You may need to handle callbacks via window.postMessage or other means
        window.addEventListener('message', function(event) {
            // Example: handle payment completion
            if (event.data === 'pesapal_payment_complete') {
                let formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("data", JSON.stringify(event.data));

                fetch("{{ route('completeSubscription', $amount) }}", {
                    method: "POST",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        window.location.href = "/admin";
                    } else {
                        alert("Something went wrong: " + (data.message || ''));
                        window.location.href = "/admin";
                    }
                })
                .catch(error => {
                    alert("Failed to complete the request. Please try again.");
                });
            }
        });
    }

    window.addEventListener('DOMContentLoaded', function () {
        makePaymentsWithPesapal();
    });
</script>
