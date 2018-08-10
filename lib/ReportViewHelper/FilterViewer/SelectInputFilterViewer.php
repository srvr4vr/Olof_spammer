<?php
namespace olof_spammer\ReportViewHelper\FilterViewer;


use olof_spammer\Interfaces;

class SelectInputFilterViewer extends FilterBaseViewer
{
    public function __construct($name, Interfaces\IReportViewHelper $helper, $title)
    {
        parent::__construct($name, $helper, $title);
        $this->fields[] = $this->nameWithPrefix;
        $this->type = "simple";
    }

    public function getHtml()
    {
        $arOption = $this->helper->getUniqueValuesFromField($this->name); ?>
        <tr>
          <td>
            <?=$this->getTitle().":"?>
          </td>
          <td>
            <? $refs =["REFERENCE" => $arOption, "REFERENCE_ID" => $arOption ]; ?>
            <? $value= htmlspecialchars($this->helper->getFieldValueByName($this->fields[0]));?>
            <?=SelectBoxFromArray($this->fields[0], $refs, $value); ?>
          </td>
        </tr>
        <?php
    }
}
