<?php

/**
 * @file
 * Contains \Drupal\flush_trace\Form\FlushTraceConfigForm.
 */

namespace Drupal\flush_trace\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class FlushTraceConfigForm extends ConfigFormBase {

  /*
  **
  * Returns a unique string identifying the form.
  *
  * @return string
  *   The unique string identifying the form.
  */
  public function getFormId() {
    return 'flush_trace_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('flush_trace.settings');

    $form['depth'] = array(
      '#type' => 'number',
      '#title' => $this->t('Backtrace Depth Limit'),
      '#description' => $this->t('In order to avoid out-of-memory (OOM) errors, you should limit the depth of the cache flush backtrace. We recommend 10 levels as a safe default.'),
      '#default_value' => !empty($config->get('depth')) ? $config->get('depth') : 10,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $depth = $form_state->getValue('depth');
    if ($depth > 50) {
      // Set an error for the form element with a key of "title".
      $form_state->setErrorByName('depth', $this->t('The depth must be a number equal to or less than 50. 10 is the recommended default.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Set & save the configuration : get the $config object.
    $config = $this->config('flush_trace.settings');
   // Set simple value key / value.
    $config->set('depth', $form_state->getValue('depth'));
    $config->save();
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return ['flush_trace.settings'];
  }

}
