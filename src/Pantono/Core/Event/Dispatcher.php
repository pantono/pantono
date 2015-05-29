<?php

namespace Pantono\Core\Event;

use Pantono\Acl\Entity\AdminUser;
use Pantono\Assets\Entity\Asset;
use Pantono\Categories\Entity\Category;
use Pantono\Core\Block\BlockInterface;
use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\Block;
use Pantono\Core\Event\Events\Currency as CurrencyEvent;
use Pantono\Core\Event\Events\Form;
use Pantono\Core\Event\Events\FormField;
use Pantono\Core\Event\Events\General;
use Pantono\Core\Event\Events\Metadata;
use Pantono\Metadata\Entity\Metadata as MetadataEntity;
use Pantono\Core\Event\Events\Template;
use Pantono\Form\Element\ElementInterface;
use Pantono\Core\Event\Events\Category as CategoryEvent;
use Pantono\Core\Event\Events\Asset as AssetEvent;
use Pantono\Core\Event\Events\AdminUser as AdminUserEvent;
use Pantono\Templates\Model\Table\Table;
use \Pantono\Core\Event\Events\Table as TableEvent;
use \Pantono\Locale\Entity\Currency;

class Dispatcher
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function dispatchGeneralEvent($event)
    {
        $this->application['dispatcher']->dispatch($event, new General($this->application));
    }

    public function dispatchTemplateEvent($event, &$templateFile, &$templateContent, $controller, $action)
    {
        $templateEvent = new Template();
        $templateEvent->setContent($templateContent);
        $templateEvent->setTemplateFile($templateFile);
        $templateEvent->setController($controller);
        $templateEvent->setAction($action);
        $this->application['dispatcher']->dispatch($event, $templateEvent);
    }

    public function dispatchBlockEvent($event, BlockInterface $block = null, $blockModel, $contents = '')
    {
        $blockEvent = new Block($this->application);
        $blockEvent->setBlock($block);
        $blockEvent->setContents($contents);
        $blockEvent->setBlockModel($blockModel);
        $this->application['dispatcher']->dispatch($event, $blockEvent);
    }

    public function dispatchFormEvent($event, $formName, $builder = null, $formData = null)
    {
        $formEvent = new Form($this->application);
        $formEvent->setBuilder($builder);
        $formEvent->setFormName($formName);
        $formEvent->setData($formData);
        $this->application['dispatcher']->dispatch($event, $formEvent);
    }

    public function dispatchFormFieldEvent($event, $formName, $fieldName, array &$fieldData, ElementInterface $element = null)
    {
        $formFieldEvent = new FormField($this->application);
        $formFieldEvent->setFormName($formName);
        $formFieldEvent->setFieldName($fieldName);
        $formFieldEvent->setFieldData($fieldData);
        $formFieldEvent->setElement($element);
        $this->application['dispatcher']->dispatch($event, $formFieldEvent);
    }

    public function dispatchCategoryEvent($event, $data, Category $category = null)
    {
        $catEvent = new CategoryEvent($this->application);
        $catEvent->setCategoryEntity($category);
        $catEvent->setData($data);
        $this->application['dispatcher']->dispatch($event, $catEvent);
    }

    public function dispatchAssetEvent($event, Asset $asset)
    {
        $assetEvent = new AssetEvent($this->application);
        $assetEvent->setAsset($asset);
        $this->application['dispatcher']->dispatch($event, $assetEvent);
    }

    public function dispatchMetadataEvent($event, MetadataEntity $entity)
    {
        $metadataEvent = new Metadata($this->application);
        $metadataEvent->setMetadata($entity);
        $this->application['dispatcher']->dispatch($event, $metadataEvent);
    }

    public function dispatchAdminUserEvent($event, AdminUser $user)
    {
        $adminUserEvent = new AdminUserEvent($this->application);
        $adminUserEvent->setUser($user);
        $this->application['dispatcher']->dispatch($event, $adminUserEvent);
    }

    public function dispatchTableEvent($event, Table $table)
    {
        $tableEvent = new TableEvent($this->application);
        $tableEvent->setTable($table);
        $this->application['dispatcher']->dispatch($event, $tableEvent);
    }

    public function dispatchCurrencyEvent($event, Currency $currency)
    {
        $currencyEvent = new CurrencyEvent($this->application);
        $currencyEvent->setCurrency($currency);
        $this->application['dispatcher']->dispatch($event, $currencyEvent);
    }
}
