<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<?php include("header.php");?>
<body class="bg-lite" >
	<div class="container">
		<div class="py-5 text-center">
			<div class="row">
				<div class="col">
					<img src="https://www.dospeedtest.com/blogs/wp-content/uploads/2018/11/IMG_E55C3B-C0EEC1-62E592-EACAF4-204ED5-B4956F.jpg" alt="Responsive image">
				</div>
				<div class="col px-5">
				<h2>Login <i class="fas fa-sign-in-alt"></i></h2>

				<div class="row py-2">
					<label for="userName">User Name</label>
						<input type="text" class="form-control" id="userName" placeholder="" value="" required>
            			<div class="invalid-feedback">
             			 Valid User name is required.
            			</div>
            	</div>
            	<div class="row py-2">
					<label for="password">Password</label>
						<input type="password" class="form-control" id="password" placeholder="" value="" required>
            			<div class="invalid-feedback">
             			 Password is required.
            			</div>
            	</div>
            	<div class="row py-2">
            		<label for="loginType">Account Type</label>
					<select class="form-control" id="loginType">
  					<option>Consumer</option>
  					<option>Staff</option>
					</select>
				</div>
				<div class="row py-2 mt-3">
            		<button class="btn btn-primary btn-block" id="btnLogin"><i class="fas fa-sign-in-alt"></i> Login</button>
            	</div>
            	</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#btnLogin').on('click',function(){
			//alert('Clicked');
			tryLogin();
		});
	});
	function tryLogin(){
		var url='<?= base_url();?>' + 'index.php/Main/login';
		var uname= $('#userName').val();
		var pass= $('#password').val();
		var logtype=$('#loginType').val();

		$.ajax({
			url : url,
			type:'POST',
			data :{username:uname,password:pass,logtype:logtype},
			success: function(response){
				if(response!='Fail'){
					//alert(response);
					url='<?= base_url();?>' + 'index.php/Main/dashboard';
				window.location=url;
				}
				else
					alert('Customer not exists');
			},
			error: function(){
				alert('Error calling function');
			}
		});
	}
</script>
</body>
</html>