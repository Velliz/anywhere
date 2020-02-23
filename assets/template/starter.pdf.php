if (isset($pdf)) {
    $font = $fontMetrics->get_font('helvetica', 'normal');
    $size = 9;
    $y = $pdf->get_height() - 24;
    $x = $pdf->get_width() - 15 - $fontMetrics->get_text_width('1/1', $font, $size);
    $pdf->page_text($x, $y, 'Page {PAGE_NUM} of {PAGE_COUNT}', $font, $size);
}