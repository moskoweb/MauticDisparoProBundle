<?php

namespace MauticPlugin\MauticDisparoProBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

/**
 * Class DisparoProIntegration.
 */
class DisparoProIntegration extends AbstractIntegration
{
    public function getName()
    {
        return 'DisparoPro';
    }

    public function getDisplayName()
    {
        return 'Disparo Pro';
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
    { }
}
