<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';

$id  = (int)$_GET['id'];
$get = categories_by_id($id);
if(!$get) {
    redirect('/');
}

$title = $get['name'];
$tab   = 'category';

require '../connect/header.php';

include './more/cat.php';
?>

<h1 class="cat_title">Thể Loại <span><?=$title?></span></h1>
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <form>
                <input type="hidden" name="id" value="'.$id.'">
                <div class="flexRow mt-2">
                    <div class="flex1"><input type="text" name="search" class="form-control" placeholder="Tìm trong thư mục..." value="<?= sanitize_xss($_GET['search']??'') ?>"></div>
                    <div class="pl-2"><button class="btn btn-info" type="submit"><i class="fal fa-search fa-fw"></i></button></div>
                </div>
            </form>

            <div class="my-2"><b><?=$total?></b> kết quả.</div>
            <div class="row"><?=card_cat()?></div>'
            <?=page_cat()?>

        </div>
    </div>
</div>

<?php
require '../connect/footer.php';