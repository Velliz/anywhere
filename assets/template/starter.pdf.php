if (isset($pdf)) {
    //this repeated every pages (located on bottom right)
    $font = $fontMetrics->get_font('helvetica', 'normal');
    $size = 10;
    $y = $pdf->get_height() - 24;
    $x = $pdf->get_width() - 70 - $fontMetrics->get_text_width('1/1', $font, $size);
    $pdf->page_text($x, $y, 'Page {PAGE_NUM} of {PAGE_COUNT}', $font, $size);

    //this repeated but not in first page (located on bottom left)
    $pdf->page_script('
        if ($PAGE_NUM > 1) {
            $font = $fontMetrics->getFont("helvetica", "bold");

            $size = 10;
            $y = $pdf->get_height() - 24;
            $x = 40 - $fontMetrics->get_text_width("1/1", $font, $size);

            $current_page = $PAGE_NUM - 1;
            $total_pages = $PAGE_COUNT - 1;

            $pdf->text($x, $y, "Page: $current_page of $total_pages", $font, $size, array(0,0,0));
        }
    ');

    //this repeated only in first page (located on upper left)
    $pdf->page_script('
        if ($PAGE_NUM == 1) {
            $font = $fontMetrics->getFont("helvetica", "bold");

            $size = 10;
            $y = 24;
            $x = $pdf->get_width() - 80 - $fontMetrics->get_text_width("1/1", $font, $size);

            $pdf->text($x, $y, "First Header", $font, $size, array(0,0,0));
        }
    ');
}