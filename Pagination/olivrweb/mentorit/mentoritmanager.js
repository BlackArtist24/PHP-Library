$(document).ready(function(){
	if(window.location.pathname.split("/").pop() == "mentorit" || window.location.pathname.split("/").pop() == "dashboard" || window.location.pathname.split("/").pop() == "theme"){
		adminuid=localStorage.getItem('adminuid');
		if(adminuid==1 && window.location.pathname.split("/").pop() == "mentorit"){
			
		}else if(adminuid==2 && window.location.pathname.split("/").pop() == "dashboard"){
			
		}else if(adminuid==3 && window.location.pathname.split("/").pop() == "theme"){
			
		}else{
			location.href="adminlogin.html";
		}
    }
})
function admindashboardlogin() {
	$username = $('#username').val(); 
	$password = $('#userpassword').val();
	$.ajax({
		url: "olivrweb/mentorit/mentoritlogin.php",
		type: "POST",
		data: {
			username: $username,
			password: $password,
		},
		success: function(data) {
			obj = JSON.parse(data);
			if (obj.status === true) {
				$('.loginmodal').modal('hide');
				if(obj.admindata.type=="admin"){
					localStorage.setItem('adminuid',obj.admindata.id);
					location.href="mentorit.html";
				}else if(obj.admindata.type=="dashboard"){
					localStorage.setItem('adminuid',obj.admindata.id);
					location.href="dashboard.html";
				}else if(obj.admindata.type=="theme"){
					localStorage.setItem('adminuid',obj.admindata.id);
					location.href="theme.html";
				}else{
					$("#success_div").html(obj.message);
					$("#success_div").show();
					setTimeout(function(){ 
						$("#success_div").hide();
					}, 3000);
				}
			} else {
				$("#alert_div").html(obj.message);
				$("#alert_div").show();
				setTimeout(function(){ 
					$("#alert_div").hide();
				}, 3000);
			}
		}
	})
}