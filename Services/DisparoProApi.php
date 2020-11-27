<?php

namespace MauticPlugin\MauticDisparoProBundle\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Mautic\SmsBundle\Sms\TransportInterface;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Mautic\LeadBundle\Entity\Lead;
use Psr\Log\LoggerInterface;

class DisparoProApi extends TransportInterface
{
    /**
     * @var Configuration
     */
    private $configuration;
    
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * MessageBirdApi constructor.
     *
     * @param Configuration            $configuration
     * @param LoggerInterface          $logger
     *
     * @param Http              $http
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger)
    {
        $this->logger        = $logger;
        $this->configuration = $configuration;
    }
    /**
     * @param $number
     *
     * @return string
     *
     * @throws NumberParseException
     */
    protected function sanitizeNumber($number)
    {
        $util   = PhoneNumberUtil::getInstance();
        $parsed = $util->parse($number, 'BR');
        return $util->format($parsed, PhoneNumberFormat::E164);
    }

    /**
     * @param Lead   $lead
     * @param string $content
     *
     * @return bool|mixed|string
     */
    public function sendSms(Lead $lead, $content)
    {
        $number = $lead->getLeadPhoneNumber();

        if (null === $number) {
            return false;
        }
        
        try {
            $this->configureClient();

            $this->client->messages->create(
                $this->sanitizeNumber($number),
                [
                    'from' => $this->sendingPhoneNumber,
                    'body' => $content,
                ]
            );

            return true;
        } 

        if ($this->configuration->getAuthToken()) {
            $body = [
                [
                    "numero" => $this->sanitizeNumber($number),
                    "servico" => "short",
                    "mensagem" => $content,
                    "parceiro_id" => "MauticApi",
                ],
            ];
            try {
                $headers = [
                    'Authorization' => 'Bearer ' . $this->configuration->getAuthToken(),
                    'Content-Type'  => 'application/json',
                ];

                $client = new Client();
                $response = $client->post(
                    'https://apihttp.disparopro.com.br:8433/mt',
                    [
                        'headers' => $headers,
                        'body' => json_encode($body),
                    ]
                );

                return ($response->getStatusCode() == 200) ? true : false;
            } catch (ServerException $exception) {
                $this->parseResponse($exception->getResponse(), $body);
            } catch (Exception $e) {
                if (method_exists($e, 'getErrorMessage')) {
                    return $e->getErrorMessage();
                } elseif (!empty($e->getMessage())) {
                    return $e->getMessage();
                }

                return false;
            }
        }
    }
}
