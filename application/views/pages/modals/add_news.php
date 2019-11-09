<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form id="frmAddNews" method="POST" action="<?php echo base_url(). 'api/news/add_news'; ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add News & Articles</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="row form-group">
							<div class="col-sm-6">
								<label for="inputNewsCaption">Caption</label>
								<input type="text" class="form-control" id="inputNewsCaption" name="news_caption" placeholder="Enter news caption..">
							</div>

							<div class="col-sm-6">
								<label for="inputNewsLink">Link</label>
								<input type="text" class="form-control" id="inputNewsLink" name="news_url" placeholder="Enter news URL/link.." required>
							</div>
			  		</div>
          </div>
          
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary" type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
</div>
