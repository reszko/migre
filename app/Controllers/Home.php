<?php

namespace App\Controllers;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Home extends BaseController
{
	public function index()
	{

		// $options = new QROptions([
		// 	'version'    => 5,
		// 	'outputType' => QRCode::OUTPUT_IMAGE_PNG,
		// 	'imageTransparent' => false,
		// 	'eccLevel'   => QRCode::ECC_H,
		// 	'scale' => 10
		// ]);


		// $qr = new QRCode($options);
		// // echo '<img src="' . $qr->render('https://codeigniter.com.br', WRITEPATH . '/qrcodes/qrcode.png') . '" alt="QR Code" />';

		return view('home');
	}
}
