<?php
namespace Artera\Privacy\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

class Agreement extends \Magento\Framework\Model\AbstractModel
{
    const XML_PATH_PRIVACY_SETTINGS_AGREEMENT_ID = 'privacy/settings/agreement_id';

    protected $checkoutAgreementsRepository;
    protected $scopeConfig;

    public function __construct(
        \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface $checkoutAgreementsRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->checkoutAgreementsRepository = $checkoutAgreementsRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function getSelected()
    {
        if ($this->scopeConfig->isSetFlag('checkout/options/enable_agreements', ScopeInterface::SCOPE_STORE)) {
            $id = $this->getSelectedId();

            if ($id > 0) {
                try {
                    $selected = $this->checkoutAgreementsRepository->get($id);
                    if ($selected->getIsActive()) {
                        return $selected;
                    } else {
                        return false;
                    }
                } catch (NoSuchEntityException $e) {
                    return false;
                }
            }
        }
        return false;
    }

    protected function getSelectedId()
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_PRIVACY_SETTINGS_AGREEMENT_ID,
            ScopeInterface::SCOPE_STORE
        );
    }
}
