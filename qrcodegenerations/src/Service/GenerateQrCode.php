<?php

namespace Drupal\qrcodegenerations\Service;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

/**
 * Provides a 'QR Code' for requested link or string.
 */
class GenerateQrCode {

  /**
   *
   * URL to convert the qr code in link.
   */
  public function qrGeneraterChillerlan(string $url) {
    $options = new QROptions(
        [
          'eccLevel' => QRCode::ECC_L,
          'outputType' => QRCode::OUTPUT_MARKUP_SVG,
          'version' => 5,
        ]
    );
    $generateQr = (new QRCode($options))->render($url);
    return $generateQr;
  }
}
