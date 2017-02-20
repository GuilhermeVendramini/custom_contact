<?php

namespace Drupal\custom_contact\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigCustomContact.
 *
 * @package Drupal\custom_contact\Form
 */
class ConfigCustomContact extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_contact.configcustomcontact',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_custom_contact';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_contact.configcustomcontact');
    $form['receiver'] = [
      '#type' => 'email',
      '#title' => $this->t('Destinatário'),
      '#description' => $this->t('Destinatário do formulário de contato custom.'),
      '#default_value' => $config->get('receiver'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('custom_contact.configcustomcontact')
      ->set('receiver', $form_state->getValue('receiver'))
      ->save();
  }

}
