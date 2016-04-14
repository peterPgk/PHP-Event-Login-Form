<div class="container">

    <h1>Verification</h1>
    <div class="box">

        <?php use Pgk\Core\Config;

        $this->renderFeedbackMessages(); ?>

        <a href="<?php echo Config::get('url'); ?>">Go back to home page</a>
    </div>

</div>
