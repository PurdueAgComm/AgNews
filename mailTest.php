<?php


$headers = "From: fromperson@email.com";

    // Generate a boundary string
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // Add the headers for a file attachment
    $headers .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";

    $content .= "Hi this is<b> in </b>the message.";

    // Add a multipart boundary above the plain message
    $message = "This is a multi-part message in MIME format.\n\n" .
    "--{$mime_boundary}\n" .
    "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $content . "\n\n";

    $body = "Hi. This is an attachment dynamically generated in PHP, fancy, right?.";

    // Base64 encode the file data
    $data = chunk_split(base64_encode($body));

    // Add file attachment to the message
    $message .= "--{$mime_boundary}\n" .
    "Content-Type: application/ms-word;\n" .
    " name=\"testfile.doc\"\n" .
    "Content-Disposition: attachment;\n" .
    " filename=\"testfile.doc\"\n" .
    "Content-Transfer-Encoding: base64\n\n" .
    $data . "\n\n" .
    "--{$mime_boundary}--\n";

    $message .= "This is in the email body.";

    // Send the message
    $ok = @mail('knwilson@purdue.edu', 'test file', $message, $headers);
    if ($ok) 
    {
        echo 'yes';
    } else 
    {
        echo 'no';
    }


    ?>