<?php
/**
 * Block for managing agreement template
 */
namespace Artera\Privacy\Block;

/**
 * Block for managing agreement template
 */
class Included extends \Artera\Privacy\Block\Agreement
{
    /**
     * Set template path if an agreement has been selected
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        if ($this->agreement->getSelected() !== false) {
            return parent::setTemplate($template);
        }
        return $this;
    }

    /**
     * Privacy page url getter
     * @return string|bool
     */
    public function getPageUrl()
    {
        $page = $this->page->getSelected();
        if ($page !== false && $page->getIsActive()) {
            return $this->getUrl($page->getIdentifier());
        } else {
            return false;
        }
    }
}
