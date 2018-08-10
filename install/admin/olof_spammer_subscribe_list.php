<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){
        history.pushState(
            {},
            '',
            location.href.replace(/\/$/, '')
        )
    })
</script>
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/olof_spammer/admin/olof_spammer_subscribe_list.php");
?>
