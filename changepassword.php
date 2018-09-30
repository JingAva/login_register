<?php
require_once 'core/init.php';

//render the header and navigation
$title='Change password';
include ('./render/resume-header.php');

$user=new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate=new Validate();
        $validation=$validate->check($_POST,array(
            'password_current'=>array(
                'required'=>true,
                'min'=>6
            ),
            'password_new'=>array(
                'required'=>true,
                'min'=>6
            ),
            'password_new_again'=>array(
                'required'=>true,
                'min'=>6,
                'matches'=>'password_new'
            )
            ));

        if($validation->passed()){
            //change of password
            if(Hash::make(Input::get('password_current'),$user->data()->salt)!==$user->data()->password){
                echo "<br><p class='alert alert-danger'>Your current password is wrong</p>";
            }
            else{
                $salt=Hash::salt(32);
                $user->update(array(
                    'password'=> Hash::make(Input::get('password_new'),$salt),
                    'salt'=> $salt
                ));

                Session::flash('home','Your password has been changed!');
                Redirect::to('index.php');
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

    <div class="col-sm-6">
    <div class="card">
        <div class="card-body">

            <form action="" method="post">

                <div calss="field">
                    <label for="password_current">Current password</label>
                    <input type="password" name="password_current" id="password_current">
                </div>

                <div calss="field">
                    <label for="password_new">New password</label>
                    <input type="password" name="password_new" id="password_new">
                </div>

                <div calss="field">
                    <label for="password_new_again">New password again</label>
                    <input type="password" name="password_new_again" id="password_new_again">
                </div>
                
                <input type="submit" class="btn btn-primary" value="Change">
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">

            </form>

        </div>
    </div>
    </div>

</div>
</main>

<footer id="main-footer">
  Copyright &copy; 2018
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
