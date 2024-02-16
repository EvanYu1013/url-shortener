<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Redirecting...</title>
    <script>
        {!! $scripts !!}
    </script>
    <script>
        const handleError = error => {
            console.error('An error occurred:', error);
        };

        const handleSuccess = () => {
            const url = "{{ $log['url'] }}".replace(/&amp;/g, '&');
            window.location.href = url;
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
</head>

<body>
    <p>Redirecting...</p>
</body>

</html>
