<?php

namespace Drupal\dnl_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configurable two column layout plugin class.
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
      'bg_theme' => 'white',
      'padding' => 'default',
      'size' => 'default',
      'graphics' => 'none',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();

    $form['bg_theme'] = [
      '#type' => 'select',
      '#title' => $this->t('Background Color'),
      '#options' => [
        'none' => 'None',
        'white' => 'White',
        'gray' => 'Light Gray',
        'blue' => 'Blue',
      ],
      '#default_value' => $configuration['bg_theme'],
    ];


    $form['padding'] = [
      '#type' => 'select',
      '#title' => $this->t('Layout Padding'),
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
        'large' => 'Large',
      ],
      '#default_value' => $configuration['size'],
    ];

    $form['graphics'] = [
      '#type' => 'select',
      '#title' => $this->t('Layout graphics'),
      '#options' => [
        'default' => 'None',
        'line' => 'Crossed line',
        'split' => 'Split colors',
      ],
      '#default_value' => $configuration['graphics'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['bg_theme'] = $form_state->getValue('bg_theme');
    $this->configuration['padding'] = $form_state->getValue('padding');
    $this->configuration['size'] = $form_state->getValue('size');
    $this->configuration['graphics'] = $form_state->getValue('graphics');
  }
}
