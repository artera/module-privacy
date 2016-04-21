<?php
namespace Artera\Privacy\Block;

class Agreement extends \Magento\Framework\View\Element\Template
{
    protected $agreement;
    protected $page;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Artera\Privacy\Model\Agreement $agreement,
        \Artera\Privacy\Model\Page $page,
        array $data = []
    ) {
        $this->agreement = $agreement;
        $this->page = $page;
        parent::__construct($context, $data);
    }

    public function getAgreement()
    {
        return $this->agreement->getSelected();
    }
}
