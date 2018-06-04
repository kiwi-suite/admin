<?php

namespace KiwiSuite\Admin\Schema\Form\Elements;

use KiwiSuite\Admin\Schema\Form\TypeMappingInterface;
use KiwiSuite\CommonTypes\Entity\DateType;

final class Date extends AbstractProxyElement implements TypeMappingInterface
{
    /**
     * Wysiwyg constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->element->setType("datetime");
        $this->element->addOption("config", ['dateInputFormat' => 'YYYY-MM-DD']);
    }

    public static function getTypeMapping(): string
    {
        return DateType::class;
    }
}
