<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 13:45
 */

namespace olof_spammer\ReportViewHelper;

use olof_spammer\ReportViewHelper\FilterViewer;
use olof_spammer\Interfaces;
use olof_spammer;
use olof_spammer\ReportViewHelper\FilterViewer\FilterHelper;


class SubscriberReportViewer
{
    /**
     * @var FilterViewer\FilterHelper
     */
    protected $filterHelper;


    /**
     * @var Interfaces\ItemProviderInterface
     */
    protected $itemProvider;
    /**
     * @var array
     */
    protected $get;
    /**
     * @var string
     */
    private $sTableID;
    private $oSort;
    private $lAdmin;
    private $arOrder;
    protected $filter;

    public function __construct(array $get, string $sTableID)
    {
        $this->get = $get;
        $this->sTableID = $sTableID;

        $this->arOrder = ($get['by'] && $get['order'])
            ? $arOrder = [$get['by'] => $get['order']]
            : array();


        $this->itemProvider = new olof_spammer\SubscriberReportProvider();


        $this->oSort = new \CAdminSorting($this->sTableID, "ID", "desc");
        $this->lAdmin = new \CAdminList($this->sTableID, $this->oSort);
        $this->filterHelper = new FilterHelper($this->itemProvider);

        $isFilterSet = $_GET['set_filter'] == "Y";

        $this->filter = ($isFilterSet) ? $this->filterHelper->getFiltersDataEx() : array();


        $FilterArr = $this->filterHelper->getFindFields();


        $this->lAdmin->InitFilter($FilterArr);

    }

    public function getAdminList()
    {
        return $this->lAdmin;
    }

    protected function setHeader()
    {
        $arHeaders = [];
        foreach ($this->itemProvider->getMap() as $column) {
            $arHeaders[] = $column->asArray();
        }


        $this->lAdmin->AddHeaders($arHeaders);
    }

    public function fillAdminTable()
    {
        $isFilterSet = $_GET['set_filter'] == "Y";
        $rsData = $this->itemProvider->getList($this->filter, $this->arOrder);

        $rsData = new \CAdminResult($rsData, $this->sTableID);
        $rsData->NavStart();


        $this->lAdmin->NavText($rsData->GetNavPrint("Элементы"));
        $this->setHeader();

        while ($arRes = $rsData->Fetch()) {
            $row = &$this->lAdmin->AddRow($arRes['id'], $arRes);
        }
    }

    public function getFilterForm($formName, $actionUrl)
    {
        $filters = $this->itemProvider->getFilters();
        if (!$filters) return;
        ?>
    <form name="<?= $formName ?>" method="get" action="<?= $actionUrl; ?>">
        <?
        $oFilter = new \CAdminFilter(
            $this->sTableID . "_filter",
            array_map(
                function ($item) {
                    return $item->title;
                }, $filters)
        );


        $oFilter->Begin();
        $this->filterHelper->writeFilterTable();
        $oFilter->Buttons(array("table_id" => $this->sTableID, "url" => $actionUrl, "form" => $formName));
        $oFilter->End();

        echo '</form>';
    }

}