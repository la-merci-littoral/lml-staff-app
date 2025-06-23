<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../../root.css">
    <title>Scan QR Code</title>
</head>
<body>

    <header>
        <h2>Scanner un code</h2>
    </header>

    <div class="reader-wrapper">
        <div id="reader" width="600px"></div>
    </div>

    <div id="result"></div>

    <!-- <script src="./html5-qrcode.min.js" type="text/javascript"></script> -->
    <script src="../../lib/qrcode/html5-qrcode.min.js" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            console.log(`Code matched = ${decodedText}`, decodedResult);
            document.getElementById('result').innerText = decodedText;
            window.location = `../informations/informations.php?id=${decodedText}`
        }
        
        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
                console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>

</body>
</html>