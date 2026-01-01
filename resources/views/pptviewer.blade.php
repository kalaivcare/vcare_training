<!DOCTYPE html>
<html>
<head>
  <title>PPT Viewer</title>
  <style>
    body, html {
      height: 100%;
      margin: 0;
    }
    iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>
</head>
<body>
  {{-- @dd($url) --}}
  {{-- <iframe src="https://docs.google.com/viewer?url={{ urlencode($url) }}&embedded=true"></iframe> --}}
  <iframe 
    src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($url) }}" 
    width="100%" 
    height="100%" 
    frameborder="0">
</iframe>

</body>
</html>
