<div class="card mb-4">
    <h5 class="card-header"><?php print $searchFormObject->labels->headLabel; ?></h5>
    <div class="card-body">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="<?php print $searchFormObject->labels->placeholderLabel; ?>">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button"><?php print $searchFormObject->labels->buttonLabel; ?></button>
            </span>
        </div>
    </div>
</div>