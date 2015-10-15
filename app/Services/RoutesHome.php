<?php

/**
 * 这里主要是写首页相关的路由
 *
 * @author jiang <mylampblog@163.com>
 */

Route::get('/', ['as' => 'blog.index.index', 'uses' => 'Home\IndexController@index']);

Route::get('/index/detail/{id}.html', ['as' => 'blog.index.detail', 'uses' => 'Home\IndexController@detail'])->where('id', '[0-9]+');

Route::get('/category/list/{categoryid}.html', ['as' => 'blog.category.list', 'uses' => 'Home\IndexController@index'])->where('categoryid', '[0-9]+');

Route::get('/tag/list/{tagid}.html', ['as' => 'blog.tag.list', 'uses' => 'Home\IndexController@index'])->where('tagid', '[0-9]+');

Route::get('/rss.xml', ['as' => 'blog.rss.index', 'uses' => 'Home\RssController@index']);

//oauth login
Route::get('/login.html', ['as' => 'blog.login', 'uses' => 'Home\MembersController@login']);
Route::get('/login_back.html', ['as' => 'blog.login.back', 'uses' => 'Home\MembersController@loginback']);
Route::get('/login_out.html', ['as' => 'blog.login.out', 'uses' => 'Home\MembersController@logout']);