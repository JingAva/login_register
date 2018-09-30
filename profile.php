<?php 
require_once 'core/init.php';

if(!$username=Input::get('user')){
    Redirect::to('index.php');
}
else{
    $user=new User($username);
    if(!$user->exists()){
        Redirect::to(404);
    }else{
        $data=$user->data();
    }

?>
    
<?php
//render the header and navigation
$title='Profile';
include ('./render/resume-header.php');
?>

<main>

<div class="card card-body  justify-content-center">

    <div class="col-sm-6">
    <div class="card">
        <div class="card-body">
        <h3><?php echo escape($data->username);?></h3>
        <p>Full name: <?php echo escape($data->name);?></p>

<?php
}
?>

        </div>
    <div>
    </div>

</div>
</main>

<?php
//render the footer
include ('./render/resume-footer.php');
?>




