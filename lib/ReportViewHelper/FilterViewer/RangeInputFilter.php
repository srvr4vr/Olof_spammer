<?php
namespace olof_spammer\ReportViewHelper\FilterViewer;

use olof_spammer\Interfaces;

class RangeInputFilter extends RangeFilterBaseViewer
{
    public function __construct($name, Interfaces\IReportViewHelper $helper, $title)
    {
        parent::__construct($name, $helper, $title);
        $this->type = "range";
    }


    public function getHtml()
    {
        ?>
      <tr>
        <td>
          <?=$this->getTitle()." (начало и конец):"?>
        </td>
        <td>
            <input type="text" name="<?=$this->fields[0]?>" size="47"
                value="<?=htmlspecialchars($this->helper->getFieldValueByName($this->fields[0]))?>">
            <span class="adm-filter-text-wrap">...</span>
            <input type="text" name="<?=$this->fields[1]?>" size="47"
                value="<?=htmlspecialchars($this->helper->getFieldValueByName($this->fields[1]))?>">
        </td>
      </tr>
      <?php
    }
}
