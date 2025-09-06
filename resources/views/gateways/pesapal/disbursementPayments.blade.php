<script src="https://www.pesapal.com/assets/js/iframeResizer.min.js"></script>
<script>
    function makeDisbursementWithPesapal() {
        var iframe = document.createElement('iframe');
        iframe.src = "https://www.pesapal.com/payments?amount={{ $amount }}&email={{ auth()->user()->email }}&type=disbursement";
        iframe.width = "100%";
        iframe.height = "600";
        iframe.frameBorder = "0";
        document.body.appendChild(iframe);

        window.addEventListener('message', function(event) {
            if (event.data === 'pesapal_payment_complete') {
                let formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("data", JSON.stringify(event.data));
                fetch("{{ route('completeDisbursement', $amount) }}", {
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
        makeDisbursementWithPesapal();
    });
</script>
