<?php
$app->get ('/', 'App\Controllers\Web\HomeController:index');


$app->group('/api', function() use ($app) {
// user
	$app->get('[/user]', 'App\Controllers\Api\UserController:index')
	->setName('user.index');

	$app->post('/register', 'App\Controllers\Api\UserController:register');

	$app->put('/user/update/{id}', 'App\Controllers\Api\UserController:update')->setName('user.update');

	$app->put('/user/softdelete/{id}', 'App\Controllers\Api\UserController:softDelete')->setName('user.softDelete');

    $app->put('/user/restore/{id}', 'App\Controllers\Api\UserController:restoreSoftDelete')->setName('user.restore');

	$app->delete('/user/delete/{id}', 'App\Controllers\Api\UserController:hardDelete')->setName('user.hardDelete');

	$app->get('/user/{id}', 'App\Controllers\Api\UserController:findUser')->setName('user.find');

    $app->post('/login', 'App\Controllers\Api\UserController:login')->setName('user.login');

    $app->get('/user/profile/{id}', 'App\Controllers\Api\UserController:getUserProfile');

// profile
    $app->get('/profile/{id}', 'App\Controllers\Api\ProfileController:detail')
    ->setName('profile.index');
    $app->post('/profile/add', 'App\Controllers\Api\ProfileController:add')->setName('profile.add');

    $app->put('/profile/update', 'App\Controllers\Api\ProfileController:update')->setName('profile.update');

    $app->delete('/profile/delete', 'App\Controllers\Api\ProfileController:delete')->setName('profile.delete');

// ciri fisik
    $app->get('/fisik/{id}', 'App\Controllers\Api\CiriFisikController:show');

    $app->post('/fisik/add', 'App\Controllers\Api\CiriFisikController:add');

    $app->put('/fisik/update', 'App\Controllers\Api\CiriFisikController:update');

    $app->delete('/fisik/delete', 'App\Controllers\Api\CiriFisikController:delete');

// keseharian
    $app->post('/keseharian/add', 'App\Controllers\Api\KeseharianController:add');

    $app->get('/keseharian/{id}','App\Controllers\Api\KeseharianController:show');

    $app->put('/keseharian/update', 'App\Controllers\Api\KeseharianController:update');

    $app->delete('/keseharian/delete','App\Controllers\Api\KeseharianController:delete');

// latar belakang
    $app->get('/latarbelakang/{id}', 'App\Controllers\Api\LatarBelakangController:get');

    $app->post('/latarbelakang/add', 'App\Controllers\Api\LatarBelakangController:add');

    $app->put('/latarbelakang/update', 'App\Controllers\Api\LatarBelakangController:update');

    $app->delete('/latarbelakang/delete', 'App\Controllers\Api\LatarBelakangController:delete');

// poligami
    $app->post('/poligami/add', 'App\Controllers\Api\PoligamiController:add');

    $app->get('/poligami/{id}', 'App\Controllers\Api\PoligamiController:get');

    $app->put('/poligami/update', 'App\Controllers\Api\PoligamiController:update');

    $app->delete('/poligami/delete', 'App\Controllers\Api\PoligamiController:delete');

// dipoligami
    $app->post('/dipoligami/add', 'App\Controllers\Api\DipoligamiController:add');

    $app->get('/dipoligami/{id}', 'App\Controllers\Api\DipoligamiController:get');

    $app->put('/dipoligami/update', 'App\Controllers\Api\DipoligamiController:update');

    $app->delete('/dipoligami/delete', 'App\Controllers\Api\DipoligamiController:delete');

// negara
    $app->get('/negara', 'App\Controllers\Api\NegaraController:getAll');

    $app->get('/negara/{id}', 'App\Controllers\Api\NegaraController:getById');

    $app->post('/negara/add','App\Controllers\Api\NegaraController:add');

    $app->put('/negara/update/{id}','App\Controllers\Api\NegaraController:update');

    $app->delete('/negara/delete/{id}','App\Controllers\Api\NegaraController:delete');

// provinsi
    $app->get('/provinsi', 'App\Controllers\Api\ProvinsiController:getAll');

    $app->get('/provinsi/{id}', 'App\Controllers\Api\ProvinsiController:getById');

    $app->post('/provinsi/add','App\Controllers\Api\ProvinsiController:add');

    $app->put('/provinsi/update/{id}','App\Controllers\Api\ProvinsiController:update');

    $app->delete('/provinsi/delete/{id}','App\Controllers\Api\ProvinsiController:delete');


// kota
    $app->get('/kota', 'App\Controllers\Api\KotaController:getAll');

    $app->get('/kota/{id}', 'App\Controllers\Api\KotaController:getById');

    $app->post('/kota/add','App\Controllers\Api\KotaController:add');

    $app->put('/kota/update/{id}','App\Controllers\Api\KotaController:update');

    $app->delete('/kota/delete/{id}','App\Controllers\Api\KotaController:delete');


//upload
    $app->put('/upload','App\Controllers\Api\UploadController:upload')->setName('upload');
});
