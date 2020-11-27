<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return [
    'name'        => 'Disparo Pro',
    'description' => 'Disparo Pro SMS integration',
    'author'      => 'https://alanmosko.com.br/',
    'version'     => '1.0.1',
    'services' => [
        'events'  => [],
        'forms'   => [],
        'helpers' => [],
        'other'   => [
            'mautic.sms.disparopro.transport' => [
                'class'     => \MauticPlugin\MauticDisparoProBundle\Services\DisparoProApi::class,
                'arguments' => [
                    'mautic.sms.twilio.configuration',
                    'monolog.logger.mautic',
                ],
                'tag'          => 'mautic.sms_transport',
                'tagArguments' => [
                    'integrationAlias' => 'DisparoPro',
                ],
                'serviceAliases' => [
                    'sms_api',
                    'mautic.sms.api',
                ],
            ],
        ],
        'models'       => [],
        'integrations' => [
            'mautic.integration.disparopro' => [
                'class' => \MauticPlugin\MauticDisparoProBundle\Integration\DisparoProIntegration::class,
            ],
        ],
    ],
    'routes'     => [],
    'menu'       => [],
    'menu' => [
        'main' => [
            'items' => [
                'mautic.sms.smses' => [
                    'route'  => 'mautic_sms_index',
                    'access' => ['sms:smses:viewown', 'sms:smses:viewother'],
                    'parent' => 'mautic.core.channels',
                    'checks' => [
                        'integration' => [
                            'DisparoPro' => [
                                'enabled' => true,
                            ],
                        ],
                    ],
                    'priority' => 70,
                ],
            ],
        ],
    ],
    'parameters' => [],
];
