<div class="modal fade" id="ImageUploadProgress" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <p class="modal-title" id="myModalLabel">Your picture is getting uploaded, please wait</p>
            </div>
            <div class="modal-body">
              
                <div class="progress">
                    <!-- <div id="UploadPercent" class="text-center"></div> -->
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="percent" style="width:0%">Loading</div>            
                </div>
                <div class='uil-ring-css center-block' style='transform:scale(0.15);'></div>
                <div class="text-right">
                    <button type="button" class="btn btn-default btn-modal" id="cancelUpload">Cancel</button>
                    <button style="display: none;" id="revertUploadFile" class="btn btn-default btn-modal">Revert</button>
                    <button style="display: none;" id="saveUploadFile" class="btn btn-default btn-modal">Save</button>
                </div>      
            </div>
           <!-- <div class="modal-footer">
                <button class="btn btn-default btn-md btn-e-cancel" id="cancelUpload">Cancel</button>
                
            </div> -->
        </div>
    </div>
</div>