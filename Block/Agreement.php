<?php
/**
 * Block for managing selected agreement data
 */
namespace Artera\Privacy\Block;

/**
 * Block for managing selected agreement data
 */
class Agreement extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Artera\Privacy\Model\Agreement
     */
    protected $agreement;

    /**
     * @var \Artera\Privacy\Model\Page
     */
    protected $page;

    /**
     * Agreement constructor
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Artera\Privacy\Model\Agreement                  $agreement
     * @param \Artera\Privacy\Model\Page                       $page
     * @param array                                            $data
     */
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

    /**
     * Selected agreement getter
     * @return \Artera\Privacy\Model\Agreement
     */
    public function getAgreement()
    {
        return $this->agreement->getSelected();
    }
}
