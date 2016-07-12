<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head>
<meta charset=&quot;utf-8&quot;>
</head>
<body>
<h2>Hi {{ $user->name }},</h2>
<h3>We have received your password reset request. Please click on the link below and follow instructions to reset the password.</h3>
<h3> <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></h3>

<h4>If you're ever locked out of your account, we will use this email address to help you coming back to Kritish.</h4>
<h5>Did not request a password reset? Please let us know by clicking <a href="{{ $link = url('password/reset/false', $token) }}">here</a>.</h5>
</body>
</html>