<?php
  // Ensure that there is a post request
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Replace with your real receiving email address
      $receiving_email_address = 'johnmanu353@gmail.com';

      // Get POST data
      $name = isset($_POST['name']) ? strip_tags(htmlspecialchars($_POST['name'])) : '';
      $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
      $subject = isset($_POST['subject']) ? strip_tags(htmlspecialchars($_POST['subject'])) : '';
      $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

      // Validate inputs
      if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
          http_response_code(400);
          echo "Please complete the form and try again.";
          exit;
      }

      // Email to site owner
      $owner_subject = "New Contact from Portfolio: $subject";
      $owner_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nSubject: $subject\n\nMessage:\n$message";
      $owner_headers = "From: noreply@manujohns.co.in\r\n";
      $owner_headers .= "Reply-To: $email\r\n";
      $owner_headers .= "X-Mailer: PHP/" . phpversion();

      // Email to user (confirmation)
      $user_subject = "Confirmation: We received your message!";
      $user_body = "Hi $name,\n\nThank you for reaching out! This is an automatic confirmation that we've received your message. I'll get back to you as soon as possible.\n\nYour message:\n$message\n\nBest Regards,\nManu John";
      $user_headers = "From: noreply@manujohns.co.in\r\n";
      $user_headers .= "Reply-To: $receiving_email_address\r\n";
      $user_headers .= "X-Mailer: PHP/" . phpversion();

      // Send emails
      $owner_sent = mail($receiving_email_address, $owner_subject, $owner_body, $owner_headers);
      $user_sent = mail($email, $user_subject, $user_body, $user_headers);

      if ($owner_sent) {
          echo "OK";
      } else {
          http_response_code(500);
          echo "Error sending email. Please check your server's email configuration.";
      }
  } else {
      http_response_code(403);
      echo "There was a problem with your submission, please try again.";
  }
?>
