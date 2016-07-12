@if(Session::has('info'))
    <div class="modal fade" id="info_pop_route" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <p class="modal-title" id="myModalLabel">{!! Session::get('type') != 'Failure' ? 'Success' : '<span style="color:red !important;">Failure!</span>' !!}</p>
                    <h4 style="color: red;"></h4>
                </div>
                <div class="modal-body">
                    <p>{{ Session::get('info') }}</p>
                    <div class="text-right">
                        <button type="button" class="btn btn-default btn-modal" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <a class="btn btn-danger" data-dismiss="modal">Close</a>
                </div> -->
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#info_pop_route').modal('show');
        });
    </script>
@endif

<div class="modal fade" id="msgPopUp" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <p class="modal-title" id="title-label"></p>
            </div>
            <div class="modal-body">
                <p class="reason"></p>
                <div class="text-right" id="addButton">
                    <button type="button" class="btn btn-default btn-modal" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <a class="btn btn-danger" data-dismiss="modal">Close</a>
            </div> -->
        </div>
    </div>
</div>