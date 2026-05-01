<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to PayFast...</title>
</head>
<body>
    <p>Redirecting to PayFast, please wait...</p>

    <form id="payfast-form" action="{{ $payfastUrl }}" method="POST">
        @foreach ($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>

    <script>
        document.getElementById('payfast-form').submit();
    </script>
</body>
</html>
