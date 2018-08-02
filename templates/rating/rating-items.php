<?php
/**
 * @var $page
 * @var $count
 *
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

foreach ($teams as $index => $team){
    $teams2data[]= '<div class="rating-table-item">
            <div class="row-1">
                <span class="number">'.$team['rank'].'</span>
            </div>
            <div class="row-2"> 
                
                   <div class="avatar" style=" background-image: url('. ($team['photo'] ? $team['photo'] : "/uploads/system/teams/default.jpg").')"></div>
              
                <div class="text">
                    <span class="title">'.$team['name'].'</span>
                    <span class="subtitle"> '.$team['captain'].'</span>
                </div>
            </div>
            <div class="row-3"><span class="balls">'.$team['point'].'</span></div>
        </div>';
}


$data[1] = $users2data;
$data[2] = $teams2data;
echo json_encode($data);
 ?>

