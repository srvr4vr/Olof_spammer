<?php
namespace olof_spammer\ReportViewHelper\FilterViewer;

use olof_spammer\Interfaces;

class DateInputFilter extends DateFilterBaseViewer
{
    public function __construct($name, Interfaces\IReportViewHelper $helper, $title, $ignoreYear=false)
    {
        parent::__construct($name, $helper, $title);
        $this->type = $ignoreYear ? "datex": "date";
    }

    public function getHtml()
    {
        ?>
        <tr>
          <td>
            <?=$this->getTitle().":"?>
          </td>
          <td><?=CalendarPeriod(
            $this->fields[0],
            htmlspecialchars($this->helper->getFieldValueByName($this->fields[0])),
            $this->fields[1],
            htmlspecialchars($this->helper->getFieldValueByName($this->fields[1])),
            "find_form",
            "Y"
        )?>
          </td>
        </tr>
      <?php
    }
}


