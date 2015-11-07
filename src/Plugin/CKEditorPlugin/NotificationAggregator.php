<?php

/**
 * @file
 * Definition of \Drupal\media_embed\Plugin\CKEditorPlugin\NotificationAggregator.
 */

namespace Drupal\media_embed\Plugin\CKEditorPlugin;

use Drupal\Core\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;
use Drupal\ckeditor\CKEditorPluginInterface;

/**
 * Defines the "Notification Aggregator" plugin.
 *
 * @CKEditorPlugin(
 *   id = "notificationaggregator",
 *   label = @Translation("Notification Aggregator"),
 *   module = "media_embed"
 * )
 */
class NotificationAggregator extends PluginBase implements CKEditorPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getDependencies(Editor $editor) {
    return array('notification');
  }

  /**
   * {@inheritdoc}
   */
  public function getLibraries(Editor $editor) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'media_embed') . '/js/plugins/notificationaggregator/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return array();
  }

}
