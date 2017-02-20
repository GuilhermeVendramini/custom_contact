<?php

namespace Drupal\custom_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CustomContact.
 *
 * @package Drupal\custom_contact\Form
 */
class CustomContact extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_contact';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nome'),
      '#description' => $this->t('Informe seu nome'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Informe um email válido'),
      '#required' => TRUE,
    ];
    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Mensagem'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
    ];

    return $form;
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

  /**
    Parameters

    string $module: A module name to invoke hook_mail() on. The {$module}_mail() hook will be called to complete the $message structure which will already contain common defaults.

    string $key: A key to identify the email sent. The final message ID for email altering will be {$module}_{$key}.

    string $to: The email address or addresses where the message will be sent to. The formatting of this string will be validated with the PHP email validation filter. Some examples are:

    user@example.com
    user@example.com, anotheruser@example.com
    User <user@example.com>
    User <user@example.com>, Another User <anotheruser@example.com>
    string $langcode: Language code to use to compose the email.

    array $params: (optional) Parameters to build the email.

    string|null $reply: Optional email address to be used to answer.

    bool $send: If TRUE, call an implementation of \Drupal\Core\Mail\MailInterface->mail() to deliver the message, and store the result in $message['result']. Modules implementing hook_mail_alter() may cancel sending by setting $message['send'] to FALSE.
    */

    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'custom_contact';
    $key = 'custom_contact_form';
    $to = \Drupal::config('custom_contact.configcustomcontact')->get('receiver');
    $params['name'] = $form_state->getValue('name');
    $params['message'] = $form_state->getValue('message');
    $langcode = \Drupal::currentUser()->getPreferredLangcode();
    $reply = $form_state->getValue('email');
    $send = true;

    $result = $mailManager->mail($module, $key, $to, $langcode, $params, $reply, $send);
    
    drupal_set_message($to);
    
    if ($result['result'] !== true) {
      drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
    }
    else {
      drupal_set_message(t('Your message has been sent.'));
    }

  }

}
