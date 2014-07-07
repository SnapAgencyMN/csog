<h2>Delete Project</h2>
<p>Are you sure you want to delete this project? This action cannot be reversed.</p>
<form action="<?php echo WS_URL ?>projects/" method="POST" id="delete-project-form">
<input type="submit" value="Delete Project" />
<input type="hidden" value="1" name="deleteConfirm">
<input type="hidden" value="<?php echo $projectID; ?>" name="projectID"> 
</form>
