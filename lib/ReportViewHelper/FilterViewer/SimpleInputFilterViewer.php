<?php
namespace olof_spammer\ReportViewHelper\FilterViewer;

use olof_spammer\Interfaces;

class SimpleInputFilterViewer extends FilterBaseViewer
{
    public function __construct($name, Interfaces\IReportViewHelper $helper, $title)
    {
        parent::__construct($name, $helper, $title);
        $this->fields[] = $this->nameWithPrefix;
        $this->type = "simple";
    }

    public function getHtml()
    {
        ?>
        <tr>
          <td>
            <?=$this->getTitle().":"?>
          </td>
          <td>
              <input type="text" name="<?=$this->fields[0]?>" size="47" value="<?=htmlspecialchars($this->helper->getFieldValueByName($this->fields[0]))?>">
          </td>
        </tr>
        <?php
    }
}
