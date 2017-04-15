<html>
    <head>
        <!-- insert in the document head -->
        <meta charset="UTF-8">
        <title><?php print $_SESSION['setupData']['siteTitle']; if (isset($menuPoint[0]['Title'])) { print ' - ' . $menuPoint[0]['Title']; } ?></title>
        <script src="<?php print COMMON_JS_PATH; ?>pdfobject.js"></script>
        <script type="text/javascript">
            function embedPDF() {
                var parameter ="<?php print UPLOADED_PATH . 'media/' . $fileName[0]['Name']; ?>";
                var myPDF = new PDFObject({ 
                    url: parameter
                }).embed('PDFView');
                // Be sure your document contains an element with the ID 'PDFView' 
            }

            window.onload = embedPDF; //Feel free to replace window.onload if needed.
        </script>
    </head>

    <body>
        <span id="PDFView"></span>
    </body>
</html>