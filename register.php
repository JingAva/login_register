<?php
require_once 'core/init.php';

//render the header and navigation
$title='Register';
include ('./render/resume-header.php');

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        // echo Input::get('username');
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' =>true,
                'min' => 6
            ),
            'confirmedpassword' => array(
                'required' =>true,
                'matches' =>'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
            ));

        if($validation->passed()){
            $user=new User();

            $salt=Hash::salt(32);

            try{
                $user->create(array(
                    'username'=>Input::get('username'),
                    'password'=>Hash::make(Input::get('password'),$salt),
                    'salt'=>$salt,
                    'name'=>Input::get('name'),
                    'joined'=>date('Y-m-d H:i:s'),
                    'group'=>1
                ));

                Session::flash('home','You have beed registered and can not log in!');
                Redirect::to('index.php');

            }catch(Exception $e){
                die($e->getMessage());
            }
            //echo 'passed';
        } else {
            //output errors
            // print_r($validation->errors());
            foreach($validation->errors() as $error){
                echo $error,"<br>";
            }
        }
    }
}
?>

<main >

<div class="card card-body  justify-content-center">

    <div class="col-sm-6">
        <h2 class="card-title">New user</h2>
        <p class="card-text">Please fill in the following form to register or <a class="badge badge-primary float:left" href="login.php">Click here to login</a></p>
        <div class="card">
        <div class="card-body">

            <form action="" method="post">
                <div class="field">
                    <label for="labelusername">UserName</label>
                    <input type="text" class="form-control" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomlete="off">

                </div>

                <div calss="field">
                    <label for="labelpassword">Enter password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>

                <div calss="field">
                    <label for="labelpassword_again">Confirm password</label>
                    <input type="password" class="form-control" name="confirmedpassword" id="confirmedpassword">
                </div>

                <div calss="field">
                    <label for="labelname">Enter your name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo escape(Input::get('name'));?>" id="name">
                </div>
                <!---->
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                <br>
                <input type="submit" class="btn btn-primary" value="Register">

            </form>
        </div>
        <div>
    </div>

</div>
</main>

<?php
//render the footer
include ('./render/resume-footer.php');
?>