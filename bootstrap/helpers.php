<?php

if(!function_exists('route_class')){
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

if(!function_exists('make_excerpt')){
    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return str_limit($excerpt, $length);
    }
}

if (!function_exists('manage_contents')) {
    function manage_contents()
    {
        return Auth::check() && Auth::user()->can('manage_contents');
    }
}

if (!function_exists('manage_users')) {
    function manage_users()
    {
        return Auth::check() && Auth::user()->can('manage_users');
    }
}

if (!function_exists('administrator_users_avatar')) {
    function administrator_users_avatar($avatar, $model)
    {
        return empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" width="40">';
    }
}

if (!function_exists('administrator_users_name')) {
    function administrator_users_name($name, $model)
    {
        return '<a href="/users/'.$model->id.'" target=_blank>'.$name.'</a>';
    }
}

if (!function_exists('role_permissions_output')) {
    function role_permissions_output($value, $model) {
        $model->load('permissions');
        $result = [];
        foreach ($model->permissions as $permission) {
            $result[] = $permission->name;
        }

        return empty($result) ? 'N/A' : implode($result, ' | ');
    }
}

if (!function_exists('role_operation_output')) {
    function role_operation_output($value, $model) {
        return $value;
    }
}

if (!function_exists('has_role_founder')) {
    function has_role_founder(){
        // 只有站长才能删除话题分类
        return Auth::user()->hasRole('Founder');
    }
}

if (!function_exists('topic_title_output')) {
    function topic_title_output($value, $model) {
        return '<div style="max-width:260px">' . model_link($value, $model) . '</div>';
    }
}

if (!function_exists('topic_user_output')) {
    function topic_user_output($value, $model) {
        $avatar = $model->user->avatar;
        $value = empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" style="height:22px;width:22px"> ' . e($model->user->name);
        return model_link($value, $model->user);
    }
}

if (!function_exists('topic_category_output')) {
    function topic_category_output($value, $model) {
        return model_admin_link(e($model->category->name), $model->category);
    }
}

if (!function_exists('model_admin_link')) {
    function model_admin_link($title, $model)
    {
        return model_link($title, $model, 'admin');
    }
}

if (!function_exists('model_link')) {
    function model_link($title, $model, $prefix = '')
    {
        // 获取数据模型的复数蛇形命名
        $model_name = model_plural_name($model);

        // 初始化前缀
        $prefix = $prefix ? "/$prefix/" : '/';

        // 使用站点 URL 拼接全量 URL
        $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

        // 拼接 HTML A 标签，并返回
        return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
    }
}

if (!function_exists('model_plural_name')) {
    function model_plural_name($model)
    {
        // 从实体中获取完整类名，例如：App\Models\User
        $full_class_name = get_class($model);

        // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
        $class_name = class_basename($full_class_name);

        // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
        $snake_case_name = snake_case($class_name);

        // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
        return str_plural($snake_case_name);
    }
}

if (!function_exists('replay_content_output')) {
    function replay_content_output($value, $model) {
        return '<div style="max-width:220px">' . $value . '</div>';
    }
}

if (!function_exists('replay_user_output')) {
    function replay_user_output($value, $model) {
        $avatar = $model->user->avatar;
        $value = empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" style="height:22px;width:22px"> ' . e($model->user->name);
        return model_link($value, $model->user);
    }
}

if (!function_exists('replay_topic_output')) {
    function replay_topic_output($value, $model) {
//        return '<div style="max-width:260px">' . model_admin_link($model->topic->title, $model->topic) . '</div>';
        return '<div style="max-width:260px">' . model_admin_link(e($model->topic->title), $model->topic) . '</div>';
    }
}

if (!function_exists('before_save')) {
    function before_save(&$data)
    {
        // 为网站名称加上后缀，加上判断是为了防止多次添加
        if (strpos($data['site_name'], 'Powered by LaraBBS') === false) {
            $data['site_name'] .= ' - Powered by LaraBBS';
        }
    }
}

if (!function_exists('clear_cache_action')) {
    function clear_cache_action(&$data)
    {
        \Artisan::call('cache:clear');
        return true;
    }
}
