<?php
use Pgk\Core\Auth;
use Pgk\Core\Config;?>
<div class="container">

	<?php $this->renderFeedbackMessages();?>
	<div class="container-header">
		<h1>Index page</h1>
		<?php require Config::get('template_path') . 'navigation.php';?>
	</div>

    <div class="box" style="min-height: 150px;">
        <p>
            This is the homepage.


        <h4>Search repositories</h4>

        <p>You can search repos from here</p>
        <p>You must construct search query ?? using several options</p>
        <ul>
            <li><span>phrase</span>What you want to search?</li>
            <li><span>results_per_page</span>Number of returned results? (default 25)</li>
            <li><span>sort_by</span>Field to sort by</li>
        </ul>

        <h4>Example</h4>
        <p>phrase=laravel&results_per_page=15&sort_by=forks</p>

        <form action="/index/search" method="post">
            <input type="text" name="phrase" placeholder="Phrase to search" required />
            <input type="hidden" name="csrf_token" value="<?= Auth::makeToken(); ?>" />
            <input type="submit" class="login-submit-button" value="Search"/>
        </form>
        </p>
    </div>
</div>
