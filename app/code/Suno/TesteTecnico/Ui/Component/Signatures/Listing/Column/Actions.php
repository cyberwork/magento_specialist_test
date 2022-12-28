<?php

namespace Suno\TesteTecnico\Ui\Component\Signatures\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Backend\Model\UrlInterface;

class Actions extends Column
{

    /** @var UrlInterface */
    protected $_urlBuilder;

    /**
     * @var string
     */
    protected $_viewUrl;


    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        $enableUrl = '',
        $disableUrl = '',
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_enableUrl    = $enableUrl;
        $this->_disableUrl    = $disableUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['signature_id'])) {
                    if($item['status'] === "1") {
                        $item[$name]['view'] = [
                            'href' => $this->_urlBuilder->getUrl($this->_disableUrl, ['id' => $item['signature_id']]),
                            //'target' => '_blank',
                            'label' => __('Desabilitar')
                        ];
                    }
                    else {
                        $item[$name]['view'] = [
                            'href' => $this->_urlBuilder->getUrl($this->_enableUrl, ['id' => $item['signature_id']]),
                            //'target' => '_blank',
                            'label' => __('Habilitar')
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }
}
