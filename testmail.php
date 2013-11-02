<?php
$efrom = "From: Name Here <caneruguz@gmail.com>\r\n";
mail(
'caneruguz@gmail.com', // your email address
'E-Mail Subject', // email subject
'This is an email sent from MAMP', // email body
$efrom . "\r\n"// additional headers
);
?>