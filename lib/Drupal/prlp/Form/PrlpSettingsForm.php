<?php

/**
 * @file
 * Contains \Drupal\prlp\Form\PrlpSettingsForm.
 */

namespace Drupal\prlp\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Password Reset Landing Page (PRLP) settings for this site.
 */
class PrlpSettingsForm extends ConfigFormBase {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandler
   */
  protected $moduleHandler;

  /**
   * Constructs a \Drupal\PrlpSettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Extension\ModuleHandler $module_handler
   *   The module handler.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ModuleHandler $module_handler) {
    parent::__construct($config_factory);
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('module_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'prlp_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    $config = $this->configFactory->get('prlp.settings');

    $form['password_required'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Password Entry Required'),
      '#description' => $this->t('If set, users will be required to enter a new password when they use a password reset link to login'),
      '#default_value' => $config->get('password_required'),
    );

    $form['destination'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Login Destination'),
      '#description' => $this->t('User will be taken to this path after they log in with the password reset link. Token %uid can be used in the path, and will be replaced with the uid of the current user. Use %front for site front-page.', array('%uid' => '%uid', '%front' => '<front>')),
      '#default_value' => $config->get('destination'),
    );

    $form['hidden_fields'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Fields Hidden'),
      '#description' => $this->t('List of form keys that should be hidden on password reset landing page. Put one per line.'),
      '#default_value' => $config->get('hidden_fields'),
    );

    $form['hidden_account_fields'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Account Fields Hidden'),
      '#description' => $this->t("List of form sub-keys under 'account' key (e.g. 'mail', 'name' etc.) that should be hidden on password reset landing page. Put one per line."),
      '#default_value' => $config->get('hidden_account_fields'),
    );

    $form['actions']['reset'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Reset to defaults'),
      '#submit' => array(array($this, 'resetForm')),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, array &$form_state) {
    // Not sure, if we need this.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    parent::submitForm($form, $form_state);

    $this->configFactory->get('prlp.settings')
      ->set('password_required', $form_state['values']['password_required'])
      ->set('destination', $form_state['values']['destination'])
      ->set('hidden_fields', $form_state['values']['hidden_fields'])
      ->set('hidden_account_fields', $form_state['values']['hidden_account_fields'])
      ->save();
  }

  /**
   * Resets the filter form.
   */
  public function resetForm(array &$form, array &$form_state) {
    // Todo: some magic to load default settings
  }

}

