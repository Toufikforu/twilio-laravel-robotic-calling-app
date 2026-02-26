<html>
<head>
    <title>BRY Color Code</title>
</head>
<body>
    <p>
        Hi Issa,<br>
        I'm {{ Auth::user()->name }}. Please check below my BRY color code.<br><br>

        <strong>Id:</strong> {{ $data['id'] }}<br>
        <strong>Target:</strong> {{ $data['target'] }}<br>
        <strong>Current:</strong> {{ $data['current'] }}<br>
        <strong>Needed:</strong> {{ $data['needed'] }}<br>
        <strong>Date:</strong> {{ $data['created_at']->format('F j, Y') }}<br>
        <strong>Command:</strong> {{ $data['command'] }}<br><br>

        Please check my values.
    </p>
</body>
</html>
