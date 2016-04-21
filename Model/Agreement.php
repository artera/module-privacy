<?php
/**
 * Model for managing selected agreement data
 */
namespace Artera\Privacy\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

/**
 * Model for managing selected agreement data
 */
class Agreement extends \Magento\Framework\Model\AbstractModel
{
    /**
     * agreement_id config path
     */
    const XML_PATH_PRIVACY_SETTINGS_AGREEMENT_ID = 'privacy/settings/agreement_id';

    /**
     * @var \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface
     */
    protected $checkoutAgreementsRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Agreement constructor
     * @param \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface $checkoutAgreementsRepository
     * @param \Magento\Framework\App\Config\ScopeConfigInterface                    $scopeConfig
     */
    public function __construct(
        \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface $checkoutAgreementsRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->checkoutAgreementsRepository = $checkoutAgreementsRepository;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Selected agreement getter
     * @return \Magento\CheckoutAgreements\Api\CheckoutAgreementsRepositoryInterface|bool
     */
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

    /**
     * Selected agreement id getter
     * @return int
     */
    protected function getSelectedId()
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_PRIVACY_SETTINGS_AGREEMENT_ID,
            ScopeInterface::SCOPE_STORE
        );
    }
}
