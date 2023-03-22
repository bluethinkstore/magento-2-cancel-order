<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Model\Config;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Provider to fetch config value
 */
class Provider
{
    private const QUESTIONS = 'questiontab/dynamic_field_group/dynamic_field';

    private const TEXT_FIELD = 'text_field';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Json
     */
    private $serialize;

    /**
     * Provider Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Json $serialize
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Json $serialize
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->serialize = $serialize;
    }

    /**
     * Get questions for cancellation of order
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getQuestions(): array
    {
        $questions = $this->scopeConfig->getValue(
            self::QUESTIONS,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );

        $questionsArray = [];
        if (!empty($questions)) {
            foreach ($this->serialize->unserialize($questions) as $key => $row) {
                $questionsArray[] = $row[self::TEXT_FIELD];
            }
        }

        return $questionsArray;
    }
}
