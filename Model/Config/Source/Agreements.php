<?php
/**
 * Source model for agreements
 */
namespace Artera\Privacy\Model\Config\Source;

/**
 * Source model for agreements
 */
class Agreements implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface
     */
    protected $checkoutAgreementsRepository;

    /**
     * Agreements constructor
     * @param \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface $checkoutAgreementsRepository
     */
    public function __construct(
        \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface $checkoutAgreementsRepository
    ) {
        $this->checkoutAgreementsRepository = $checkoutAgreementsRepository;
    }

    /**
     * Agreements list getter
     * @return array
     */
    public function toOptionArray()
    {
        $agreements = [
            [
                'value'=> 0,
                'label'=> __('No')
            ]
        ];
        foreach ($this->checkoutAgreementsRepository->getList() as $agreement) {
            $agreements[] = [
                'value'=> $agreement->getId(),
                'label'=> $agreement->getName()
            ];
        }
        return $agreements;
    }
}
