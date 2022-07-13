<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<!-- <img src="../gallery/21.jpg" alt="bootstrap 4 login page"> -->
						<img src="../assets/img/bootstrap/bootstrap.svg" alt="Bootstrap" width="32" height="32">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							<?php
								if (is_array($error))
								{
										echo "<div class = 'alert alert-danger' role = 'alert'><strong>";
										foreach ($error as $err)
										{
												echo $err.'<br>';
										}
										unset($error);
										echo "</strong></div>";
								}
							?>
							<form method="POST" action="/register" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="name">First Name</label>
									<input id="name" type="text" class="form-control" name="first-name" value = "<?php echo $first_name?>" required autofocus>
									<div class="invalid-feedback">
										First name is needed
									</div>
								</div>

                                                                <div class="form-group">
									<label for="name">Last Name</label>
									<input id="name" type="text" class="form-control" name="last-name" value = "<?php echo $last_name?>" required autofocus>
									<div class="invalid-feedback">
										Last name is needed
									</div>
								</div>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value = "<?php echo $email?>" required>
									<div class="invalid-feedback">
										Your email is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
										<label for="agree" class="custom-control-label">I agree to the <a href="#">Terms and Conditions</a></label>
										<div class="invalid-feedback">
											You must agree with our Terms and Conditions
										</div>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" id="register-btn" name="register" class="btn btn-primary btn-block">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="/login">Login</a>
								</div>
							</form>
						</div>
					</div>