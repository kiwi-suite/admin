<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin\Response;

use Ixocreate\Resource\ResourceInterface;

class ApiDetailResponse extends ApiSuccessResponse
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @var array
     */
    private $item;

    /**
     * @var array
     */
    private $meta;

    public function __construct(ResourceInterface $resource, array $item, array $meta)
    {
        $data = [
            'label' => $resource->label(),
            'item' => (object)$item, // make sure an empty array here is an empty object in json
            'meta' => $meta,
        ];
        parent::__construct($data);
        $this->resource = $resource;
        $this->item = $item;
        $this->meta = $meta;
    }

    public function resource(): ResourceInterface
    {
        return $this->resource;
    }

    public function item(): array
    {
        return $this->item;
    }

    public function meta(): array
    {
        return $this->meta;
    }
}
