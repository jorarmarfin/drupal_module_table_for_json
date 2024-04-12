<?php

namespace Drupal\table_for_json\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TableForJsonSettingsForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return ['table_for_json.settings'];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'table_for_json_settings_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('table_for_json.settings');

        $form['table_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Table Name'),
            '#default_value' => $config->get('table_name'),
            '#description' => $this->t('Enter the name of the table to be accessed.'),
            '#required' => TRUE,
        ];
        $form['paginate_for'] = [
            '#type' => 'number',
            '#title' => $this->t('Paginate For'),
            '#default_value' => $config->get('paginate_for', 10),
            '#description' => $this->t('Enter the number of records to be displayed per page.'),
            '#required' => TRUE,
        ];
        $form['label_link'] = [
            '#type' => 'markup',
            '#markup' => $this->t('Enlace que debe acceder para ver sus datos en formato JSON: '),
            '#allowed_tags' => ['p'], // Permite etiquetas HTML en el markup.
        ];
        $form['info_link'] = [
            '#type' => 'markup',
            '#markup' => $this->t('<strong>/table_for_json/data</strong>'),
            '#allowed_tags' => ['p'], // Permite etiquetas HTML en el markup.
        ];


        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Save the configuration
        $this->config('table_for_json.settings')
            ->set('table_name', $form_state->getValue('table_name'))
            ->set('paginate_for', $form_state->getValue('paginate_for'))
            ->save();

        parent::submitForm($form, $form_state);
    }

}
