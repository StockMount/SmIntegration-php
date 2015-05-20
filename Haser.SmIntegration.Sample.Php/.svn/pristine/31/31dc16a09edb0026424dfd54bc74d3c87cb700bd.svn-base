<!DOCTYPE html>
<html lang="en">
<head runat="server">
    <meta charset="utf-8" />
    <title>StockMount SmIntegration - Php Demo</title>
    <link href="Theme/Site.css" rel="stylesheet" /> 
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <meta name="viewport" content="width=device-width" />
    
</head>
<body>
    
    <header>
        <div class="content-wrapper">
            <div class="float-left">
                <p class="site-title"><a runat="server" href="~/">StockMount Integration Sample Project</a></p>
            </div>
            <div class="float-right">
                <section id="login">
                
                </section>
                <nav>
                    
                </nav>
            </div>
        </div>
    </header>
    <div id="body">
        
        <section class="content-wrapper main-content clear-fix">
			<form name="SmIntegration" class="SmIntegration">
				<div id="Status"><h1>Welcome Project</h1><br /></div>
				<button type="button" onclick="ExecPhp(1)" class="btn btn-success">New Order</button>
				<button type="button" onclick="ExecPhp(2)" class="btn btn-success">Update Order</button>
				<button type="button" onclick="ExecPhp(3)" class="btn btn-success">Set Update Status</button>
			</form>
        </section>
    </div>
    <footer>
        <div class="content-wrapper">
            <div class="float-left">
                <p>&copy; <?php echo date("d.m.Y");?> - StockMount SmIntegration Application</p>
            </div>
        </div>
    </footer>
     <script src="Scripts/modernizr-2.6.2.js"></script>
	 <script src="Scripts/jquery-1.8.2.min.js"></script>
	 <script src="Scripts/jquery-ui-1.8.24.min.js"></script>
	 <script>
		function ExecPhp(id)
		{
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: "nCodeOperation="+id,
				dataType: "json",
				beforeSend:function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				},
				success: function(data){
					jQuery("#Status").html("<h1>"+data.message+"</h1><br/>");
				}
			});
		}
	 </script>
</body>
</html>