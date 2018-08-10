<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 14:02
 */
namespace olof_spammer\ReportViewHelper\FilterViewer;


use olof_spammer\Interfaces\IFilterViewer;
use olof_spammer\Interfaces\IReportViewHelper;
use olof_spammer\Interfaces;

class FilterHelper implements IReportViewHelper
{
    protected $paramPrefix = "find_";

    /**
     * @var Interfaces\ItemProviderInterface
     */
    protected $itemProvider;

    protected $findParams;

    /**
     * @property Interfaces\IFilterViewer[]
     */
    private $filters;

    public function __construct(Interfaces\ItemProviderInterface $itemProvider)
    {

        $this->itemProvider = $itemProvider;
        $this->fillFilters();
        $this->fillFindParams();

    }


    public function getFindParams()
    {
        return $this->findParams;
    }

    public function getFiltersData()
    {
        $result = [];


        foreach ($this->filters as $filter) {
            /** @var IFilterViewer $filter */
            $filterData = $filter->getFilterData();

            if ($filterData) {
                $result[] = $filterData;
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getFiltersDataEx()
    {
        $result = [];




        foreach ($this->filters as $filter) {
            /** @var IFilterViewer $filter */
            $filterData = $filter->getFilterData();
            /** @var FilterData $filterData */


            if(!$filterData) continue;


            switch ($filterData->type){
                case 'simple':
                case 'select':
                    $result['='.$filterData->name] = $filterData->arguments[0];
                    break;
                default:
                    $result['>'.$filterData->name] = $filterData->arguments[0];
                    $result['<'.$filterData->name] = $filterData->arguments[1];
                    break;

            }
        }
        return $result;
    }

    public function getFieldValueByName($name)
    {
        return $this->findParams[$name];
    }

    public function getPrefix()
    {
        return $this->paramPrefix;
    }

    public function getUniqueValuesFromField($columnName): array
    {
        return $this->itemProvider->getUniqueValuesFromField($columnName);
    }

    public function writeFilterTable()
    {
        foreach ($this->filters as $filter) {
            /** @var IFilterViewer $filter */
            $filter->getHtml();
        }
    }

    protected function fillFilters()
    {
        $filterFactory = new FormFilterFactory($this);
        $filters = $this->itemProvider->getFilters();

        foreach ($filters as $filter) {
            $this->filters[] = $filterFactory->getFilterViewer($filter->key, $filter->title, $filter->type);
        }
    }

    protected function fillFindParams()
    {
        foreach ($_GET as $key => $value) {
            if (preg_match("/" . $this->paramPrefix . "/", $key)) {
                $this->findParams[$key] = $value;
            }
        }
    }

    public function getFindFields()
    {
        return array_reduce($this->filters, function ($carry, $item) {
            /** @var IFilterViewer $item */
            $carry = array_merge($carry, $item->getFields());
            return $carry;
        }, []);
    }
}