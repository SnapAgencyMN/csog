<div class="delete_confirm">
<p>Are you sure you want to delete this question? This action cannot be reversed.</p>
<form action="<?php echo WS_URL . "admin/questions/delete/$question_id/delete/"; ?>" method="post">
  <input type="hidden" value="<?php echo $question_id; ?>" id="question_delete_id" name="question_delete_id">
  <input type="submit" value="Confirm" />
</form>
</div>
