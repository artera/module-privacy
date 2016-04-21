<?php
namespace Artera\Privacy\Block;

class Included extends \Artera\Privacy\Block\Agreement
{
    public function setTemplate($template)
    {
        if ($this->agreement->getSelected() !== false) {
            return parent::setTemplate($template);
        }
        return false;
    }

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
