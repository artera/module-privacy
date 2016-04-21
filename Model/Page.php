<?php
namespace Artera\Privacy\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

class Page extends \Magento\Framework\Model\AbstractModel
{
    const XML_PATH_PRIVACY_SETTINGS_PAGE_IDENTIFIER = 'privacy/settings/page_identifier';
    const PAGE_IDENTIFIER = 'privacy.html';

    protected $pageRepository;
    protected $scopeConfig;

    public function __construct(
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->pageRepository = $pageRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function getSelected()
    {
        $identifier = $this->getSelectedIdentifier();

        if (!empty($identifier)) {
            try {
                return $this->pageRepository->getById($identifier);
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return false;
    }

    protected function getSelectedIdentifier()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PRIVACY_SETTINGS_PAGE_IDENTIFIER,
            ScopeInterface::SCOPE_STORE
        );
    }
}
