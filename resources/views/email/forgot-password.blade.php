<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Hello {{$mailData['user']->name}}</h1>
    <p>
        Click here to change your password
    </p>

    <a href="{{route("front.account.resetPassword",$mailData['token'])}}">Click here</a>
    <p>Thanks</p>
</body>
</html>