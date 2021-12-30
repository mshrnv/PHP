<main>
    <div class="container">
        <div class="row">

            <!-- COLUMN #1 -->
            <div class="col-md-8 col-xs-12 messages">

                <!-- messages -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block">
                            <b class="card-title"><!-- .$username --></b>
                        </div>
                        <div class="d-inline-block" style="float:right;">
                            <button type="button" class="btn btn-outline-warning">Edit</button>
                            <button type="button" class="btn btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-text"><!-- .$message_text --></h5>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="d-inline-block">
                            <span><!-- .$timestamp --></span>
                        </div>
                        <div class="d-inline-block" style="float:right;">
                            <span><!-- .$ip --></span>
                        </div>
                    </div>
                </div>
                <!-- messages_ends -->
                
            </div>

            <!-- COLUMN #2 -->
            <div class="col-md-4 col-xs-12">
                <div class="modal-body p-5 pt-0">

                    <!-- SEND MESSAGE -->
                    <form>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="message" placeholder="Message text" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Message</label>
                        </div>
                        <button class="w-100 mb-2 btn btn-success btn-lg rounded-4 btn-primary" name="action" value="send" type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>