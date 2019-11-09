<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form id="frmAddEvent" method="POST" action="<?php echo base_url(). 'api/events/add_event'; ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
						<div class="row form-group">
							<div class="col-sm-12">
								<label for="inputEventName">Event Name</label>
								<input type="text" class="form-control" id="inputEventName" name="event_name" placeholder="Enter event name.." required>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-12">
								<label for="inputEventDetails">Details</label>
								<textarea class="form-control" rows="5" id="inputEventDetails" name="event_details" placeholder="Write event details.." style="resize: none;" required></textarea>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-6">
								<label for="inputEventVenue">Venue</label>
								<input type="text" class="form-control" id="inputEventVenue" name="event_venue" placeholder="Enter event venue.." required>
							</div>

							<div class="col-sm-6">
								<label for="inputEventSchedule">Schedule</label>
								<input type="text" class="form-control" id="inputEventSchedule" name="event_schedule" placeholder="Enter event schedule.." required>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-6">
								<label for="inputEventImage">Event Image</label>
								<input type="file" name="event_img" id="inputEventImage" accept="image/png, image/jpeg, image/jpg" required />
							</div>

							<div class="col-sm-6">
								<label for="inputEventFee">Fee</label>
								<input type="text" class="form-control" id="inputEventFee" name="event_fee" placeholder="Enter event fee.." required>
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
