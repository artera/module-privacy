<?php
/**
 * Model for managing selected page data
 */
namespace Artera\Privacy\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

/**
 * Model for managing selected page data
 */
class Page extends \Magento\Framework\Model\AbstractModel
{
    /**
     * page_identifier config path
     */
    const XML_PATH_PRIVACY_SETTINGS_PAGE_IDENTIFIER = 'privacy/settings/page_identifier';

    /**
     * Default page identifier
     */
    const PAGE_IDENTIFIER = 'privacy.html';

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Page constructor
     * @param \Magento\Cms\Api\PageRepositoryInterface           $pageRepository
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->pageRepository = $pageRepository;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Selected page getter
     * @return \Magento\Cms\Api\PageRepositoryInterface|bool
     */
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

    /**
     * Selected page identifier getter
     * @return string
     */
    protected function getSelectedIdentifier()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PRIVACY_SETTINGS_PAGE_IDENTIFIER,
            ScopeInterface::SCOPE_STORE
        );
    }
}
