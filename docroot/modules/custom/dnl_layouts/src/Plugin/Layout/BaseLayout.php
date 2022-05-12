<?php

namespace Drupal\dnl_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configurable base layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class BaseLayout extends LayoutDefault {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'padding' => 'default',
      'size' => 'default',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();

    $form['padding'] = [
      '#type' => 'select',
      '#title' => $this->t('Layout Padding (space between sections)'),
      '#options' => [
        'default' => 'Default',
        'small' => 'Small',
        'none' => 'None',
      ],
      '#default_value' => $configuration['padding'],
    ];

    $form['size'] = [
      '#type' => 'select',
      '#title' => $this->t('Layout size'),
      '#options' => [
        'default' => 'Default',
        'small' => 'Small',
      ],
      '#default_value' => $configuration['size'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['padding'] = $form_state->getValue('padding');
    $this->configuration['size'] = $form_state->getValue('size');
  }
}
