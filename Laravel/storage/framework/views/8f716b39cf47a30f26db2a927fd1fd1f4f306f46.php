<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | FarmSystem</title>
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo e(asset('login/images/icons/favicon.ico')); ?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/bootstrap/css/bootstrap.min.css')); ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')); ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/animate/animate.css')); ?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/css-hamburgers/hamburgers.min.css')); ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/vendor/select2/select2.min.css')); ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/css/util.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('login/css/main.css')); ?>">
<!--===============================================================================================-->
</head>
<body>
<?php if(Session()->has('flash_login')): ?>
      <div class="col-lg-4" style="position: absolute;  right: 0%">
          <div class="alert alert-warning">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true" >&times;</button>
              <strong>Advertencia! </strong> <?php echo e(Session('flash_login')); ?>

      </div>
        </div>
<?php endif; ?>	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?php echo e(asset('login/images/img-03.png')); ?>" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="<?php echo e(route('loginFarm')); ?>" method="post">
				<?php echo csrf_field(); ?>
				<div class="js-tilt">
					<span class="login100-form-title">
						SISTEMA FARMACEUTICO <br>
						FarmSystem
					</span>
				</div>

					<div class="wrap-input100 validate-input" data-validate = "CI de usuario requerido">
						<input class="input100" type="text" name="usu_ci" placeholder="CI. de usuario" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
						 <?php if($errors->has('usu_ci')): ?>
				            <span class="invalid-feedback" role="alert">
				                <strong><?php echo e($errors->first('usu_ci')); ?></strong>
				            </span>
				        <?php endif; ?>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Contraseña requerida">
						<input class="input100" type="password" name="password" placeholder="Contraseña" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
						<?php if($errors->has('password')): ?>
				            <span class="invalid-feedback" role="alert">
				                <strong><?php echo e($errors->first('password')); ?></strong>
				            </span>
				        <?php endif; ?>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="" class="login100-form-btn">
							Ingresar
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							<!--Forgot-->
						</span>
						<a class="txt2" href="#">
							<!--Username / Password?-->
						</a>
					</div>

					
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?php echo e(asset('login/vendor/jquery/jquery-3.2.1.min.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('login/vendor/bootstrap/js/popper.js')); ?>"></script>
	<script src="<?php echo e(asset('login/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('login/vendor/select2/select2.min.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('login/vendor/tilt/tilt.jquery.min.js')); ?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.2
		})
	</script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('login/js/main.js')); ?>"></script>

</body>
</html>