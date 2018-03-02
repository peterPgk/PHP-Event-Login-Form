<div class="container">
<?php use Pgk\Core\Config;?>

	<?php $this->renderFeedbackMessages();?>
	<div class="container-header">
		<h1>My account</h1>
		<?php require Config::get('template_path') . 'navigation.php';?>
	</div>

    <div class="box">
        <h2>Your profile</h2>

        <div>Your username: <?= $this->username; ?></div>
        <div>Your email: <?= $this->email; ?></div>
    </div>
</div>
