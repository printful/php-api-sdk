<?php

namespace Printful;

use Printful\Structures\Webhook\WebhookItem;
use Printful\Structures\Webhook\WebhooksInfoItem;

class PrintfulWebhook
{
    /**
     * @var PrintfulApiClient
     */
    private $printfulClient;

    /**
     * @param PrintfulApiClient $printfulClient
     */
    public function __construct(PrintfulApiClient $printfulClient)
    {
        $this->printfulClient = $printfulClient;
    }

    /**
     * @return WebhooksInfoItem
     */
    public function getRegisteredWebhooks()
    {
        $raw = $this->printfulClient->get('webhooks');
        return WebhooksInfoItem::fromArray($raw);
    }

    /**
     * Allows to enable webhook URL for the store and select webhook event types that will be sent to this URL.
     * Only one webhook URL can be active for a store, so calling this method disables all existing webhook configuration
     *
     * @param string $url - Webhook URL that will receive store's event notifications
     * @param array $types - Array of enabled webhook event types
     * @param array $params - Array of parameters for enabled webhook event types
     * @return WebhooksInfoItem
     */
    public function registerWebhooks($url, array $types, array $params = [])
    {
        $request = [
            'url' => $url,
            'types' => $types,
            'params' => $params,
        ];
        $raw = $this->printfulClient->post('webhooks', $request);
        return WebhooksInfoItem::fromArray($raw);
    }

    /**
     * @return WebhooksInfoItem
     */
    public function disableWebhooks()
    {
        $raw = $this->printfulClient->delete('webhooks');
        return WebhooksInfoItem::fromArray($raw);

    }

    /**
     * @param array $raw
     * @return WebhookItem
     */
    public function parseWebhook(array $raw)
    {
        return WebhookItem::fromArray($raw);
    }
}