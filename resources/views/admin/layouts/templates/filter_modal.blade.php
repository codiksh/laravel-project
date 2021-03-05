<div class="modal fade" id="modal-xl" style="display: none;">
    <div class="modal-dialog modal-xl" style="max-width: 1300px;">
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <h4 class="modal-title">Apply Filter</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                @include($fieldBlade)
            </div>
            <div class="modal-footer justify-content-between">
                <div class="row w-100">
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Apply</button>
                    </div>
                    <div class="col-sm-8 text-right">
                        @if(isset($reset) && $reset)
                        <button type="button" class="btn btn-default bg-primary pull-left" onclick="setDefaults()">
                            <i class="fas fa-sync" aria-hidden="true"></i> Reset
                        </button>
                        @endif
                        <button type="button" class="btn btn-default bg-red pull-left clear-filter-class">
                            <i class="fas fa-filter" aria-hidden="true"></i> Clear Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
