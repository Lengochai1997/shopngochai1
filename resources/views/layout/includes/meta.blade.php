<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta charset="utf-8"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="description" content="{{ isset($config['description']) ? $config['description'] : '' }}">
<meta name="keywords" content="{{ isset($config['keyword']) ? $config['keyword'] : '' }}">
<meta content="havt" name="author"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{ isset($config['domain']) ? $config['domain'] : '' }}"/>
<meta property="og:title" content="{{ isset($config['title']) ? $config['title'] : '' }}"/>
<meta property="og:description" content="{{ isset($config['description']) ? $config['description'] : '' }}"/>
<link rel="shortcut icon" href="{{ isset($logo) ? $logo : '' }}" type="image/x-icon">
