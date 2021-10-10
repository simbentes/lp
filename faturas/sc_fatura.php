<?php
function criarFatura($numero, $cliente, $address, $each_item, $each_price)
{
    ob_start();
    include_once('tcpdf/tcpdf.php');

    //content
    $html = '
	<style>
	table, tr, td {
	padding: 15px;
	}
	</style>
	<table style="background-color: #222222; color: #fff">
	<tbody>
	<tr>
	<td><h1>FATURA<strong> #' . $numero . '</strong></h1></td>
	<td align="right"><img src="../img/lp.png" height="30px"/><br/>

	123 street, ABC Store<br/>
	Country, State, 00000
	<br/>
	<strong>+351 968 014 147</strong> | <strong>lplabmm@gmail.com</strong>
	</td>
	
	</tr>
	</tbody>
	</table>
	';
    $html .= '
	<table>
	<tbody>
	<tr>
	<td>Cliente<br/>
	<strong>' . $cliente . '</strong>
	<br/>
	' . $address . '
	</td>
	<td align="right">
	<strong>Valor Total: ' . $each_price . '€</strong><br/>
	NIF: ' . $address . '<br/>
	Data da Fatura: ' . date('d-m-Y') . '
	</td>
	</tr>
	</tbody>
	</table>
	';
    $html .= '
	<table>
	<thead>
	<tr style="font-weight:bold;">
	<th>Produto</th>
	<th>Preço</th>
	<th>IVA</th>
	<th>Quantidade</th>
	<th>Total</th>
	</tr>
	</thead>
	<tbody>';


    //só para aparecer o preço sem iva..
    $preco_sem_iva = round($each_price * 0.77, 2);

    $html .= '
		<tr>
		<td style="border-bottom: 1px solid #222">' . $each_item . '</td>
		<td style="border-bottom: 1px solid #222">' . $preco_sem_iva . '€</td>
		<td style="border-bottom: 1px solid #222">23%</td>
		<td style="border-bottom: 1px solid #222">' . "1" . '</td>
		<td style="border-bottom: 1px solid #222">' . $each_price . '€</td>
		</tr>
	<tr align="right">
	</tr>
	<tr>
	<td colspan="5">
	<h2>Obrigado pela preferência.</h2><br/>
	<strong>Termos and condições:<br/></strong>
Concordo com o tratamento de dados seguindo os <strong>Termos e
                        Condições</strong> da LP,
                    que se regem pelo Regulamento Geral da Proteção de Dados</td>
	</tr>
	</tbody>
	</table>
	';
    //end content
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set default monospaced font
    // set margins
    $pdf->SetMargins(-1, 0, -1);
    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);
    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->AddPage();
    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
    //$pdf->Output(dirname(__FILE__).'example_001.pdf', 'F');
    $pdf_name = '' . time() . '.pdf';
    //$pdf_name = 'test.pdf';
    ob_end_flush();
    $pdf->Output(dirname(__FILE__) . '/invoice/' . $pdf_name . '', 'F');
    return $pdf_name;
}





