<script type="text/javascript">
    generateHierarchy();
    function generateHierarchy(selector) {
        if(selector === undefined){
            selector = '.bonsaiHierarchy';
        }
        jQuery(function () {
            $(selector).bonsai({
                expandAll: false,
                handleDuplicateCheckboxes: true,
                checkboxes: true
            });
        });
    }
    function expandCollapseHierarchy(name) {
        var element = $('#'+name+'_ol_id');
        var anchorRef = $('#'+name+'_ec_id');   //ec stands for expandCollapse
        if (anchorRef.text() === "Expand All") {
            element.bonsai('expandAll');
            anchorRef.text("Collapse All");
        } else {
            element.bonsai('collapseAll');
            anchorRef.text("Expand All");
        }
    }

</script>
