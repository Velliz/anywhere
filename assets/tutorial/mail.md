# Mail Integration Guide

Welcome to the Mail Integration Guide! This document will walk you through setting up and sending emails effortlessly using Anywhere. Whether you're configuring your basic mail settings, designing dynamic templates, or integrating email sending into your code, we'll ensure your messages reach their destination smoothly. Let's make email communication simple and efficient!

---

## 1. Basic Configuration

To start sending emails, you'll first need to create an email template. Simply click **New MAIL** in your Anywhere dashboard. From there, you can configure the settings to suit your specific needs. Below are the key template configurations for SMTP email:

*   **Email Name (string):** This name will be used as the sender's name for your emails.
*   **Email Host (string):** The hostname of your email service provider (e.g., `smtp.mailgun.org`, `smtp.sendgrid.com`).
*   **Email Port (string):** The SMTP port number provided by your email service. Common ports are 587 (TLS) or 465 (SSL).
*   **Email Username (string):** Your email account's username.
*   **Email Password (string):** Your email account's password.
*   **CSS from CDN (URL):** The address of your CSS CDN (e.g., `<link href="http://example.com/assets/global/css/bootstrap.css" rel="stylesheet">`). This allows you to style your emails using external stylesheets.
*   **Data Source Type (radio button):**
    *   **POST:** Select this option to send data directly to Anywhere. You can use the AnywhereWrapper for this purpose.
    *   **URL:** Anywhere will fetch data from a specified URL.
*   **URL Data Source Here (URL):** If you choose "URL" as your data source type, provide the address where Anywhere should retrieve the data.
*   **SMTP Auth (select):** Choose `true` to enable SMTP authentication, or `false` to disable it.
*   **SMTP Secure (select):** Select your preferred security protocol: `TLS` or `SSL`.
*   **API URL (URL):** The API endpoint for making email sending requests.
*   **.html Designer (file):** Use this to design your email's HTML layout. You don't need to include `<html>`, `<head>`, or `<body>` tags; just focus on the content. The HTML designer utilizes the Puko Template Engine (PTE) rules, which you can explore further [here](link-to-pte-docs).
*   **.css Designer (file):** Design your email's CSS styles here. This CSS will automatically be linked to your `.html` designer content.
*   **.json Data Sample:** Provide a sample JSON data structure that matches the placeholders in your HTML template.

---

## 2. Code Integration

Once your template is configured, sending emails from your application is straightforward. Download the AnywhereWrapper, and you can send emails using code similar to the example below:

```php
require 'Wrapper.php';

$mail = new Mail(Wrapper::POST);
$mail->setTo('example@gmail.com');
$mail->setCc('example@outlook.com');
$mail->setBcc('example@yahoo.co.id');

$mail->setSubject('Anywhere Wrapper');
$mail->setValue('Name', 'Anywhere');
$mail->setValue('Age', '22');

$mail->setAttachment('qrcode.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=admin@example.co.id');
$mail->setAttachment('qrcode1.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=developer@example.co.id');

$mail->Send(API_URL);
```

**Important Note:** Emails typically take a few minutes to arrive at their destination. Please be patient after sending.

If your request is successful, the email will be sent to the address specified in `setTo()`.

---

We hope this guide helps you streamline your email communication through Anywhere! Should you have any questions, feel free to reach out. Happy emailing!
