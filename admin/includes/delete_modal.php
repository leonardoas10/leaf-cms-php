<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content modal-content-border">
      <div class="modal-header modal-header-border">
        <button type="button" class="close close-x-button" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">DELETE</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <form style="position:absolute; margin-left:425px " action="" method="post">
          <input type="hidden" class='modal_delete_link' name="delete_item" value=''>
          <input class="btn btn-danger delete_link" type='submit' name='delete' value='Delete'>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
