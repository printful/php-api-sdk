<?php


namespace Printful\Structures\Generator;


use Printful\Structures\BaseItem;

class GenerationResultItem extends BaseItem
{
    /**
     * Generation task is in queue.
     */
    const STATUS_PENDING = 'pending';

    /**
     * Generation has failed for some reason. Check error field.
     */
    const STATUS_FAILED = 'failed';

    /**
     * Generation is completed.
     */
    const STATUS_COMPLETED = 'completed';

    /**
     * Unique task key, used to retrieve generation result
     *
     * @var string 32 char hash
     */
    public $taskKey;

    /**
     * Status of generation task. Value self::STATUS_*
     *
     * @var string
     */
    public $status;

    /**
     * If task has failed, reason is given here.
     *
     * @var string|null
     */
    public $error;

    /**
     * If generation is completed, mockup list is provided here
     * @var MockupList|null
     */
    public $mockupList;

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status == self::STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return $this->status == self::STATUS_FAILED;
    }

    /**
     * @param array|string $raw
     * @return GenerationResultItem
     */
    public static function fromArray(array $raw)
    {
        $item = new GenerationResultItem;

        $item->taskKey = $raw['task_key'];
        $item->status = $raw['status'];

        if (isset($raw['error'])) {
            $item->error = $raw['error'];
        }

        if (!empty($raw['mockups'])) {
            $mockupList = new MockupList;
            $mockupList->mockups = array_map(function (array $rawMockup) {
                return MockupItem::fromArray($rawMockup);
            }, $raw['mockups']);
            $item->mockupList = $mockupList;
        }

        return $item;
    }
}