<?php

namespace MauticPlugin\MauticDisparoProBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

/**
 * Class DisparoProIntegration.
 */
class DisparoProIntegration extends AbstractIntegration
{
    /**
     * @var bool
     */
    protected $coreIntegration = false;
    
    public function getName()
    {
        return 'DisparoPro';
    }

    public function getIcon()
    {
        return 'plugins/MauticDisparoProBundle/Assets/img/disparopro.png';
    }

    public function getSecretKeys()
    {
        return ['password'];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getRequiredKeyFields()
    {
        return [
            'auth_token' => 'mautic.plugin.disparopro.auth_token',
        ];
    }

    /**
     * @return array
     */
    public function getFormSettings()
    {
        return [
            'requires_callback'      => false,
            'requires_authorization' => false,
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getAuthenticationType()
    {
        return 'none';
    }

    /**
     * @param \Mautic\PluginBundle\Integration\Form|FormBuilder $builder
     * @param array                                             $data
     * @param string                                            $formArea
     */
    public function appendToForm(&$builder, $data, $formArea)
    {
        if ('features' == $formArea) {
            $builder->add(
                'disable_trackable_urls',
                YesNoButtonGroupType::class,
                [
                    'label' => 'mautic.sms.config.form.sms.disable_trackable_urls',
                    'attr'  => [
                        'tooltip' => 'mautic.sms.config.form.sms.disable_trackable_urls.tooltip',
                    ],
                    'data'=> !empty($data['disable_trackable_urls']) ? true : false,
                ]
            );
    }
}
