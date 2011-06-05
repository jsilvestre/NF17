<?php

function display_exception(Exception $e)
{
	return '<div id="wrapper">
			<div class="box">
				<h2>Mode DEBUG</h2>
				<p class="error">
					Ligne : '.$e->getLine().'<br />
					Message : '.$e->getMessage().'<br /></p>
			</div>
		</div>';	
}