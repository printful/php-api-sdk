<?php

use Printful\PrintfulWebhook;
use Printful\Structures\Webhook\WebhookItem;
use Printful\Tests\TestCase;

class WebhooksConfigurationTest extends TestCase
{

    /**
     * @var PrintfulWebhook
     */
    private $printfulWebhook;

    protected function setUp()
    {
        parent::setUp();
        $this->printfulWebhook = new PrintfulWebhook($this->api);
    }

    public function testWebhooksCanBeRegistered()
    {
        $webhookInfo = $this->printfulWebhook->registerWebhooks(
            'http://example.com/test',
            [
                WebhookItem::TYPE_ORDER_CANCELED,
                WebhookItem::TYPE_PACKAGE_SHIPPED,
            ]
        );

        self::assertEquals(2, count($webhookInfo->types), 'Two webhook types successfully registered');
    }

    public function testWebhooksCanBeDisabled()
    {
        $webhookInfo = $this->printfulWebhook->disableWebhooks();

        self::assertEquals(0, count($webhookInfo->types), 'All webhook types disabled');
    }
}
