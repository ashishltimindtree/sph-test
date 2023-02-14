<?php

namespace Drupal\qrcodegenerations\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\qrcodegenerations\Service\GenerateQrCode;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'QR Code' Block.
 *
 * @Block(
 *   id = "qrcode",
 *   admin_label = @Translation("Qr Code"),
 *   category = @Translation("Qr Code"),
 * )
 */
class QrCode extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Match the current route.
   */
  protected $routeMatch;

  /**
   * Get the current node id.
   */
  protected $currentNode;

  /**
   * Qr code generater.
   *
   * @var \Drupal\products\Service\GenerateQrCode
   */
  protected $generateQrCode;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container,array $configuration,$plugin_id,$plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
      $container->get('qr_code_generator')
    );
  }

  /**
   * Creating Block to convert URL to link.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentRouteMatch $current_route_match, GenerateQrCode $generateQrCode) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $current_route_match;
    $this->currentNode = $this->routeMatch->getParameter('node');
    $this->generateQrCode = $generateQrCode;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $link = $this->currentNode->field_app_purchase_link->first()->toArray()['uri'];
    $qrChillerlan = $this->generateQrCode->qrGeneraterChillerlan($link);
    return [
      '#theme' => 'qr_code',
      '#qr_code' => $qrChillerlan,
    ];
  }
  
  /**
   * @return int
   * Disable the cache to prevent link in QR code from being cached.
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
