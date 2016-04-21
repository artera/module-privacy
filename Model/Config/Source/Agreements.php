<?php
namespace Artera\Privacy\Model\Config\Source;

class Agreements implements \Magento\Framework\Option\ArrayInterface
{
    protected $checkoutAgreementsRepository;

    public function __construct(
        \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface $checkoutAgreementsRepository
    ) {
        $this->checkoutAgreementsRepository = $checkoutAgreementsRepository;
    }

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
