<?php include 'header.php'; ?>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Story Guidelines
                    </a>
                </li>
                <li>
                    Characters
                </li>
                <li>
                    Setting
                </li>
                <li>
                    Plot
                </li>
                <li>
                    Ending
                </li>
                <li>
                    Mystery
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Your Story</h1> 
							<div>
								<a href="#menu-toggle" class="btn btn-success" id="menu-toggle">Show Story Guidelines</a>
						    </div>
						   </br>
							<form class="form-horizontal">
								<div class="form-group">
									<label for="name" class="col-sm-1 control-label">Name</label>
									<div class="col-sm-3">
									  <input type="name" class="form-control" id="name" placeholder="Your Name">
									</div>
									<label for="school" class="col-sm-1 control-label">School</label>
									<div class="col-sm-3">
									  <input type="school" class="form-control" id="school" placeholder="Your School">
									</div>
									<label for="class" class="col-sm-1 control-label">Class</label>
									<div class="col-sm-3">
									  <input type="name" class="form-control" id="class" placeholder="Your Class">
									</div>
								</div>
								</br>
								<textarea class="story_input" placeholder="Enter Your Story Here..."></textarea>
								<div class="col-md-offset-4 col-sm-offset-4">
									<button type="submit" class="btn btn-info btn-lg">Submit Story</button>
								</div>
							</form>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
