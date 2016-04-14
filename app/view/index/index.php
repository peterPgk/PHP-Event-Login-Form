<?php use Pgk\Core\Config;?>
<div class="container">

	<?php $this->renderFeedbackMessages();?>
	<div class="container-header">
		<h1>Index page</h1>
		<?php require Config::get('template_path') . 'navigation.php';?>
	</div>

    <div class="box" style="min-height: 150px;">
        <p>
            This is the homepage.
        </p>
    </div>
</div>
