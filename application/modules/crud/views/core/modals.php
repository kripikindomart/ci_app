<!-- modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div id="alert"></div>
                    <div class="form-group">
                        <label for="user">controller</label>
                        <input type="text" name="controller" id="controller" class="form-control form-control-sm" placeholder="Controller" required>
                    </div>
                    <div id="tes"></div>
                    <div class="form-group">
                        <label for="role">core</label>
                        <select name="core" id="core" class="form-control form-control-sm" required>
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                            
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>