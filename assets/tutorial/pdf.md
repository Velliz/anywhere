# PDF Integration Guide

Welcome to the PDF Integration Guide! This document will walk you through the process of generating professional-quality PDF documents using Anywhere. Whether you're setting up basic configurations, defining your templates, or integrating PDF generation into your codebase, we'll help you create dynamic and pixel-perfect PDFs with ease.

---

## 1. Basic Configuration

To begin generating PDF documents, you'll first need to create a PDF template. Simply click **New PDF** in your Anywhere dashboard. From there, you can configure the settings to meet your specific requirements. Below are the key template configurations for PDF generation:

*   **Report Name (string):** Assign a descriptive name for your report. This helps in organizing and identifying your PDF templates.
*   **Paper Type (radio button):** Select the desired paper size for your PDF:
    *   `F4`
    *   `A4`
    *   `B5`
*   **Data Source Type (radio button):**
    *   **POST:** Choose this option to send data directly to Anywhere. The AnywhereWrapper can be utilized for this purpose.
    *   **URL:** Anywhere will fetch the necessary data by opening a specified URL.
*   **CSS from CDN (URL):** Provide the address of a CSS CDN (e.g., `<link href="http://example.com/assets/global/css/bootstrap.css" rel="stylesheet">`). This allows you to style your PDF content using external stylesheets.
*   **URL Data Source Here (URL):** If you've selected "URL" as your data source type, enter the address where Anywhere should download the data.
*   **File Output (radio button):** Determine how the generated PDF should be handled:
    *   **Open directly in Browser:** The PDF will be displayed directly in the user's web browser.
    *   **Download:** The PDF will be downloaded as a file.
    *   *Note: If you're using AnywhereWrapper, data will automatically open directly in the browser.*
*   **API URL (URL):** The API endpoint for making requests to generate your PDF report.
*   **.html Designer (file):** Use this section to design the HTML layout of your PDF report. You do not need to include standard `<html>`, `<head>`, or `<body>` tags. The HTML designer adheres to the Puko Template Engine (PTE) rules, which you can learn more about [here](link-to-pte-docs).
*   **.css Designer (file):** Design the CSS styles for your PDF report here. This CSS will automatically be linked to your `.html` designer content.
*   **.json Data Sample:** Provide a sample JSON data structure that corresponds to the placeholders used in your HTML template. This is invaluable for design and development.

---

## 2. Code Integration

Once your PDF template is configured, integrating PDF generation into your application is straightforward. Download the AnywhereWrapper, and you can write code similar to the example below:

```php
require 'Wrapper.php';

$pdf = new Pdf(Wrapper::POST);
$pdf->setValue('Name', 'Someone');
$pdf->setValue('Age', '22');
$pdf->Send(API_URL);
```

If your request is successful, the browser will display the PDF file based on your template and provided data.

---

We hope this guide empowers you to create stunning and functional PDF documents with Anywhere! Feel free to explore and enhance your reporting capabilities. Happy coding!
