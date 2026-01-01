<!DOCTYPE html>
<html>
<head>
    <title>PDF Viewer</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
</head>
<body style="margin: 0; padding: 0;">
    <canvas id="pdf-canvas" style="width: 100%; border: 1px solid #ccc;"></canvas>

    <script>
        const url = @json($url);

        pdfjsLib.getDocument(url).promise.then(function (pdf) {
            pdf.getPage(1).then(function (page) {
                const scale = 1.5;
                const viewport = page.getViewport({ scale });

                const canvas = document.getElementById('pdf-canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                page.render({
                    canvasContext: context,
                    viewport: viewport
                });
            });
        }).catch(function(error) {
            console.error("Error loading PDF:", error);
        });
    </script>
</body>
</html>
