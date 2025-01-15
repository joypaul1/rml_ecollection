<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print authorization letter Form</title>
</head>

<body>
    <h1>Print Authorization letter</h1>
    <!-- Button to trigger the print dialog -->
    <!-- <button onclick="printPDF()">Print PDF Form</button> -->

    <!-- Embedding the PDF -->
    <iframe id="pdfFrame" src="authorization_letter.pdf" width="100%" height="500px"></iframe>



    <script>
        function printPDF() {
            var pdfFrame = document.getElementById('pdfFrame');
            pdfFrame.contentWindow.print(); // Trigger print dialog for the embedded PDF
        }
    </script>
</body>

</html>