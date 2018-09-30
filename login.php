<?php
require_once 'core/init.php';

//render the header and navigation
$title='Login';
include ('./render/resume-header.php');

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate=new Validate();
        $validation=$validate->check($_POST, array(
            'username'=>array('required'=>true),
            'password'=>array('required'=>true)
        ));

        if($validation->passed()){
            //log user in
            $user=new User();
            $remember=(Input::get('remember')==='on')?true:false;
            $login=$user->login(Input::get('username'),Input::get('password'),$remember);

            if($login){
                Redirect::to('index.php');
            }
            else{
                echo "<p class='alert alert-danger'>Sorry, logging in falied</p>";
            }
        }
        else{
            foreach($validation->errors() as $error){
                echo "<br><p class='alert alert-danger'>".$error,'</p>';
            }
        }
    }

}
?>

<main>

<div class="card card-body  justify-content-center">
    <div class="row">
    <div class="col-sm-6">
    <h5 class="card-title">Already have an account</h5>
    <p class="card-text">Please login here or  <a class="badge badge-primary float:left" href="register.php">Click here to register</a></p>
    <div class="card">
        <div class="card-body">

            <form action="" method="post">
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" autocomplete="off">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off">
                </div>

                <div  class="field">
                    <label for="remember">
                        <input type="checkbox"  name="remember" id="remember">Remember
                    </label>
                </div>

                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                <input type="submit" class="btn btn-primary" value="Log in">
            </form>

        </div>
    </div>
    </div>
</div>
</div>
</main>

<?php
//render the footer
include ('./render/resume-footer.php');
?>
