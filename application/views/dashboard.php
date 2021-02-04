<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<?php include("common/header.php");?>

<?php $firebaseConfig=json_decode($firebaseConfig);?>

<body class="bg-lite" >
		<div class="row toppanel">
			<span class="col panel active" id="home">Home</span>
			<span class="col panel" id="reg">Registration</span>
			<span class="col panel" id="manage">View/Manage Employees</span>
			<span class="col panel" id="logout">Logout</span>
		</div>
		<div class="row borderline">
	</div>

	<div class="container">

<!--HEADER DIV START -->
		<div class="py-5 text-center home_div" id='homeDiv' >
		<h2>Admin Dashboard </h2>
		<img src="<?=$_SESSION['PHOTO']?>" style="width: 75px;height: 75px">
		<p>
		<h1 class='animate__animated animate__rubberBand'>Welcome <?php echo $_SESSION['NAME'];?></h1></p>
		<?= $firebaseConfig ?>
		</div>

<!--HEADER DIV END -->

<!--SEARCH DIV START-->
		<div class="py-5 text-center animate__animated animate__bounceIn" style="display: none" id="searchDiv">
			<div class="row py-2">
					<label for="seachBox">Staff ID / Name</label>
						<input type="text" class="form-control" id="search" placeholder="" value="" required>
            			<div class="invalid-feedback">
             			 Valid User name is required.
            			</div>
            	</div>
            <div class="row py-2 mt-3">
            		<button class="btn btn-primary btn-block" id="btnSearch"><i class="fas fa-search"></i> Search</button>
            </div>

            <!--RESULTS DIV START-->
		<div class="mt-3" style="display: none" id="resultsDiv1">
			<h5>Results found</h5>
			<ul class="list-group">
  				<li class="list-group-item">Cras justo odio</li>
  				<li class="list-group-item">Dapibus ac facilisis in</li>
 				<li class="list-group-item">Morbi leo risus</li>
  				<li class="list-group-item">Porta ac consectetur ac</li>
 				<li class="list-group-item">Vestibulum at eros</li>
			</ul>
		</div>
<!--RESULTS DIV END-->
		
			<div class="row text-left mt-3"  style="display: none" id="resultsDiv">

			</div>
		</div>
<!--SEARCH DIV END-->


<!--REG DIV START-->
		<div class="py-5 text-center animate__animated animate__bounceIn" style="display: none" id="formDiv">
			<div class="row">
				<div class="col">
					<img src="https://www.dospeedtest.com/blogs/wp-content/uploads/2018/11/IMG_E55C3B-C0EEC1-62E592-EACAF4-204ED5-B4956F.jpg" alt="Responsive image">
				</div>
				<div class="col px-5">
				<h2>Registration <i class="fas fa-user-plus"></i> </h2>

				<div class="row py-2">
					<label for="userName">Full Name</label>
						<input type="text" class="form-control" id="userName" placeholder="" value="" required>
            			<div class="invalid-feedback">
             			 Valid User name is required.
            			</div>
            	</div>
            	<div class="row py-2">
					<label for="phone">Phone</label>
						<input type="tel" pattern="[1-9]{1}[0-9]{9}" class="form-control" id="phone" placeholder="" value="">
            			<div class="invalid-feedback">
             			 Valid User name is required.
            			</div>
            	</div>
         			<div class="row py-2">
					<label for="userName">Email</label>
						<input type="email" class="form-control" id="email" placeholder="" value="" required>
            			<div class="invalid-feedback">
             			 Valid User name is required.
            			</div>
            	</div>
            	<div class="row py-2">
            		<label for="gender">Gender</label>
					<select class="form-control" id="gender">
  					<option>Male</option>
  					<option>Female</option>
					</select>
				</div>
            	<div class="row py-2">
            		<label for="roleType">Role Type</label>
					<select class="form-control" id="roleType">
  					<option>Admin</option>
  					<option>Staff</option>
					</select>
				</div>
				<div class="row py-2 mt-3">
            		<button class="btn btn-primary btn-block" id="btnRegister"><i class="fas fa-plus-circle"></i> Register</button>
            	</div>
            	</div>
			</div>
		</div>
<!--REG DIV END-->

	</div>
	<input id='hid_uid' value="<?= $_SESSION['ADMIN_ID'];?>" style="display: none">
	<input id='hid_fbase' value="<?= $firebaseConfig ?>" style="display: none">
	<input id='base_url' value="<?= base_url();?>" style="display: none">
<?php include("common/footer.php");?>
<script type="text/javascript">

var firebaseConfig2 = {
	apiKey: "AIzaSyAojy8SsvhdRz4uMqTiv8SeqH4IkX5_Ers",
    authDomain: "wfh-manager-web.firebaseapp.com",
    databaseURL: "https://wfh-manager-web-default-rtdb.firebaseio.com",
    projectId: "wfh-manager-web",
    storageBucket: "wfh-manager-web.appspot.com",
    messagingSenderId: "79627324857",
    appId: "1:79627324857:web:a78e760b94fdb7ead9fa68"
    };

    // Initialize Firebase
    //firebase.initializeApp(firebaseConfig);


  var userid=$('#hid_uid').val();
  var firebaseConfig = $('#hid_fbase').val();
  console.log(firebaseConfig);
  if(firebaseConfig!==undefined){
	firebase.initializeApp(firebaseConfig);
					alert(getFirebaseConfig());
					console.log(firebaseConfig);
					var database = firebase.database();
	database.ref('/user_activity/'+userid).once('value').then((snapshot) => {
  var testData = snapshot.val();
console.log(JSON.stringify(testData)+userid);
updateUserStatus(true);
var online = database.ref('/user_activity/'+userid+'/is_online/')
online.onDisconnect().set(false);
  // ...
});

  }
  
function updateUserStatus(st) {
	var userid=$('#hid_uid').val();
 database.ref('user_activity/'+userid).set({
    is_online:st
  });
}



function deleteStaff(staffid){
			if(staffid=='SH001'){
				alert('Cannot delete');
			}
			else{
			url='<?= base_url();?>' + 'index.php/AdminController/deleteStaff/'+staffid;
			$.ajax({
			url : url,
			type:'POST',
			success: function(response){
				if(response=="Success"){
					alert("Success");
					findStaff();
				}
				else
					alert('Fail');
			},
			error: function(){
				alert('Error calling function');
			}
		});
		}
		}

		$(document).ready(function(){
		$('.panel').on('click',function(){
			$('.panel').removeClass('active');
			$(this).addClass('active');
			//alert($(this).attr("Id"));
		});

		$('#logout').on('click',function(){
			url='<?= base_url();?>' + 'index.php/Main/Logout';
			window.location=url;
		});
		$('#home').on('click',function(){
			$('#homeDiv').show();
			$('#formDiv').hide();
			$('#searchDiv').hide();
			$('#resultsDiv').hide();
		});
		$('#reg').on('click',function(){
			$('#homeDiv').hide();
			$('#formDiv').show();
			$('#searchDiv').hide();
			$('#resultsDiv').hide();
		});
		$('#manage').on('click',function(){
			$('#homeDiv').hide();
			$('#formDiv').hide();
			$('#searchDiv').show();
			$('#resultsDiv').hide();
		});
		
		$('#btnSearch').on('click',function(){
			findStaff();
				$('#homeDiv').hide();
			$('#resultsDiv').fadeIn();
		});
		$('#btnRegister').on('click',function(){
			tryRegister();
			});
	});
		function tryRegister(){
			var staff_name= $('#userName').val();
			var phone= $('#phone').val();
			var email= $('#email').val();
			var role= $('#roleType').val();
			var gender= $('#gender').val();
			var url='<?= base_url();?>' + 'index.php/AdminController/Register';

			$.ajax({
			url : url,
			type:'POST',
			data :{staffname:staff_name,phone:phone,email:email,role:role,gender:gender},
			success: function(response){
				if(response!='Fail'){
					alert('Successfully Registered');
					/* url='<?= base_url();?>' + 'index.php/Main/dashboard';
				window.location=url;*/
				}
				else
					alert('Registration failed');
			},
			error: function(){
				alert('Error calling function');
			}
		});
		}

		function findStaff(){
			var keyword= $('#search').val();
			var url='<?= base_url();?>' + 'index.php/AdminController/searchstaff';

			$.ajax({
			url : url,
			type:'POST',
			data :{keyword:keyword},
			success: function(res){
				var result=JSON.parse(res);
				if(result.response==true){
					console.log(result.data);
					$('#resultsDiv').html(result.content);
					result.data.forEach((user)=>{
						setOnlineStatus(user.ADMIN_ID);
					});
					$('#resultsDiv').fadeIn();
					/* url='<?= base_url();?>' + 'index.php/Main/dashboard';
				window.location=url;*/
				}
				else
					alert('No response from server');
			},
			error: function(){
				alert('Error calling function');
			}
		});
		}

function setOnlineStatus(userid)
{
	database.ref('/user_activity/'+userid+'/is_online').once('value').then((snapshot) => {
  var read_status = snapshot.val();
var status_icon=(read_status)?'<i class="fas fa-check-circle" style="color:green"></i>':'<i class="fas fa-clock" style="color:#97ff00"></i>';

$('#user_status_'+userid).html(status_icon);
});
}
</script>
<style type="text/css">

	.btn-manage{
		border: none;
		 all: unset;
  		cursor: pointer;
  		transition:all 0.5s ease;
	}
	.btn-manage:hover{;
		color: #007bff;
	}
	.profile_card{
		background-color: white;
		border-radius: 20px;
		border: solid 1px #007bff;
		box-sizing: border-box;
		box-shadow: 3px 4px 5px -2px rgb(158, 158, 158);
		transition:all 0.1s ease;
	}
	.profile_card:hover{

		box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
	}
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
</body>
</html>