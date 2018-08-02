<?php
/**
 * @var $page
 * @var $count
 */
$users2data = []; $teams2data=[];

foreach ($users as $index => $user){
    $users2data[]= '<div class="rating-table-item">
        <div class="row-1">
            <span class="number">'.$user['rating']['rank'].'</span>
        </div>
        <div class="row-2">
            <div class="avatar" style="background-image: url('.$user['photo_small'].'"></div>
            <div class="text">
                <span class="title">'.$user['first_name'].' '.$user['last_name'].'</span>
                <span class="subtitle">'.$user['team'].'</span>
            </div>
        </div>
        <div class="row-3"><span class="balls">'.($user['rating']['balls'] ? $user['rating']['balls'] : 0).'</span></div>
    </div>
        ';
}



$data = ['0'=>$users2data, '1'=>$teams];
echo json_encode($data);
 ?>

