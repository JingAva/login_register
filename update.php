<?php
require_once 'core/init.php';

//render the header and navigation
$title='Update my details';
include ('./render/resume-header.php');

$user=new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        //echo "ok";
        $validate=new Validate();
        $validataion=$validate->check($_POST,array(
            'name'=>array(
                'required'=>true,
                'min'=>2,
                'max'=>50
            )
        ));

            if($validataion->passed()){
                //update
                try{
                    $user->update(array(
                        'name'=>Input::get('name')
                    ));

                    Session::flash('home','Your details have beed updated.');
                    Redirect::to('index.php');
                }catch(Exception $e){
                    die($e->getMessage());
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
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?php echo escape($user->data()->name);?>">

                    <input type="submit" value="Update">
                    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                </div>
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