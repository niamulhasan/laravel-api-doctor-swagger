<html>
<head>
    <title>{{ config('app.name') }} | Frontend API's Swagger</title>
    <link href="https://cdn.jsdelivr.net/npm/swagger-ui-dist@3.17.0/swagger-ui.css" rel="stylesheet">
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://unpkg.com/swagger-ui-dist@3.23.1/swagger-ui-bundle.js"></script>
<script type="application/javascript">
    const ui = SwaggerUIBundle({
        url: "{{ asset(URL::to('/').'/swagger-yaml-file-generated') }}",
        dom_id: '#swagger-ui',
    });
</script>
</body>
</html>
