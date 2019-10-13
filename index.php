<?php
	session_start();

	// Check for account creation
	if ($_SESSION['success'] == true){
		echo '<div class="alert alert-success" name="accountSuccess">';
		echo '<strong>Success!</strong> Account created.';
		echo '</div>';
		unset($_SESSION['success']);
	}

	// Check for password reset
	if ($_SESSION['reset_success'] == true){
		echo '<div class="alert alert-success" name="passSuccess">';
		echo '<strong>Success!</strong> Password was updated successfully.';
		echo '</div>';
		unset($_SESSION['reset_success']);
	}

	// Login validation
	if (isset($_POST['email']) && isset($_POST['password'])) {
		// Check if any fields are empty
		if (empty($_POST['email']) || empty($_POST['password'])) {
			include('header.php');
			echo '<div class="alert alert-warning" name="emptyWarn">';
			echo '<strong>Warning!</strong> Email address or password cannot be empty.';
			echo '</div>';
		} else {
			$valid = false;
			// Check datastore for matching login
			include('schema.php');
			foreach($obj_account_store->fetchAll() as $obj_account) {
				if ($_POST['email'] == $obj_account->email && $_POST['password'] == $obj_account->password){
					$_SESSION['user_id'] = $obj_account->user_id;
					$valid = true;
				}
			}
			// Check if the credentials entered are valid
			if ($valid) {
				$_SESSION['logged_in'] = true;
				header("Location: account/index.php");
			} else {
				include('header.php');
				echo '<div class="alert alert-warning" name="invalidWarn">';
				echo '<strong>Warning!</strong> Invalid login details.';
				echo '</div>';
			}
		}
	// Default page layout
	} else {
		include('header.php');
	}
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Home</li>
  </ol>
</nav>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
		<h1 class="display-4 font-weight-normal text-center">Login</h1>
		<div class="card">
			<div class="card-body">
				<form action="index.php" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password">
					</div>
					<div class="form-group">
						<input type="submit" value="Submit" name="submitBtn" class="btn btn-primary float-right">
					</div>
					<div class="form-group">
						<a href="account/forgot_password.php" class="card-link" name="forgotLink">Forgot password?</a>
						<a href="account/register.php" class="card-link" name="registerLink">Register</a>
					</div>
				</form>
			</div>
		</div>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>

<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
    <div class="bg-dark mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
        <div class="my-3 py-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
    <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
        <div class="my-3 p-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
</div>

<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
    <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
        <div class="my-3 p-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
    <div class="bg-primary mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
        <div class="my-3 py-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
</div>

<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
    <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
        <div class="my-3 p-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
    <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
        <div class="my-3 py-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
</div>

<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
    <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
        <div class="my-3 p-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
    <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
        <div class="my-3 py-3">
            <h2 class="display-5">Another headline</h2>
            <p class="lead">And an even wittier subheading.</p>
        </div>
        <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
    </div>
</div>

<?php include('footer.php'); ?>
