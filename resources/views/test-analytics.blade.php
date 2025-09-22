<!DOCTYPE html>
<html>
<head>
    <title>Test Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Test Analytics Endpoint</h1>
        <button id="testBtn" class="btn btn-primary">Test Analytics for Employee ID 1</button>
        <div id="result" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('testBtn').addEventListener('click', function() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<div class="spinner-border" role="status"></div> Loading...';
            
            fetch('/attendance/analytics/1')
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response:', text);
                    try {
                        const data = JSON.parse(text);
                        resultDiv.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                    } catch (e) {
                        resultDiv.innerHTML = '<div class="alert alert-danger">Invalid JSON: ' + text + '</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultDiv.innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
                });
        });
    </script>
</body>
</html>
