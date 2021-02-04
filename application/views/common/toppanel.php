<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<body>
		<div class="row toppanel">
			<span class="col panel" id="home">Home</span>
			<span class="col panel" id="reg">Registration</span>
			<span class="col panel" id="manage">View/Manage Admin Panel</span>
			<span class="col panel" id="logout">Logout</span>
		</div>
		<div class="row borderline">
	</div>
	</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('.panel').on('click',function(){
			$('.panel').removeClass('active');
			$(this).addClass('active');
			alert($(this).attr("Id"));
		});
	});

</script>
<style type="text/css">
	.toppanel{
		background-color: white;
		text-align:center;

	}
	.panel{
		padding: 5px;
		background-color: white;
		transition: all 0.3s ease;
		/* border-top-right-radius: 50%;
		border-top-left-radius: 50%;*/
		margin-left: :5px;
		margin-right: 5px;
		cursor: pointer;
	}
	.panel.active{
		background-image: /*linear-gradient(to right,white,#2566e1,white);*/
		linear-gradient(to right,#00cc29,#2566e1,#ffbfbf);
		color: white;
	}

</style>

</html>

