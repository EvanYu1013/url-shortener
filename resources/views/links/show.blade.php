<script>
    const handleError = error => {
        console.error('An error occurred:', error);
    };

    const handleSuccess = () => {
        window.location.href = "{{ $log['url'] }}";
    };

    const submitData = visitorId => {
        const data = {{ Js::from($log) }};
        data.fingerprint = visitorId;

        fetch("{{ route('request_logs.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (response.ok) {
                    handleSuccess();
                } else {
                    console.log(response.text());
                    throw new Error('Failed to submit data');
                }
            })
            .catch(handleError);
    };

    const handleFingerprint = fp => {
        fp.get()
            .then(result => {
                const visitorId = result.visitorId;
                submitData(visitorId);
            })
            .catch(handleError);
    };

    import('https://openfpcdn.io/fingerprintjs/v4')
        .then(FingerprintJS => FingerprintJS.load())
        .then(handleFingerprint)
        .catch(handleError);
</script>
